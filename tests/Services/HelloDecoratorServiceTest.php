<?php
namespace App\Tests\Services;

use App\Services\HelloDecoratorService;
use App\Services\HelloService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HelloDecoratorServiceTest extends KernelTestCase
{
  public function testSayHelloDecorator()
  {
    self::bootKernel();
    $container = static::getContainer();
    $helloService = $container->get(HelloDecoratorService::class);
    $return = $helloService->sayHello();
    $this->assertEquals('Say Hello my friend', $return);
  }
}
