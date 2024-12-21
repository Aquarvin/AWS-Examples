require 'aws-sdk-s3' # AWS SDK for interacting with S3
require 'pry' # Debugging tool (optional, can be removed if not needed)
require 'securerandom' # Library for generating unique identifiers

# Get the bucket name from environment variables
bucket_name = ENV['BUCKET_NAME']
# Define the AWS region where the bucket will be created
region = 'eu-central-1'

# Output the bucket name to the console (for debugging purposes)
puts bucket_name

# Initialize the S3 client
client = Aws::S3::Client.new

# Create a new S3 bucket in the specified region
resp = client.create_bucket({
  bucket: bucket_name,
  create_bucket_configuration: {
    location_constraint: region
  }
})
#binding.pry
# Generate a random number of files (between 1 and 6) to create and upload
number_of_files = 1 + rand(6)
puts "number_of_files: #{number_of_files}"

# Iterate to create and upload each file
number_of_files.times.each do |i|
  puts "i: #{i}" # Output the current iteration index

  # Define the filename and local file path
  filename = "file_#{i}.txt"
  output_path = "/tmp/#{filename}"

  # Open the file for writing and write a unique identifier to it
  File.open(output_path, "w") do |f|
    f.write SecureRandom.uuid
  end

  # Open the file in binary read mode and upload it to the S3 bucket
  File.open(output_path, 'rb') do |file|
    client.put_object(
      bucket: bucket_name, # The name of the S3 bucket
      key: filename, # The key (name) of the object in the bucket
      body: file # The file content to upload
    )
  end
end

