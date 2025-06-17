<?php

declare(strict_types=1);

namespace Hexlet\Interfaces;

use Hexlet\Interfaces\SchemaInterface;

interface NumberSchemaInterface extends SchemaInterface
{
    public function required(): self;
    public function positive(): self;
    public function range(int $min, int $max): self;
    public function test(string $validatorName, mixed ...$args): self;
}
