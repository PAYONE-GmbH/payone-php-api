<?php

namespace ArvPayoneApi\Request;

use ArvPayoneApi\Request\Parts\Config;
use ArvPayoneApi\Request\Parts\Customer;
use ArvPayoneApi\Request\Parts\CustomerAddress;
use ArvPayoneApi\Request\PreAuthorization\CashOnDelivery;
use ArvPayoneApi\Request\PreAuthorization\Invoice;
use ArvPayoneApi\Request\PreAuthorization\PrePayment;

class RequestFactory
{
    /**
     * @param string $requestType
     * @param string $paymentMethod
     * @param string|bool $referenceId Reference to previous request
     * @param array $data
     *
     * @throws \Exception
     *
     * @return RequestDataContract
     */
    public static function create($requestType, $paymentMethod, $referenceId = false, $data = []): RequestDataContract
    {
        $context = $data['context'];
        $config = new Config(
            $context['aid'],
            $context['mid'],
            $context['portalid'],
            $context['key'],
            $context['mode']
        );

        switch ($requestType) {
            case Types::PREAUTHORIZATION:
                $customerAddressData = $data['shippingAddress'];
                $customerAddress = new CustomerAddress(
                    $customerAddressData['street'] . ' ' . $customerAddressData['houseNumber'],
                    $customerAddressData['addressaddition'],
                    $customerAddressData['postalCode'],
                    $customerAddressData['town'],
                    $customerAddressData['country']
                );
                $customerData = $data['customer'];
                $customer = new Customer(
                    $customerData['title'],
                    $customerData['firstname'],
                    $customerData['lastname'],
                    $customerAddress,
                    $customerData['email'],
                    $customerData['telephonenumber'],
                    $customerData['birthday'],
                    $customerData['language'],
                    $customerData['gender'],
                    $customerData['ip']
                );
                $order = $data['order'];
                $basket = $data['basket'];
                switch ($paymentMethod) {
                    case 'Invoice':
                        return new Invoice(
                            $config,
                            $order['orderId'],
                            $basket['basketAmount'],
                            $basket['currency'],
                            $customer
                        );
                    case 'PrePayment':
                        return new PrePayment(
                            $config,
                            $order['orderId'],
                            $basket['basketAmount'],
                            $basket['currency'],
                            $customer
                        );
                    case 'CashOnDelivery':
                        return new CashOnDelivery(
                            $config,
                            $order['orderId'],
                            $basket['basketAmount'],
                            $basket['currency'],
                            $customer,
                            $data['shippingProvider']['name']
                        );
                }
                break;
            case Types::CAPTURE:
                $order = $data['order'];

                return new Capture(
                    $config,
                    $referenceId,
                    $order['amount'],
                    $order['currency'],
                    $context['capturemode'],
                    $context['sequencenumber']
                );
                break;
        }
        throw new \Exception('Uknown request type ' . $requestType . ' for ' . $paymentMethod . ' payment method.');
    }
}
