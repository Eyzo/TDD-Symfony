<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ExceptionSubscriber implements EventSubscriberInterface
{

  const MAIL_FROM = 'toto@gmail.com';
  const MAIL_TO = 'admin@gmail.com';

    public function __construct(protected MailerInterface $mailer){}

  public static function getSubscribedEvents(): array
    {
      return [
        ExceptionEvent::class => 'onKernelException'
      ];
    }

    public function onKernelException(ExceptionEvent $event)
    {
//        $mail = new Email();
//        $mail->from(self::MAIL_FROM)
//          ->to(self::MAIL_TO)
//          ->text($event->getThrowable()->getMessage());
//        $this->mailer->send($mail);
    }
}
