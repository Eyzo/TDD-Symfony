<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    public function __construct(protected MailerInterface $mailer){}

  #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('base.html.twig');
    }

    #[Route('/auth', name: 'auth')]
    #[IsGranted("ROLE_USER")]
    public function auth(): Response
    {
      return new Response();
    }

    #[Route('/mail', name: 'mail')]
    public function mail()
    {
      $mail = new Email();
      $mail->from('admin@gmail.com')
        ->to('toto@gmail.com')
        ->text('Email de test');
      $this->mailer->send($mail);
      return new Response();
    }
}
