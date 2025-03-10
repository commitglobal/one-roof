locals {
  namespace = "one-roof-${var.env}"
  image = {
    repo = "commitglobal/one-roof",
    tag  = "0.1.0"
  }

  domains = [
    var.domain_name,
    # "www.${var.domain_name}",
  ]

  networking = {
    cidr_block = "10.0.0.0/16"

    public_subnets = [
      "10.0.1.0/24",
      "10.0.2.0/24",
      "10.0.3.0/24"
    ]

    private_subnets = [
      "10.0.4.0/24",
      "10.0.5.0/24",
      "10.0.6.0/24"
    ]
  }
}
