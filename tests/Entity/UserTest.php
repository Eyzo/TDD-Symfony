<?php
namespace App\Tests\Entity;

use App\DataFixtures\UserFixtures;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserTest extends KernelTestCase
{
  public static function getKernelContainer(): ContainerInterface
  {
    self::bootKernel();
    return self::getContainer();
  }

  public function getService(string $class): object
  {
    $container = self::getKernelContainer();
    return $container->get($class);
  }

  public function getInstanceOfUser(): User
  {
    $user = new User();
    $user->setEmail('test@test.fr')
      ->setPassword('12345')
      ->setRoles([]);
    return $user;
  }

  public function testInsertUser()
  {
    /** @var EntityManagerInterface $em */
    $em = $this->getService(EntityManagerInterface::class);
    /** @var UserRepository $userRepository */
    $userRepository = $this->getService(UserRepository::class);
    $user = $this->getInstanceOfUser();
    $em->persist($user);
    $em->flush();
    $userFinded = $userRepository->find($user->getId());
    $this->assertInstanceOf(User::class, $userFinded);
  }

  public function testUserCorrectAssert()
  {
    /** @var ValidatorInterface $validator */
    $validator = $this->getService(ValidatorInterface::class);
    $user = $this->getInstanceOfUser();
    $errors = $validator->validate($user);
    $this->assertEquals(0, $errors->count());
  }

  public function testUserIncorrectAssert()
  {
    /** @var ValidatorInterface $validator */
    $validator = $this->getService(ValidatorInterface::class);
    $user = $this->getInstanceOfUser()->setEmail('okok')->setPassword('1');
    $errors = $validator->validate($user);
    $this->assertEquals(2, $errors->count());
  }

  public function testTotalUsersAfterFixture()
  {
    /** @var EntityManagerInterface $em */
    $em = $this->getService(EntityManagerInterface::class);

    /** @var UserFixtures $fixtures */
    $fixtures = $this->getService(UserFixtures::class);

    $fixtures->load($em);

    /** @var UserRepository $userReposistory */
    $userReposistory = $this->getService(UserRepository::class);

    $numberOfUsers = $userReposistory->count([]);
    $this->assertEquals(10, $numberOfUsers);
  }



}
