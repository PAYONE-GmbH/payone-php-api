<?php

namespace ArvPayoneApi\Request\Authorization;

use ArvPayoneApi\Request\AuthorizationAbstract;
use ArvPayoneApi\Request\ClearingTypes;
use ArvPayoneApi\Request\Parts\Config;
use ArvPayoneApi\Request\Parts\Customer;
use ArvPayoneApi\Request\Parts\SystemInfo;
use ArvPayoneApi\Request\RequestDataContract;
use ArvPayoneApi\Request\Types;

/**
 * Class CashOnDelivery
 */
class CashOnDelivery extends AuthorizationAbstract implements RequestDataContract
{
    /**
     * @var string
     */
    private $shippingprovider;

    /**
     * CashOnDelivery constructor.
     *
     * @param Config $config
     * @param string $orderId
     * @param int $amount
     * @param string $currency
     * @param Customer $customer
     * @param string $shippingprovider
     * @param SystemInfo $info
     */
    public function __construct(
        Config $config,
        $orderId,
        int $amount,
        $currency,
        Customer $customer,
        $shippingprovider,
        SystemInfo $info
    ) {
        parent::__construct(
            $config,
            $customer,
            Types::AUTHORIZATION,
            ClearingTypes::COD,
            $info,
            $orderId,
            $amount,
            $currency
        );
        $this->shippingprovider = $shippingprovider;
    }

    /**
     * Getter for Shippingprovider
     *
     * @return mixed
     */
    public function getShippingprovider()
    {
        return $this->shippingprovider;
    }
}
