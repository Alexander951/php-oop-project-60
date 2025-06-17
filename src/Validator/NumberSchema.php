<?php

declare(strict_types=1);

namespace Hexlet\Validator;

use Hexlet\Interfaces\NumberSchemaInterface;
use Hexlet\Validator\AbstractSchema;

class NumberSchema extends AbstractSchema implements NumberSchemaInterface
{
    public function __construct(Validator $validator)
    {
        parent::__construct($validator);
        $this->addValidator('type', function ($value) {
            return $value === null || is_numeric($value);
        });
    }

    public function required(): self
    {
        $this->nullable(false);
        $this->addValidator('required', function ($value) {
            return is_numeric($value);
        });
        return $this;
    }

    public function positive(): self
    {
        $this->addValidator('positive', function ($value) {
            return $value === null || $value > 0;
        });
        return $this;
    }

    public function range(int $min, int $max): self
    {
        $this->addValidator('range', function ($value) use ($min, $max) {
            return $value === null || ($value >= $min && $value <= $max);
        });
        return $this;
    }
    
    public function isValid($value): bool
    {
        return $this->validateBase($value);
    }
    
    protected function getType(): string
    {
        return 'number';
    }
    
    protected function isValidType($value): bool {
        return is_numeric($value);
    }
}