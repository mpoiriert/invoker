<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Martin
 * Date: 14-01-22
 * Time: 12:24
 * To change this template use File | Settings | File Templates.
 */

namespace Nucleus\Invoker\Tests;

use Nucleus\Invoker\Invoker;
use Nucleus\Invoker\UnableToMatchParameterException;

class InvokerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Nucleus\Invoker\IInvoker
     */
    private $invoker;

    protected function loadInvoker()
    {
        return new Invoker();
    }

    public function setUp()
    {
        $this->invoker = $this->loadInvoker();
        $this->assertInstanceOf('\Nucleus\Invoker\IInvoker',$this->invoker);
    }


    public function provideTestInvoke()
    {
        return array(
            array(function (\stdClass $object) { return $object; },array(new \stdClass()), new \stdClass()),
            array(function (\stdClass $object) { return; },array(), null,'object'),
            array(function ($param1,$param2) { return $param1 + $param2; },array('param1'=>1, 'param2'=>3), 4),
            array(function (\stdClass $object,$param) { return; },array('object'=>new \stdClass(), 'param'=>3), null),
            array(function (\stdClass $classDoesNotMatch) { return; },array('classDoesNotMatch'=>null), null, 'classDoesNotMatch')
        );
    }

    /**
     * @dataProvider provideTestInvoke
     */
    public function testInvoke($callable, $parameters = array(), $expectedResult = null, $expectExceptionOnParameter = null)
    {
        try {
            $result = $this->invoker->invoke($callable, $parameters);
        } catch (UnableToMatchParameterException $e) {
            if(!$expectExceptionOnParameter) {
                throw $e;
            }

            $this->assertEquals(
                UnableToMatchParameterException::formatMessage($callable, $expectExceptionOnParameter),
                $e->getMessage()
            );
            return;
        }

        if($expectExceptionOnParameter) {
            $this->fail('A exception of type [\Nucleus\Invoker\UnableToMatchParameterException] should have been thrown');
        }

        $this->assertEquals($expectedResult,$result);
    }
}