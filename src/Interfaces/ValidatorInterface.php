<?php

declare(strict_types=1);

namespace Hexlet\Interfaces;

interface ValidatorInterface
{
    public function string(): StringSchemaInterface;
}
