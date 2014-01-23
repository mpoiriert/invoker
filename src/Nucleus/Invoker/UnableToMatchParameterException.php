<?php

namespace Nucleus\Invoker;


class UnableToMatchParameterException extends \RuntimeException
{
    /**
     * Method to format the exception message
     *
     * @param $callable
     * @param $parameterName
     * @return string
     */
    public static function formatMessage($callable, $parameterName)
    {

        switch (true) {
            case is_array($callable):
                $message = sprintf('%s::%s()', get_class($callable[0]), $callable[1]);
                break;
            case is_object($callable):
                $message = get_class($callable);
                break;
            default:
                $message = (string)$callable;
                break;
        }


        return 'Unable to match parameter named [' . $parameterName . '] for the callable [' . $message . ']';
    }
}