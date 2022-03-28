<?php
namespace App\Services;

use App\Interface\HelloInterface;

class HelloDecoratorService implements HelloInterface
{
  public function __construct(protected HelloInterface $hello){}

  public function sayHello(): string
  {
    return $this->hello->sayHello().' my friend';
  }
}
