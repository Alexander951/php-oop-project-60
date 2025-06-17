<?php

namespace Hexlet\Validator\Tests;

use PHPUnit\Framework\TestCase;
use Hexlet\Validator\Validator;

class ArrayValidatorTest extends TestCase
{
    private Validator $validator;

    protected function setUp(): void
    {
        $this->validator = new Validator();
    }

    public function testBasicValidation(): void
    {
        $schema = $this->validator->array();

        $this->assertTrue($schema->isValid(null));
        $this->assertTrue($schema->isValid([]));
        $this->assertTrue($schema->isValid(['hexlet']));
    }

    public function testRequired(): void
    {
        $schema = $this->validator->array()->required();

        $this->assertFalse($schema->isValid(null));
        $this->assertTrue($schema->isValid([]));
        $this->assertTrue($schema->isValid(['hexlet']));
    }

    public function testSizeof(): void
    {
        $schema = $this->validator->array()->sizeof(2);

        $this->assertTrue($schema->isValid(null)); // null allowed when not required
        $this->assertFalse($schema->isValid(['hexlet']));
        $this->assertTrue($schema->isValid(['hexlet', 'code-basics']));
    }

    public function testCombinedValidators(): void
    {
        $schema = $this->validator->array()
            ->required()
            ->sizeof(2);

        $this->assertFalse($schema->isValid(null));
        $this->assertFalse($schema->isValid(['hexlet']));
        $this->assertTrue($schema->isValid(['hexlet', 'code-basics']));
    }
}