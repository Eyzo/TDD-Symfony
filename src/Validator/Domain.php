<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * @Annotation
 */
class Domain extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'The value "{{ value }}" is not valid.';
    public $domain;

    public function __construct(mixed $options = null, array $groups = null, mixed $payload = null)
    {
      parent::__construct($options, $groups, $payload);
      if (!is_array($options['domain'])) {
        throw new UnexpectedTypeException($options['domain'], 'array');
      }
    }

    public function getRequiredOptions(): array
    {
      return ['domain'];
    }
}
