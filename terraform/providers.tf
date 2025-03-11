terraform {
  required_version = "~> 1.10"

  required_providers {
    aws = {
      source  = "hashicorp/aws"
      version = "~> 5.76"
    }
  }

  cloud {
    organization = "commitglobal"

    workspaces {
      tags = {
        app = "untecho.mx",
      }
    }
  }
}

provider "aws" {
  region = var.region

  default_tags {
    tags = {
      app = "untecho.mx"
      env = var.env
    }
  }
}


provider "aws" {
  alias  = "acm"
  region = "us-east-1"

  default_tags {
    tags = {
      app = "untecho.mx"
      env = var.env
    }
  }
}

provider "aws" {
  alias  = "ses"
  region = try(var.ses_region, var.region)

  default_tags {
    tags = {
      app = "untecho.mx"
      env = var.env
    }
  }
}
