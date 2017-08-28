<?php

namespace ArvPayoneApi\Request\Parts;

use ArvPayoneApi\Request\RequestDataContract;

class CustomerAddress implements RequestDataContract, \JsonSerializable
{
    private $street;
    private $addressaddition;
    private $zip;
    private $city;
    private $country;

    /**
     * CustomerAddress constructor.
     *
     * @param $street
     * @param $addressaddition
     * @param $zip
     * @param $city
     * @param $country
     */
    public function __construct($street, $addressaddition, $zip, $city, $country)
    {
        $this->street = $street;
        $this->addressaddition = $addressaddition;
        $this->zip = $zip;
        $this->city = $city;
        $this->country = $country;
    }

    public function jsonSerialize()
    {
        return [
            'street' => $this->street,
            'addressaddition' => $this->addressaddition,
            'zip' => $this->zip,
            'city' => $this->city,
            'country' => $this->country,
        ];
    }
}
