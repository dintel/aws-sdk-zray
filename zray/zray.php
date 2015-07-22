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
$zre->setEnabledAfter('Aws\Ec2\Ec2Client::factory');
$zre->traceFunction('Aws\Common\Client\AbstractClient::__call', array($awsSdkZray, 'onEnter'), array($awsSdkZray, 'onLeave'));
