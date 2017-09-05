<?php

namespace ArvPayoneApi\Request;

class Types
{
    const PREAUTHORIZATION = 'preauthorization';
    const AUTHORIZATION = 'authorization';
    const CAPTURE = 'capture';
    const REFUND = 'refund';

    /**
     * @return mixed
     */
    public static function getRequestTypes()
    {
        $oClass = new \ReflectionClass(__CLASS__);

        return $oClass->getConstants();
    }
}
