<?php

declare(strict_types=1);

namespace Hexlet\Validator;

use Hexlet\Interfaces\ValidatorInterface;
use Hexlet\Validator\StringSchema;
use Hexlet\Interfaces\StringSchemaInterface;
use Hexlet\Validator\NumberSchema;
use Hexlet\Interfaces\NumberSchemaInterface;
use Hexlet\Validator\ArraySchema;
use Hexlet\Interfaces\ArraySchemaInterface;

class Validator implements ValidatorInterface
{
    private array $customValidators = [
        'string' => [],
        'number' => [],
        'array' => []
    ];

    public function addValidator(string $type, string $name, callable $fn): void
    {
        if (!array_key_exists($type, $this->customValidators)) {
            throw new \InvalidArgumentException("Unsupported validator type: {$type}");
        }
        $this->customValidators[$type][$name] = $fn;
    }

    public function getCustomValidators(string $type): array
    {
        return $this->customValidators[$type] ?? [];
    }

    public function string(): StringSchemaInterface
    {
        return new StringSchema($this);
    }

    public function number(): NumberSchemaInterface
    {
        return new NumberSchema($this);
    }

    public function array(): ArraySchemaInterface
    {
        return new ArraySchema($this);
    }
}
