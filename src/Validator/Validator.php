<?php

declare(strict_types=1);

namespace Hexlet\Validator;

use Hexlet\Validator\StringSchema;
use Hexlet\Interfaces\StringSchemaInterface;
use Hexlet\Interfaces\ValidatorInterface;
use Hexlet\Interfaces\NumberSchemaInterface;

class Validator implements ValidatorInterface
{
    public function string(): StringSchemaInterface
    {
        return new StringSchema();
    }
    
    public function number(): NumberSchemaInterface
    {
        return new NumberSchema();
    }
}
