<?php

declare(strict_types=1);

namespace Hexlet\Interfaces;

use Hexlet\Interfaces\SchemaInterface;

interface ArraySchemaInterface extends SchemaInterface
{
    public function required(): self;
    public function sizeof(int $size): self;
    public function shape(array $schemas): self;
}
