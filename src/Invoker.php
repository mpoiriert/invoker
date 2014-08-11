<?php

namespace Nucleus\Invoker;

use ReflectionParameter;

/**
 * @author Martin Poirier Théorêt <mpoiriert@gmail.com>
 */
class Invoker implements IInvoker
{
    private $providers = array();

    public function __construct()
    {
        $this->registerParameterValueProvider(new DefaultParameterValueProvider());
    }

    /**
     * @param $callable
     * @param array $namedParameters
     * @param array $typedParameters
     * @return mixed
     * @throws \RuntimeException
     */
    public function invoke($callable, array $parameters = array())
    {
        $neededParameters = $this->getReflectionParameters($callable);
        $arguments = array();
        foreach ($neededParameters as $param) {
            if (array_key_exists($param->name, $parameters) && $this->parameterMatchClass($param,$parameters[$param->name])) {
                $parameterValue = $parameters[$param->name];
                $arguments[] = $parameterValue;
                continue;
            }

            if ($param->getClass()) {
                $found = false;
                foreach ($parameters as $typedParameter) {
                    if ($this->parameterMatchClass($param,$typedParameter)) {
                        $arguments[] = $typedParameter;
                        $found = true;
                        break;
                    }
                }
                if ($found) {
                    continue;
                }
            }

            $arguments[] = $this->getValueFromProvider($param, $callable);
        }

        return call_user_func_array($callable, $arguments);
    }

    private function getValueFromProvider(ReflectionParameter $param, $callable)
    {
        $parameterValue = new ParameterValue($param);
        foreach($this->providers as $providers) {
            foreach($providers as $provider) {
                /* @var $provider IParameterValueProvider */
                $provider->provideParameterValue($parameterValue);
                if($parameterValue->isProcessed()) {
                    return $parameterValue->getValue();
                }
            }
        }
        throw new UnableToMatchParameterException(
            UnableToMatchParameterException::formatMessage($callable,$param->name)
        );
    }

    private function parameterMatchClass(ReflectionParameter $param, $parameter)
    {
        if (!$param->getClass()) {
            return true;
        }

        if(!is_object($parameter)) {
            return false;
        }

        return $param->getClass()->isInstance($parameter);
    }

    /**
     * @param mixed $callable
     * return \ReflectionParameter[]
     */
    private function getReflectionParameters($callable)
    {
        if (is_array($callable)) {
            $reflectionCallable = new \ReflectionMethod($callable[0], $callable[1]);
        } elseif (is_object($callable) && !$callable instanceof \Closure) {
            $reflectionObject = new \ReflectionObject($callable);
            $reflectionCallable = $reflectionObject->getMethod('__invoke');
        } else {
            $reflectionCallable = new \ReflectionFunction($callable);
        }

        return $reflectionCallable->getParameters();
    }

    /**
     * @param IParameterValueProvider $parameterValueProvider
     * @param int $priority The priority of the parameter value provider. Lowest is the first one that will be executed
     *
     * @return voic
     */
    public function registerParameterValueProvider(IParameterValueProvider $parameterValueProvider, $priority = 0)
    {
        $this->providers[(int)$priority][] = $parameterValueProvider;
        ksort($this->providers);
    }
}
