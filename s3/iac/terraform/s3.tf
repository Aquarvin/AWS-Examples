# terraform init
# terraform plan
# terraform apply
resource "aws_s3_bucket" "my-s3-bucket" {
  # bucket = "my-tf-test-bucket"

  tags = {
    Name        = "My bucket"
    Environment = "Dev"
  }
}