<?php

namespace spec\Coduo\TuTu\Extension;

use Coduo\TuTu\Extension;
use PhpSpec\ObjectBehavior;
use Pimple\Container;
use Prophecy\Argument;

class MyExtension implements Extension
{
    /**
     * @var
     */
    private $argument;

    public function __construct($argument = null)
    {
        $this->argument = $argument;
    }

    /**
     * @param Container $container
     */
    public function load(Container $container)
    {
    }

    /**
     * @return mixed
     */
    public function getArgument()
    {
        return $this->argument;
    }
}

class InitializerSpec extends ObjectBehavior
{
    function it_throws_exception_when_string_is_not_valid_class()
    {
        $this->shouldThrow(new \InvalidArgumentException("asdasd is not valid class."))
            ->during('initialize', ['asdasd']);
    }

    function it_throws_exception_when_class_is_not_TuTu_extension()
    {
        $this->shouldThrow(new \InvalidArgumentException("Class \"stdClass\" should be an instance of Coduo\\TuTu\\Extension"))
            ->during('initialize', ['stdClass']);
    }

    function it_initialize_TuTu_extension()
    {
        $this->initialize('spec\Coduo\TuTu\Extension\MyExtension')->shouldReturnAnInstanceOf('Coduo\TuTu\Extension');
    }

    function it_initialize_TuTu_extension_with_constructor_arguments()
    {
        $extension = $this->initialize('spec\Coduo\TuTu\Extension\MyExtension', ['test']);
        $extension->shouldBeAnInstanceOf('Coduo\TuTu\Extension');
        $extension->getArgument()->shouldReturn('test');
    }
}
