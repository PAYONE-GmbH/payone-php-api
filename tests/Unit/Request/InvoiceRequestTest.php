<?php

namespace ArvPayoneApi\Request;

use ArvPayoneApi\Mocks\Config;
use ArvPayoneApi\Mocks\RequestMockFactory;
use ArvPayoneApi\Request\Capture\RequestFactory as CaptureFactory;
use ArvPayoneApi\Request\PreAuthorization\RequestFactory as PreAuthFactory;

/**
 * Class RequestFactoryTest
 */
class RequestFactoryTest extends \PHPUnit_Framework_TestCase
{
    private $data;

    private $paymentMethod = PaymentTypes::PAYONE_INVOICE;

    public function setUp()
    {
        $order = [];
        $order['orderId'] = 'order-123657';
        $order['amount'] = 10000;
        $order['currency'] = 'EUR';

        $basket = [];
        $basket['basketAmount'] = 10000;
        $basket['currency'] = 'EUR';
        $basket['shippingAmount'] = 0;
        $basket['itemSum'] = '840.34';

        $basketItem = [];
        $basketItem['name'] = 'Test Item';
        $basketItem['quantity'] = '1';
        $basketItem['itemId'] = '123124';
        $basketItem['price'] = 10000;

        $address = [];
        $address['town'] = 'Kiel';
        $address['postalCode'] = '24118';
        $address['firstname'] = 'Paul';
        $address['lastname'] = 'Neverpayer';
        $address['street'] = 'Fraunhoferstraße';
        $address['houseNumber'] = '2-4';
        $address['addressaddition'] = 'EG';
        $address['country'] = 'DE';

        $customer = [];
        $customer['salutation'] = 'Herr';
        $customer['title'] = 'Dr.';
        $customer['firstname'] = 'Paul';
        $customer['lastname'] = 'Neverpayer';
        $customer['email'] = 'paul.neverpayer@payone.de';
        $customer['telephonenumber'] = '043125968500';
        $customer['birthday'] = '1970-02-04';
        $customer['language'] = 'de';
        $customer['gender'] = 'm';
        $customer['ip'] = '8.8.8.8';

        $context = Config::getConfig()['api_context'];
        $context['mode'] = 'test';

        $shippingProvider = [];
        $shippingProvider['name'] = 'DHL';

        $data['basket'] = $basket;
        $data['basketItems'][] = $basketItem;
        $data['shippingAddress'] = $address;
        $data['context'] = $context;
        $data['order'] = $order;
        $data['customer'] = $customer;
        $data['shippingProvider'] = $shippingProvider;

        $this->data = $data;
    }

    public function testPreAuthInvoiceSameAsMock()
    {
        $requestMockData = RequestMockFactory::getRequestData($this->paymentMethod, Types::PREAUTHORIZATION,
            true);
        $requestData = PreAuthFactory::create($this->paymentMethod, false, $this->data);
        self::assertEquals(
            $requestMockData,
            $requestData->jsonSerialize(),
            'Differences: ' . PHP_EOL . print_r(
                array_diff($requestMockData, $requestData->jsonSerialize()) +
                array_diff($requestData->jsonSerialize(), $requestMockData),
                true)
        );
    }

    public function testCaptureInvoiceSameAsMock()
    {
        $order = [];
        $order['orderId'] = 'order-123657';
        $order['amount'] = 10000;
        $order['currency'] = 'EUR';
        $context = Config::getConfig()['api_context'];
        $context['capturemode'] = 'completed';
        $context['sequencenumber'] = 1;
        $context['txid'] = 'preAuthId';
        $context['mode'] = 'test';

        $data = [];
        $data['context'] = $context;
        $data['order'] = $order;

        $requestMockData = RequestMockFactory::getRequestData($this->paymentMethod, Types::CAPTURE, true);
        $requestData = CaptureFactory::create($this->paymentMethod, $requestMockData['txid'],
            $data)->jsonSerialize();

        self::assertEquals(
            $requestMockData,
            $requestData,
            'Differences: ' . PHP_EOL . print_r(array_diff($requestMockData, $requestData), true)
        );
    }
}
