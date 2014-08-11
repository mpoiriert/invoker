<?php

namespace Nucleus\Invoker;

class DefaultParameterValueProvider implements IParameterValueProvider
{
    /**
     * Filter tye parameter value.
     *
     * @param ParameterValue $parameterValue
     * @return void
     */
    public function provideParameterValue(ParameterValue $parameterValue)
    {
        if($parameterValue->isDefaultValueAvailable()) {
            $parameterValue->setValue($parameterValue->getDefaultValue());
        }
    }
}