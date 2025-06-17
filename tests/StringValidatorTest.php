<?php

namespace Hexlet\Validator\Tests;

use PHPUnit\Framework\TestCase;
use Hexlet\Validator\Validator;

class StringValidatorTest extends TestCase
{
    private Validator $validator;

    protected function setUp(): void
    {
        $this->validator = new Validator();
    }

    public function testBasicValidation(): void
    {
        $schema = $this->validator->string();

        $this->assertTrue($schema->isValid(''));
        $this->assertTrue($schema->isValid(null));
        $this->assertTrue($schema->isValid('what does the fox say'));
    }

    public function testIndependentSchemas(): void
    {
        $schema1 = $this->validator->string();
        $schema2 = $this->validator->string();

        $schema1->required();

        $this->assertFalse($schema1->isValid(''));
        $this->assertTrue($schema2->isValid(''));
    }

    public function testRequired(): void
    {
        $schema = $this->validator->string()->required();

        $this->assertFalse($schema->isValid(null));
        $this->assertFalse($schema->isValid(''));
        $this->assertTrue($schema->isValid('hexlet'));
    }

    public function testContains(): void
    {
        $schema = $this->validator->string()->contains('what');

        $this->assertTrue($schema->isValid('what does the fox say'));
        $this->assertFalse($schema->isValid('hello world'));
    }

    public function testMinLength(): void
    {
        $schema = $this->validator->string()->minLength(5);

        $this->assertTrue($schema->isValid('Hexlet'));
        $this->assertFalse($schema->isValid('Hex'));
    }

    public function testValidationPriority(): void
    {
        $schema = $this->validator->string()
            ->minLength(10)
            ->minLength(5);

        $this->assertTrue($schema->isValid('Hexlet'));
    }

    public function testCombinedValidators(): void
    {
        $schema = $this->validator->string()
            ->required()
            ->contains('hex')
            ->minLength(5);

        $this->assertTrue($schema->isValid('hexlet'));
        $this->assertFalse($schema->isValid('let')); // Too short
        $this->assertFalse($schema->isValid('hello')); // Doesn't contain 'hex'
        $this->assertFalse($schema->isValid('')); // Empty
        $this->assertFalse($schema->isValid(null)); // Null
    }

    public function testCustomStringValidator(): void
    {
        $v = new Validator();
        $v->addValidator('string', 'startWith', fn($value, $start) => str_starts_with($value, $start));

        $schema = $v->string()->test('startWith', 'H');
        $this->assertFalse($schema->isValid('exlet'));
        $this->assertTrue($schema->isValid('Hexlet'));
        $this->assertTrue($schema->isValid(null)); // null allowed by default
    }
}
