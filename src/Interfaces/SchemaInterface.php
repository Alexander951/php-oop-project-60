<?php

declare(strict_types=1);

namespace Hexlet\Interfaces;

interface SchemaInterface
{
    public function isValid($value): bool;
}
