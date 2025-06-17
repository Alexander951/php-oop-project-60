<?php

namespace Hexlet\Validator;

use Hexlet\Interfaces\ArraySchemaInterface;
use Hexlet\Validator\AbstractSchema;

class ArraySchema extends AbstractSchema implements ArraySchemaInterface
{
    private ?array $shapeSchemas = null;
    
    public function __construct(Validator $validator) 
    {
        parent::__construct($validator);
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
    
    public function shape(array $schemas): self
    {
        $this->shapeSchemas = $schemas;
        $this->addValidator('shape', function ($value) {
            if ($this->shapeSchemas === null) {
                return true;
            }

            if ($value === null) {
                return $this->nullable;
            }

            if (!is_array($value)) {
                return false;
            }

            foreach ($this->shapeSchemas as $key => $schema) {
                if (!array_key_exists($key, $value)) {
                    if ($schema->isRequired()) {
                        return false;
                    }
                    continue;
                }

                if (!$schema->isValid($value[$key])) {
                    return false;
                }
            }

            return true;
        });

        return $this;
    }
    
    protected function getType(): string
    {
        return 'array';
    }
    
    protected function isValidType($value): bool {
        return is_array($value);
    }
}