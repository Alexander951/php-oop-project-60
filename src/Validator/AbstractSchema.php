<?php

declare(strict_types=1);

namespace Hexlet\Validator;

use Hexlet\Interfaces\SchemaInterface;

abstract class AbstractSchema implements SchemaInterface
{
    protected bool $nullable = true;
    protected array $validators = [];

    public function nullable(bool $flag = true): self
    {
        $this->nullable = $flag;
        return $this;
    }

    protected function addValidator(string $name, callable $validator): void
    {
        $this->validators[$name] = $validator;
    }

    protected function validateBase($value): bool
    {
        if ($value === null) {
            return $this->nullable;
        }

        foreach ($this->validators as $validator) {
            if (!$validator($value)) {
                return false;
            }
        }

        return true;
    }
}
