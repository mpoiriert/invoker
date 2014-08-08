<?php

namespace Nucleus\Invoker;

use ReflectionParameter;

class ParameterValue
{
    /**
     * @var ReflectionParameter
     */
    private $reflectionParameter;

    private $value;

    private $processed;

    public function __construct(ReflectionParameter $reflectionParameter)
    {
        $this->reflectionParameter = $reflectionParameter;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
        $this->processed = true;
    }

    public function isProcessed()
    {
        return $this->processed;
    }

    public function getClass()
    {
        return $this->reflectionParameter->getClass();
    }

    public function getName()
    {
        return $this->reflectionParameter->getName();
    }

    public function isDefaultValueAvailable()
    {
        return $this->reflectionParameter->isDefaultValueAvailable();
    }

    public function getDefaultValue()
    {
        return $this->reflectionParameter->getDefaultValue();
    }
} 