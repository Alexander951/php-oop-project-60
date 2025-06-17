<?php

namespace Hexlet\Validator;

use Hexlet\Interfaces\ArraySchemaInterface;
use Hexlet\Validator\AbstractSchema;

class ArraySchema extends AbstractSchema implements ArraySchemaInterface
{
    
    public function __construct() 
    {
        $this->addValidator('type', function($value) {
            return $value === null || is_array($value);
        });
        return $this;
    }

    public function required(): self
    {
        $this->nullable(false);
        $this->addValidator('required', function ($value) {
            return is_array($value);
        });
        return $this;
    }
    
    public function sizeof(int $size): self
    {
        $this->addValidator('sizeof', function ($value) use ($size) {
            return $value === null || count($value) === $size;
        });
        return $this;
    }

    public function isValid($value): bool 
    {
        return $this->validateBase($value);
    }
}