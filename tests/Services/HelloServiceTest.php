<?php
namespace App\Tests\Services;

use App\Interface\HelloInterface;
use App\Services\HelloDecoratorService;
use App\Services\HelloService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HelloServiceTest extends KernelTestCase
{
  public function testSayHello()
  {
    self::bootKernel();
    $container = static::getContainer();
    /** @var HelloService $helloService */
    $helloService = $container->get(HelloInterface::class);
    $return = $helloService->sayHello();
    $this->assertEquals('Say Hello', $return);
  }
}
