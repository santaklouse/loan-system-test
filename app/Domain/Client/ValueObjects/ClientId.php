<?php

namespace App\Domain\Client\ValueObjects;

class ClientId
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException('Client ID must be positive');
        }

        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function equals(ClientId $other): bool
    {
        return $this->value === $other->getValue();
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
