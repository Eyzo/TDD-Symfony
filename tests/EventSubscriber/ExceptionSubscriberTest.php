<?php
namespace App\Tests\EventSubscriber;

use App\EventSubscriber\ExceptionSubscriber;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ExceptionSubscriberTest extends TestCase
{

  public function testIsSubscribedToExceptionEvent()
  {
    $mailer = $this->getMockBuilder(MailerInterface::class)->getMock();
    $subscriber = new ExceptionSubscriber($mailer);
    $this->assertArrayHasKey(ExceptionEvent::class, $subscriber::getSubscribedEvents());
  }

  public function dispatch($mailer)
  {
    $httpKernelInterface = $this->getMockBuilder(HttpKernelInterface::class)->getMock();
    $exceptionEvent = new ExceptionEvent($httpKernelInterface, new Request(), 1, new \Exception());
    $subscriber = new ExceptionSubscriber($mailer);
    $dispatcher = new EventDispatcher();
    $dispatcher->addSubscriber($subscriber);
    $dispatcher->dispatch($exceptionEvent);
  }

//  public function testIfMailerSendIsCalled()
//  {
//    $mailer = $this->getMockBuilder(MailerInterface::class)->getMock();
//    $mailer->expects($this->once())->method('send');
//    $this->dispatch($mailer);
//  }

//  public function testIfRightEmailIsSend()
//  {
//    $mail = new Email();
//    $mail->from(ExceptionSubscriber::MAIL_FROM)
//      ->to(ExceptionSubscriber::MAIL_TO)
//      ->text((new \Exception())->getMessage());
//    $mailer = $this->getMockBuilder(MailerInterface::class)->getMock();
//    $mailer->expects($this->once())->method('send')->with($mail);
//    $this->dispatch($mailer);
//  }

}
