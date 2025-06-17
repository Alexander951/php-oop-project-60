<?php

declare(strict_types=1);

namespace Hexlet\Interfaces;

use Hexlet\Interfaces\SchemaInterface;

interface StringSchemaInterface extends SchemaInterface
{
    public function required(): self;
    public function minLength(int $length): self;
    public function contains(string $substring): self;
    public function test(string $validatorName, mixed ...$args): self;
}
