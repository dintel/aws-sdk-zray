<?php
namespace AwsSdkZray;

class AwsSdkZray {
    public function onEnter($context, &$storage) {
        // called when we enter the traced_method
    }

    public function onLeave($context, &$storage) {
        $awsService = substr(strrchr(get_class($context['this']), '\\'), 1);
        if (substr($awsService, -6, 6) === 'Client') {
            $awsService = substr($awsService, 0, -6);
        }
        $storage[$awsService][] = [
            $context['functionArgs'][0] => [
                'arguments' => $context['functionArgs'][1],
                'result' => $context['returnValue'],
            ],
        ];
    }
}

// Create new extension - disabled
$zre = new \ZRayExtension('AwsSdkZray');

// set additional data such as logo
$zre->setMetadata(array(
	'logo' => __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'logo.png',
));

// start tracing only when 'your_application_initial_method' is called, e.g. 'Mage::run()'
$awsSdkZray = new AwsSdkZray();
$zre->setEnabledAfter('Aws\Common\Aws::factory');

$zre->setEnabledAfter('Aws\CloudFront\CloudFrontClient::factory');
$zre->setEnabledAfter('Aws\CloudHsm\CloudHsmClient::factory');
$zre->setEnabledAfter('Aws\CloudSearch\CloudSearchClient::factory');
$zre->setEnabledAfter('Aws\CloudSearchDomain\CloudSearchDomainClient::factory');
$zre->setEnabledAfter('Aws\CloudWatch\CloudWatchClient::factory');
$zre->setEnabledAfter('Aws\CloudWatchLogs\CloudWatchLogsClient::factory');
$zre->setEnabledAfter('Aws\CognitoIdentity\CognitoIdentityClient::factory');
$zre->setEnabledAfter('Aws\CognitoSync\CognitoSyncClient::factory');
$zre->setEnabledAfter('Aws\ConfigService\ConfigServiceClient::factory');
$zre->setEnabledAfter('Aws\DynamoDb\DynamoDbClient::factory');
$zre->setEnabledAfter('Aws\Ec2\Ec2Client::factory');
$zre->setEnabledAfter('Aws\Ecs\EcsClient::factory');
$zre->setEnabledAfter('Aws\Emr\EmrClient::factory');
$zre->setEnabledAfter('Aws\ElasticTranscoder\ElasticTranscoderClient::factory');
$zre->setEnabledAfter('Aws\ElastiCache\ElastiCacheClient::factory');
$zre->setEnabledAfter('Aws\Glacier\GlacierClient::factory');
$zre->setEnabledAfter('Aws\Kinesis\KinesisClient::factory');
$zre->setEnabledAfter('Aws\Kms\KmsClient::factory');
$zre->setEnabledAfter('Aws\Redshift\RedshiftClient::factory');
$zre->setEnabledAfter('Aws\Rds\RdsClient::factory');
$zre->setEnabledAfter('Aws\Route53\Route53Client::factory');
$zre->setEnabledAfter('Aws\Route53Domains\Route53DomainsClient::factory');
$zre->setEnabledAfter('Aws\Ses\SesClient::factory');
$zre->setEnabledAfter('Aws\Sns\SnsClient::factory');
$zre->setEnabledAfter('Aws\Sqs\SqsClient::factory');
$zre->setEnabledAfter('Aws\S3\S3Client::factory');
$zre->setEnabledAfter('Aws\Swf\SwfClient::factory');
$zre->setEnabledAfter('Aws\SimpleDb\SimpleDbClient::factory');
$zre->setEnabledAfter('Aws\AutoScaling\AutoScalingClient::factory');
$zre->setEnabledAfter('Aws\CloudFormation\CloudFormationClient::factory');
$zre->setEnabledAfter('Aws\CloudTrail\CloudTrailClient::factory');
$zre->setEnabledAfter('Aws\CodeDeploy\CodeDeployClient::factory');
$zre->setEnabledAfter('Aws\DataPipeline\DataPipelineClient::factory');
$zre->setEnabledAfter('Aws\DirectConnect\DirectConnectClient::factory');
$zre->setEnabledAfter('Aws\ElasticBeanstalk\ElasticBeanstalkClient::factory');
$zre->setEnabledAfter('Aws\Iam\IamClient::factory');
$zre->setEnabledAfter('Aws\ImportExport\ImportExportClient::factory');
$zre->setEnabledAfter('Aws\Lambda\LambdaClient::factory');
$zre->setEnabledAfter('Aws\OpsWorks\OpsWorksClient::factory');
$zre->setEnabledAfter('Aws\Sts\StsClient::factory');
$zre->setEnabledAfter('Aws\StorageGateway\StorageGatewayClient::factory');
$zre->setEnabledAfter('Aws\Support\SupportClient::factory');
$zre->setEnabledAfter('Aws\ElasticLoadBalancing\ElasticLoadBalancingClient::factory');

$zre->traceFunction('Aws\Common\Client\AbstractClient::__call', array($awsSdkZray, 'onEnter'), array($awsSdkZray, 'onLeave'));
