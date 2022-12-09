<?php

use App\Validator\Constraint\ConstraintException;
use App\Validator\Constraint\ConstraintInterface;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    const EXAMPLE_EXCEPTION_MESSAGE = 'some exception';

    public function testShouldAddConstraint()
    {
        $constraintMock = Mockery::mock(ConstraintInterface::class);
        $validator = new App\Validator\Validator();

        $validator->addConstraint($constraintMock);

        $validatorReflection = new ReflectionClass($validator);

        $constraints = $validatorReflection->getProperty('constraints');
        $constraints->setAccessible(true);

        $this->assertEquals([$constraintMock], $constraints->getValue($validator));
    }

    /**
     * @throws ConstraintException
     */
    public function testShouldExecuteConstraintsAndThrowException()
    {
        $constraintWillPassMock = Mockery::mock(ConstraintInterface::class)
            ->shouldReceive('validate')
            ->andReturnTrue()
            ->getMock();

        $constraintWillThrowException = Mockery::mock(ConstraintInterface::class)
            ->shouldReceive('validate')
            ->with(1)
            ->andThrow(new Exception(self::EXAMPLE_EXCEPTION_MESSAGE))
            ->getMock();

        $constraintWillNoExecute = Mockery::mock(ConstraintInterface::class);

        $validator = new App\Validator\Validator();
        $validator->addConstraint($constraintWillPassMock);
        $validator->addConstraint($constraintWillThrowException);
        $validator->addConstraint($constraintWillNoExecute);

        try {
            $validator->validate(1);

        } catch (Exception $exception) {
            $this->assertEquals(self::EXAMPLE_EXCEPTION_MESSAGE, $exception->getMessage());

            $constraintWillPassMock->shouldHaveReceived('validate')->once();
            $constraintWillThrowException->shouldHaveReceived('validate')->once();
            $constraintWillNoExecute->shouldNotHaveReceived('validate');
        }
    }
}
