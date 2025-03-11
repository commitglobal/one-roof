data "aws_iam_policy_document" "ecs_task" {
  statement {
    actions = [
      "s3:ListBucket",
      "s3:HeadBucket"
    ]

    resources = ["*"]
  }

  statement {
    actions = [
      "s3:ListBucket",
      "s3:GetObject",
      "s3:DeleteObject",
      "s3:GetObjectAcl",
      "s3:PutObjectAcl",
      "s3:PutObject"
    ]

    resources = [
      #   module.s3_public.arn,
      #   "${module.s3_public.arn}/*",
      module.s3_private.arn,
      "${module.s3_private.arn}/*"
    ]
  }

  statement {
    actions = [
      "ses:SendEmail",
      "ses:SendRawEmail"
    ]

    resources = compact([
      try(data.aws_sesv2_email_identity.main[0].arn, null),
      try(data.aws_sesv2_configuration_set.main[0].arn, null),
    ])
  }

  statement {
    actions = [
      "ses:GetAccount",
    ]

    resources = [
      "*"
    ]
  }
}

data "aws_iam_policy_document" "ecs_task_assume" {
  statement {
    actions = ["sts:AssumeRole"]

    principals {
      type        = "Service"
      identifiers = ["ecs-tasks.amazonaws.com"]
    }
  }
}

resource "aws_iam_role" "ecs_task_role" {
  name               = "${local.namespace}-ecs-task-role"
  assume_role_policy = data.aws_iam_policy_document.ecs_task_assume.json


  inline_policy {
    name   = "EcsTaskPolicy"
    policy = data.aws_iam_policy_document.ecs_task.json
  }
}

data "aws_iam_policy_document" "s3_cloudfront_private" {
  statement {
    actions   = ["s3:GetObject"]
    resources = ["${module.s3_private.arn}/*"]

    principals {
      type        = "Service"
      identifiers = ["cloudfront.amazonaws.com"]
    }

    condition {
      test     = "StringEquals"
      variable = "AWS:SourceArn"
      values   = [aws_cloudfront_distribution.main.arn]
    }
  }
}
