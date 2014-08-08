<?php

namespace Nucleus\Invoker;

interface IParameterValueProvider
{
    /**
     * Filter tye parameter value.
     *
     * @param ParameterValue $parameterValue
     * @return void
     */
    public function filterParameter(ParameterValue $parameterValue);
} 