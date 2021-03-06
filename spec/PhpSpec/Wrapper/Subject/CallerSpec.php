<?php

namespace spec\PhpSpec\Wrapper\Subject;

use PhpSpec\Wrapper\Subject\WrappedObject;
use PhpSpec\Wrapper\Subject\Caller;
use PhpSpec\Wrapper\Wrapper;
use PhpSpec\Wrapper\Subject;

use PhpSpec\Matcher\MatcherInterface;
use PhpSpec\Loader\Node\ExampleNode;
use PhpSpec\Runner\MatcherManager;
use PhpSpec\Formatter\Presenter\PresenterInterface;

use PhpSpec\Event\ExpectationEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CallerSpec extends ObjectBehavior
{
    function let(WrappedObject $wrappedObject, ExampleNode $example,
        EventDispatcherInterface $dispatcher, PresenterInterface $presenter,
        MatcherManager $matchers, Wrapper $wrapper)
    {
        $this->beConstructedWith($wrappedObject, $example, $dispatcher,
            $presenter,$matchers, $wrapper);
    }

    function it_dispatches_method_call_events(EventDispatcherInterface $dispatcher, WrappedObject $wrappedObject)
    {
        $wrappedObject->isInstantiated()->willReturn(true);
        $wrappedObject->getInstance()->willReturn(new \SplFileInfo(__FILE__));

        $dispatcher->dispatch(
            'beforeMethodCall',
            Argument::type('PhpSpec\Event\MethodCallEvent')
        )->shouldBeCalled();

        $dispatcher->dispatch(
            'afterMethodCall',
            Argument::type('PhpSpec\Event\MethodCallEvent')
        )->shouldBeCalled();

        $this->call('getPathname');
    }
}
