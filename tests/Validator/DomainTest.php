<?php
namespace App\Tests\Validator;

use App\Validator\Domain;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Exception\MissingOptionsException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class DomainTest extends TestCase
{
  public function testClassHasDomainPropertyNotSet()
  {
    $this->expectException(MissingOptionsException::class);
    $domainClass = new Domain();
  }

  public function testClassHasDomainPropertySetHasArray()
  {
    $domainClass = new Domain(options: ['domain' => ['test.fr']]);
    $this->assertEquals(['test.fr'],$domainClass->domain);
  }

  public function testClassHasDomainPropertySetHasNotArray()
  {
    $this->expectException(UnexpectedTypeException::class);
    $domainClass = new Domain(options: ['domain' => 'ok']);
  }

}
