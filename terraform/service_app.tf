module "ecs_app" {
  source = "./modules/ecs-service"

  depends_on = [
    module.ecs_cluster
  ]

  name         = "${local.namespace}-app"
  cluster_name = module.ecs_cluster.cluster_name
  min_capacity = 2
  max_capacity = 4

  deployment_minimum_healthy_percent = 50
  deployment_maximum_percent         = 200

  image_repo = local.image.repo
  image_tag  = local.image.tag

  use_load_balancer       = true
  lb_dns_name             = aws_lb.main.dns_name
  lb_zone_id              = aws_lb.main.zone_id
  lb_vpc_id               = aws_vpc.main.id
  lb_listener_arn         = aws_lb_listener.http.arn
  lb_hosts                = [var.domain_name]
  lb_health_check_enabled = true
  lb_path                 = "/up"

  container_memory_soft_limit = 768
  container_memory_hard_limit = 1024


  log_group_name                 = module.ecs_cluster.log_group_name
  service_discovery_namespace_id = module.ecs_cluster.service_discovery_namespace_id

  container_port          = 8080
  network_mode            = "awsvpc"
  network_security_groups = [aws_security_group.ecs.id]
  network_subnets         = [aws_subnet.private.0.id]

  task_role_arn          = aws_iam_role.ecs_task_role.arn
  enable_execute_command = var.enable_execute_command

  predefined_metric_type = "ECSServiceAverageCPUUtilization"
  target_value           = 85

  ordered_placement_strategy = [
    {
      type  = "spread"
      field = "instanceId"
    },
    {
      type  = "binpack"
      field = "memory"
    }
  ]

  environment = [
    {
      name  = "APP_NAME"
      value = "UnTecho"
    },
    {
      name  = "APP_ENV"
      value = var.env
    },
    {
      name  = "APP_DEBUG"
      value = tostring(false)
    },
    {
      name  = "APP_URL"
      value = "https://${var.domain_name}"
    },
    {
      name  = "AWS_DEFAULT_REGION"
      value = var.region
    },
    {
      name  = "AWS_SES_REGION"
      value = var.ses_region
    },
    {
      name  = "MAIL_MAILER"
      value = "ses"
    },
    {
      name  = "MAIL_FROM_ADDRESS"
      value = "no-reply@${var.ses_domain}"
    },
    {
      name  = "FILESYSTEM_DISK"
      value = "s3"
    },
    {
      name  = "FILAMENT_FILESYSTEM_DISK"
      value = "s3"
    },
    {
      name  = "AWS_BUCKET"
      value = module.s3_private.bucket
    },
    {
      name  = "AWS_URL"
      value = "https://${var.domain_name}"
    },
    {
      name  = "SENTRY_TRACES_SAMPLE_RATE"
      value = 0.3
    },
    {
      name  = "SENTRY_PROFILES_SAMPLE_RATE"
      value = 0.5
    },
    {
      name  = "SCOUT_DRIVER",
      value = "database"
    },
    {
      name  = "PHP_PM_MAX_CHILDREN",
      value = 128
    },
  ]

  secrets = [
    {
      name      = "APP_KEY"
      valueFrom = aws_secretsmanager_secret.app_key.arn
    },
    {
      name      = "DB_CONNECTION"
      valueFrom = "${aws_secretsmanager_secret.rds.arn}:engine::"
    },
    {
      name      = "DB_HOST"
      valueFrom = "${aws_secretsmanager_secret.rds.arn}:host::"
    },
    {
      name      = "DB_PORT"
      valueFrom = "${aws_secretsmanager_secret.rds.arn}:port::"
    },
    {
      name      = "DB_DATABASE"
      valueFrom = "${aws_secretsmanager_secret.rds.arn}:database::"
    },
    {
      name      = "DB_USERNAME"
      valueFrom = "${aws_secretsmanager_secret.rds.arn}:username::"
    },
    {
      name      = "DB_PASSWORD"
      valueFrom = "${aws_secretsmanager_secret.rds.arn}:password::"
    },
    # {
    #   name      = "TYPESENSE_HOST"
    #   valueFrom = "${aws_secretsmanager_secret.typesense.arn}:host::"
    # },
    # {
    #   name      = "TYPESENSE_PORT"
    #   valueFrom = "${aws_secretsmanager_secret.typesense.arn}:port::"
    # },
    # {
    #   name      = "TYPESENSE_API_KEY"
    #   valueFrom = "${aws_secretsmanager_secret.typesense.arn}:key::"
    # },
    {
      name      = "SENTRY_DSN"
      valueFrom = aws_secretsmanager_secret.sentry_dsn.arn
    },

  ]

  allowed_secrets = [
    aws_secretsmanager_secret.app_key.arn,
    # aws_secretsmanager_secret.typesense.arn,
    aws_secretsmanager_secret.sentry_dsn.arn,
    aws_secretsmanager_secret.rds.arn,
  ]
}

module "s3_private" {
  source = "./modules/s3"

  enable_versioning = var.env == "production"

  name   = "${local.namespace}-private"
  policy = data.aws_iam_policy_document.s3_cloudfront_private.json
}

resource "aws_s3_bucket_cors_configuration" "s3_private" {
  bucket = module.s3_private.bucket

  cors_rule {
    allowed_headers = ["*"]
    allowed_methods = ["GET", "PUT", "POST"]
    allowed_origins = ["https://${var.domain_name}"]
    expose_headers  = ["ETag"]
    max_age_seconds = 86400
  }
}

resource "aws_secretsmanager_secret" "app_key" {
  name = "${local.namespace}-secret_key-${random_string.secrets_suffix.result}"
}

resource "aws_secretsmanager_secret_version" "app_key" {
  secret_id     = aws_secretsmanager_secret.app_key.id
  secret_string = random_password.app_key.result
}

resource "aws_secretsmanager_secret" "typesense" {
  name = "${local.namespace}-typesense-${random_string.secrets_suffix.result}"
}

resource "aws_secretsmanager_secret_version" "typesense" {
  secret_id = aws_secretsmanager_secret.typesense.id

  secret_string = jsonencode({
    "host" = "10.0.6.178",
    "port" = "8108",
    "key"  = "xyz"
  })
}

resource "aws_secretsmanager_secret" "sentry_dsn" {
  name = "${local.namespace}-sentry_dsn-${random_string.secrets_suffix.result}"
}

resource "aws_secretsmanager_secret_version" "sentry_dsn" {
  secret_id     = aws_secretsmanager_secret.sentry_dsn.id
  secret_string = var.sentry_dsn
}

resource "random_password" "app_key" {
  length  = 32
  special = true

  lifecycle {
    ignore_changes = [
      length,
      special
    ]
  }
}
