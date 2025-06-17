<?php

declare(strict_types=1);

namespace Hexlet\Validator;

use Hexlet\Interfaces\SchemaInterface;

abstract class AbstractSchema implements SchemaInterface
{
    protected bool $nullable = true;
    protected array $validators = [];
    protected Validator $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;

        // Базовая валидация типа
        $this->addValidator('type', fn($value) =>
            $value === null || $this->isValidType($value));
    }

    public function nullable(bool $flag = true): self
    {
        $this->nullable = $flag;
        return $this;
    }

    protected function addValidator(string $name, callable $validator): void
    {
        $this->validators[$name] = $validator;
    }

    protected function validateBase(mixed $value): bool
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

    public function isRequired(): bool
    {
        return !$this->nullable;
    }

    // Проверка типа
    abstract protected function isValidType(mixed $value): bool;

    // Получения типа схемы
    abstract protected function getType(): string;

    public function test(string $validatorName, mixed ...$args): self
    {
        $customValidators = $this->validator->getCustomValidators($this->getType());

        if (!isset($customValidators[$validatorName])) {
            throw new \InvalidArgumentException("Validator '{$validatorName}' not found for type '{$this->getType()}'");
        }

        $this->addValidator(
            "custom_{$validatorName}",
            fn($value) => $value === null || $customValidators[$validatorName]($value, ...$args)
        );

        return $this;
    }
}
