<?php

namespace ArvPayoneApi\Request\Capture;

use ArvPayoneApi\Request\Capture;
use ArvPayoneApi\Request\Parts\Config;
use ArvPayoneApi\Request\RequestFactoryContract;

class RequestFactory implements RequestFactoryContract
{
    public static function create($paymentMethod, $referenceId = false, $data = [])
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

        return new Capture\Capture(
            $config,
            $referenceId,
            $order['amount'],
            $order['currency'],
            $context['capturemode'],
            $context['sequencenumber']
        );
    }
}