<?php

namespace Enqueue\Tests\Symfony\Consumption;

use Enqueue\Consumption\ChainExtension;
use Enqueue\Consumption\QueueConsumer;
use Enqueue\Psr\PsrContext;
use Enqueue\Symfony\Consumption\ConsumeMessagesCommand;
use Symfony\Component\Console\Tester\CommandTester;
use PHPUnit\Framework\TestCase;

class ConsumeMessagesCommandTest extends TestCase
{
    public function testCouldBeConstructedWithRequiredAttributes()
    {
        new ConsumeMessagesCommand($this->createQueueConsumerMock());
    }

    public function testShouldHaveCommandName()
    {
        $command = new ConsumeMessagesCommand($this->createQueueConsumerMock());

        $this->assertEquals('enqueue:transport:consume', $command->getName());
    }

    public function testShouldHaveExpectedOptions()
    {
        $command = new ConsumeMessagesCommand($this->createQueueConsumerMock());

        $options = $command->getDefinition()->getOptions();

        $this->assertCount(3, $options);
        $this->assertArrayHasKey('memory-limit', $options);
        $this->assertArrayHasKey('message-limit', $options);
        $this->assertArrayHasKey('time-limit', $options);
    }

    public function testShouldHaveExpectedAttributes()
    {
        $command = new ConsumeMessagesCommand($this->createQueueConsumerMock());

        $arguments = $command->getDefinition()->getArguments();

        $this->assertCount(0, $arguments);
    }

    public function testShouldExecuteConsumption()
    {
        $context = $this->createContextMock();
        $context
            ->expects($this->once())
            ->method('close')
        ;

        $consumer = $this->createQueueConsumerMock();
        $consumer
            ->expects($this->once())
            ->method('consume')
            ->with($this->isInstanceOf(ChainExtension::class))
        ;
        $consumer
            ->expects($this->once())
            ->method('getPsrContext')
            ->will($this->returnValue($context))
        ;

        $command = new ConsumeMessagesCommand($consumer);

        $tester = new CommandTester($command);
        $tester->execute([]);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|PsrContext
     */
    private function createContextMock()
    {
        return $this->createMock(PsrContext::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|QueueConsumer
     */
    private function createQueueConsumerMock()
    {
        return $this->createMock(QueueConsumer::class);
    }
}
