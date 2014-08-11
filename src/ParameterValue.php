<?php

namespace Nucleus\Invoker;

use ReflectionParameter;

class ParameterValue
{
    /**
     * @var ReflectionParameter
     */
    private $reflectionParameter;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var boolean
     */
    private $processed;

    public function __construct(ReflectionParameter $reflectionParameter)
    {
        $this->reflectionParameter = $reflectionParameter;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the final value of this parameter
     *
     * @param $value
     */
    public function setValue($value)
    {
        $this->value = $value;
        $this->processed = true;
    }

    /**
     * @return boolean
     */
    public function isProcessed()
    {
        return $this->processed;
    }

    /**
     * Return the reflection class of the parameter if any
     *
     * @return \ReflectionClass
     */
    public function getClass()
    {
        return $this->reflectionParameter->getClass();
    }

    /**
     * Return the name of the parameter
     *
     * @return string
     */
    public function getName()
    {
        return $this->reflectionParameter->getName();
    }

    /**
     * Return if a default value is available or not
     *
     * @return bool
     */
    public function isDefaultValueAvailable()
    {
        return $this->reflectionParameter->isDefaultValueAvailable();
    }

    /**
     * Return the default value
     *
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->reflectionParameter->getDefaultValue();
    }
} 