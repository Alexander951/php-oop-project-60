<?php

declare(strict_types=1);

namespace Hexlet\Validator;

use Hexlet\Interfaces\StringSchemaInterface;
use Hexlet\Validator\AbstractSchema;

class StringSchema extends AbstractSchema implements StringSchemaInterface
{
    public function __construct()
    {
        $this->addValidator('type', function ($value) {
            return $value === null || is_string($value);
        });
    }

    public function required(): self
    {
        $this->nullable(false);
        $this->addValidator('required', function ($value) {
            return is_string($value) && $value !== '';
        });
        return $this;
    }

    public function minLength(int $length): self
    {
        $this->addValidator('minLength', function ($value) use ($length) {
            return $value === null || (is_string($value) && mb_strlen($value) >= $length);
        });
        return $this;
    }

    public function contains(string $substring): self
    {
        $this->addValidator('contains', function ($value) use ($substring) {
            return $value === null || (is_string($value) && strpos($value, $substring) !== false);
        });
        return $this;
    }

    public function isValid($value): bool
    {
        return $this->validateBase($value);
    }
}
