<?php
namespace App\Tests\Validator;

use App\Validator\Domain;
use App\Validator\DomainValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

class DomainValidatorTest extends TestCase
{

  public function testValidateAddViolationIfValueIsInDomainArray()
  {
    $mockConstraintViolation = $this->createMock(ConstraintViolationBuilderInterface::class);
    $mockConstraintViolation->expects($this->once())->method('setParameter')->willReturn($mockConstraintViolation);
    $mockConstraintViolation->expects($this->once())->method('addViolation');

    $mockContext = $this->createMock(ExecutionContextInterface::class);
    $mockContext->expects($this->once())->method('buildViolation')->willReturn($mockConstraintViolation);

    $constraint = new Domain(options: ['domain' => ['test.fr']]);
    $validator = new DomainValidator();
    $validator->initialize($mockContext);
    $validator->validate('test.fr', $constraint);
  }

  public function testValidateNotAddViolationIfValueIsNotInDomainArray()
  {
    $mockConstraintViolation = $this->createMock(ConstraintViolationBuilderInterface::class);
    $mockConstraintViolation->expects($this->never())->method('setParameter')->willReturn($mockConstraintViolation);
    $mockConstraintViolation->expects($this->never())->method('addViolation');

    $mockContext = $this->createMock(ExecutionContextInterface::class);
    $mockContext->expects($this->never())->method('buildViolation')->willReturn($mockConstraintViolation);

    $constraint = new Domain(options: ['domain' => ['test.fr']]);
    $validator = new DomainValidator();
    $validator->initialize($mockContext);
    $validator->validate('oui.fr', $constraint);
  }

}
