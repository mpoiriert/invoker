<?php

namespace Nucleus\Invoker;

/**
 * @author Martin Poirier Théorêt <mpoiriert@gmail.com>
 */
interface IInvoker
{
    /**
     * The service name use as a reference in nucleus
     */
    const NUCLEUS_SERVICE_NAME = 'nucleus.invoker';

    /**
     * Method to call the $callable by trying to find the best parameters pass to the invoke function.
     *
     * Named parameter that match the type will have precedence on other parameter that match the class.
     *
     * If two of more parameters do not match the name but do match the type, the invoke call will have
     * unpredicted behavior.
     * 
     * @param mixed $callable
     * @param array $parameters
     *
     * @throws \RuntimeException If the invoker is not able to map parameters to the callable
     *
     * @return mixed
     */
    public function invoke($callable,array $parameters = array());
}
