<?php

namespace ArvPayoneApi\Request\Parts;

use ArvPayoneApi\Request\RequestDataContract;

class SystemInfo implements RequestDataContract
{
    /** @var string */
    private $integratorName;

    /** @var string */
    private $integratorVersion;

    /** @var string */
    private $solutionName;

    /** @var string */
    private $solutionVersion;

    /**
     * SystemInfo constructor.
     *
     * @param $integratorName
     * @param $integratorVersion
     * @param $solutionName
     * @param $solutionVersion
     */
    public function __construct(
        $integratorName,
        $integratorVersion,
        $solutionName,
        $solutionVersion
    ) {
        $this->integratorName = $integratorName;
        $this->integratorVersion = $integratorVersion;
        $this->solutionName = $solutionName;
        $this->solutionVersion = $solutionVersion;
    }

    /**
     * Getter for IntegratorName
     *
     * @return string
     */
    public function getIntegratorName()
    {
        return $this->integratorName;
    }

    /**
     * Getter for IntegratorVersion
     *
     * @return string
     */
    public function getIntegratorVersion()
    {
        return $this->integratorVersion;
    }

    /**
     * Getter for SolutionName
     *
     * @return string
     */
    public function getSolutionName()
    {
        return $this->solutionName;
    }

    /**
     * Getter for SolutionVersion
     *
     * @return string
     */
    public function getSolutionVersion()
    {
        return $this->solutionVersion;
    }
}