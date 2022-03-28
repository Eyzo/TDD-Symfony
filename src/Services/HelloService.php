<?php
namespace App\Services;

use App\Interface\HelloInterface;

class HelloService implements HelloInterface
{

  public function sayHello(): string
  {
    return 'Say Hello';
  }

}
