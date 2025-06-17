<?php

declare(strict_types=1);

namespace Hexlet\Validator;

use Hexlet\Interfaces\ValidatorInterface;
use Hexlet\Validator\StringSchema;
use Hexlet\Interfaces\StringSchemaInterface;
use Hexlet\Validator\NumberSchema;
use Hexlet\Interfaces\NumberSchemaInterface;
use Hexlet\Validator\ArraySchema;
use Hexlet\Interfaces\ArraySchemaInterface;

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
    
    public function array(): ArraySchemaInterface
    {
        return new ArraySchema();
    }
}
