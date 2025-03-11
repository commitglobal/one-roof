data "aws_sesv2_email_identity" "main" {
  provider       = aws.ses
  count          = var.ses_domain != null ? 1 : 0
  email_identity = var.ses_domain
}

data "aws_sesv2_configuration_set" "main" {
  provider               = aws.ses
  count                  = var.ses_configuration_set != null ? 1 : 0
  configuration_set_name = var.ses_configuration_set
}
