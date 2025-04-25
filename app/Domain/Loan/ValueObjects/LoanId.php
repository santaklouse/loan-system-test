<?php

namespace App\Domain\Loan\ValueObjects;

class LoanId
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException('Loan ID must be positive');
        }

        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function equals(LoanId $other): bool
    {
        return $this->value === $other->getValue();
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
