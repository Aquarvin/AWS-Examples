<?php
require __DIR__ . '/vendor/autoload.php';

use Aws\S3\S3Client;

class S3Example
{

    /**
     * @var S3Client
     */
    private $s3client;
    /**
     * @var string
     */
    private $bucketName;

    public function createClient(): void
    {
        $region = 'eu-central-1';

        $this->s3client = new S3Client([
            'region' => $region,
        ]);
    }

    public function createBucket($name): void
    {
        $this->bucketName = $name;
        if (!$this->s3client) {
            $this->createClient();
        }

        try {
            $this->s3client->createBucket([
                'Bucket' => $this->bucketName
            ]);
            echo "Created bucket named: $this->bucketName \n";
        } catch (Exception $exception) {
            echo "Failed to create bucket $this->bucketName with error: " . $exception->getMessage();
            exit("Please fix error with bucket creation before continuing.");
        }
    }

    /**
     * @return void
     */
    public function putObjectToBucket(): void
    {
        $numberOfFiles = rand(1, 6);
        for ($i = 0; $i < $numberOfFiles; $i++) {
            $fileName = "file_$i.txt";
            $outputPath = "/tmp/$fileName";
            file_put_contents($outputPath, uniqid());
            try {
                $this->s3client->putObject([
                    'Bucket' => $this->bucketName,
                    'Key' => $fileName,
                    'SourceFile' => $outputPath
                ]);
                echo "Uploaded $fileName to $this->bucketName.\n";
            } catch (Exception $exception) {
                echo "Failed to upload $fileName with error: " . $exception->getMessage();
                exit("Please fix error with file upload before continuing.");
            }
        }
    }
}

$s3Example = new S3Example();

$bucketName = $argv[1] ?? null;
if ($bucketName) {
    $s3Example->createBucket($bucketName);
    $s3Example->putObjectToBucket();
} else {
    echo "Put Bucket Name as a first argument.\n";
}

