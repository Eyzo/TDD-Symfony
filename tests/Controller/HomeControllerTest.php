<?php
namespace App\Tests\Controller;

use App\DataFixtures\SimpleUserFixtures;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class HomeControllerTest extends WebTestCase
{

  public function dependencyGet($className): object
  {
    $container = self::getContainer();
    return $container->get($className);
  }

  public function createUser()
  {
    /** @var EntityManagerInterface $em */
    $em = $this->dependencyGet(EntityManagerInterface::class);
    /** @var SimpleUserFixtures $fixtures */
    $fixtures = $this->dependencyGet(SimpleUserFixtures::class);
    $fixtures->load($em);
  }

  /** Page simple */
  public function testIndex()
  {
    $client = self::createClient();
    $crawler = $client->request('GET','/');
    $this->assertResponseStatusCodeSame(200);
    $this->assertSelectorTextContains('h1','Hello World');
  }

  /** Page Auth sans les droits */
  public function testAuthNoAuthorize()
  {
    $client = self::createClient();
    $crawler = $client->request('GET', '/auth');
    $this->assertResponseStatusCodeSame(302);
    $client->followRedirect();
    $this->assertResponseStatusCodeSame(200);
  }

  /** Page Auth en ayant les droits */
  public function testAuthAuthorize()
  {
    $client = self::createClient();
    $this->createUser();
    /** @var UserRepository $userRepository */
    $userRepository = $this->dependencyGet(UserRepository::class);
    $user = $userRepository->findOneBy(['email' => 'admin@gmail.com']);
    $client->loginUser($user);
    $client->request('GET','/login');
    $this->assertResponseStatusCodeSame(Response::HTTP_OK);
  }

  /** Test erreur authentification */
  public function testLoginFail()
  {
    $client = self::createClient();
    $crawler = $client->request('GET', '/login');
    $form = $crawler->selectButton('Sign in')->form([
      'email' => 'toto@gmail.com',
      'password' => 'test'
    ]);
    $client->submit($form);
    $this->assertResponseStatusCodeSame(302);
    $client->followRedirect();
    $this->assertResponseStatusCodeSame(200);
    $this->assertSelectorExists('.alert.alert-danger');
  }

  /** Test authentificatio réussie */
  public function testLoginGood()
  {
    $client = self::createClient();
    $this->createUser();
    $crawler = $client->request('GET','/login');
    $form = $crawler->selectButton('Sign in')->form([
      'email' => 'admin@gmail.com',
      'password' => 'test'
    ]);
    $client->submit($form);
    $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
  }

  /** Test d'envoi de mail */
  public function testMail()
  {
    $client = self::createClient();
    $client->request('GET','/mail');
    $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    $this->assertEmailCount(1);
  }



}
