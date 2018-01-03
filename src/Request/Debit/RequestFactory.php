<?php

namespace ArvPayoneApi\Request\Debit;

use ArvPayoneApi\Lib\Version;
use ArvPayoneApi\Request\Parts\Config;
use ArvPayoneApi\Request\Parts\SystemInfo;
use ArvPayoneApi\Request\RequestDataContract;
use ArvPayoneApi\Request\RequestFactoryContract;

class RequestFactory implements RequestFactoryContract
{
    /**
     * @param string $paymentMethod
     * @param bool $referenceId
     * @param array $data
     *
     * @return RequestDataContract
     */
    public static function create($paymentMethod, $referenceId = false, $data = []): RequestDataContract
    {
        $context = $data['context'];
        $config = new Config(
            $context['aid'],
            $context['mid'],
            $context['portalid'],
            $context['key'],
            $context['mode']
        );

        $order = $data['order'];

        $systemInfoData = $data['systemInfo'];
        $systemInfo = new SystemInfo(
            $systemInfoData['vendor'],
            Version::getVersion(),
            $systemInfoData['module'],
            $systemInfoData['module_version']
        );

        return new Debit(
            $config,
            $referenceId,
            $order['amount'],
            $order['currency'],
            $systemInfo,
            $context['sequencenumber']
        );
    }
}
