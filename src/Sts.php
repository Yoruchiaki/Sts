<?php

namespace Yoruchiaki\Sts;


use Aliyun\Sts\AssumeRoleRequest as Request;
use Aliyun\Sts\Core\DefaultAcsClient;
use Aliyun\Sts\Core\Profile\DefaultProfile;

class Sts
{
    private $DefaultProfile;
    private $iClientProfile;
    private $roleRequest;

    public function __construct(Request $roleRequest)
    {
        $this->roleRequest = $roleRequest;
        $this->DefaultProfile = DefaultProfile::addEndpoint("cn-shenzhen", "cn-shenzhen", "Sts", "sts.cn-shenzhen.aliyuncs.com");
        $this->iClientProfile = DefaultProfile::getProfile("cn-shenzhen", config('sts.key'), config('sts.secret'));
    }

    public function queryToken()
    {
        $client = new DefaultAcsClient($this->iClientProfile);
        $roleArn = config('sts.role_arn');
        $policy = <<<POLICY
            {
              "Statement": [
                {
                  "Action": "oss:*",
                  "Effect": "Allow",
                  "Resource": "*"
                }
              ],
              "Version": "1"
            }
POLICY;
        $request = $this->roleRequest;
        $request->setRoleSessionName("client_name");
        $request->setRoleArn($roleArn);
        $request->setPolicy($policy);
        $request->setDurationSeconds(3600);
        return $client->getAcsResponse($request);
    }
}