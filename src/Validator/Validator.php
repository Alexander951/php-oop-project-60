<?php

declare(strict_types=1);

namespace Hexlet\Validator;

use Hexlet\Validator\StringSchema;
use Hexlet\Interfaces\StringSchemaInterface;
use Hexlet\Interfaces\ValidatorInterface;

class Validator implements ValidatorInterface
{
    public function string(): StringSchemaInterface
    {
        return new StringSchema();
    }
}
