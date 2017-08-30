<?php

namespace ArvPayoneApi\Request\Capture;

use ArvPayoneApi\Request\Parts\Config;
use ArvPayoneApi\Request\RequestDataAbstract;
use ArvPayoneApi\Request\RequestDataContract;
use ArvPayoneApi\Request\Types;

class Capture extends RequestDataAbstract implements RequestDataContract, \JsonSerializable
{
    private $txid;
    private $amount;
    private $currency;
    private $capturemode;
    private $sequencenumber;
    /**
     * @var Config
     */
    private $config;

    /**
     * Capture constructor.
     *
     * @param Config $config
     * @param string $txid
     * @param string $amount
     * @param string $currency
     * @param string $capturemode
     */
    public function __construct(Config $config, $txid, $amount, $currency, $capturemode, $sequencenumber = null)
    {
        $this->config = $config;
        $this->txid = $txid;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->capturemode = $capturemode;
        $this->sequencenumber = $sequencenumber;
    }

    public function jsonSerialize()
    {
        $data = [
            'request' => Types::CAPTURE,
            'txid' => $this->txid,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'capturemode' => $this->capturemode,
        ];
        if ($this->sequencenumber) {
            $data['sequencenumber'] = $this->sequencenumber;
        }

        return array_merge($this->config->jsonSerialize(), $data);
    }
}
