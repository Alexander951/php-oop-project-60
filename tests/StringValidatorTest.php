<?php

namespace Hexlet\Validator\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Assert;
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

        Assert::assertTrue($schema->isValid(''));
        Assert::assertTrue($schema->isValid(null));
        Assert::assertTrue($schema->isValid('what does the fox say'));
    }

    public function testIndependentSchemas(): void
    {
        $schema1 = $this->validator->string();
        $schema2 = $this->validator->string();

        $schema1->required();

        Assert::assertFalse($schema1->isValid(''));
        Assert::assertTrue($schema2->isValid(''));
    }

    public function testRequired(): void
    {
        $schema = $this->validator->string()->required();

        Assert::assertFalse($schema->isValid(null));
        Assert::assertFalse($schema->isValid(''));
        Assert::assertTrue($schema->isValid('hexlet'));
    }

    public function testContains(): void
    {
        $schema = $this->validator->string()->contains('what');

        Assert::assertTrue($schema->isValid('what does the fox say'));
        Assert::assertFalse($schema->isValid('hello world'));
    }

    public function testMinLength(): void
    {
        $schema = $this->validator->string()->minLength(5);

        Assert::assertTrue($schema->isValid('Hexlet'));
        Assert::assertFalse($schema->isValid('Hex'));
    }

    public function testValidationPriority(): void
    {
        $schema = $this->validator->string()
            ->minLength(10)
            ->minLength(5);

        Assert::assertTrue($schema->isValid('Hexlet'));
    }

    public function testCombinedValidators(): void
    {
        $schema = $this->validator->string()
            ->required()
            ->contains('hex')
            ->minLength(5);

        Assert::assertTrue($schema->isValid('hexlet'));
        Assert::assertFalse($schema->isValid('let')); // Too short
        Assert::assertFalse($schema->isValid('hello')); // Doesn't contain 'hex'
        Assert::assertFalse($schema->isValid('')); // Empty
        Assert::assertFalse($schema->isValid(null)); // Null
    }

    public function testCustomStringValidator(): void
    {
        $v = new Validator();
        $v->addValidator('string', 'startWith', fn($value, $start) => str_starts_with($value, $start));

        $schema = $v->string()->test('startWith', 'H');
        Assert::assertFalse($schema->isValid('exlet'));
        Assert::assertTrue($schema->isValid('Hexlet'));
        Assert::assertTrue($schema->isValid(null)); // null allowed by default
    }
}
