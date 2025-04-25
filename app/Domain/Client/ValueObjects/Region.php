<?php

namespace App\Domain\Client\ValueObjects;

class Region
{
    public const PRAGUE = 'PR';
    public const BRNO = 'BR';
    public const OSTRAVA = 'OS';

    private const ALLOWED_REGIONS = [
        self::PRAGUE,
        self::BRNO,
        self::OSTRAVA,
    ];

    private string $code;

    public function __construct(string $code)
    {
        $code = strtoupper($code);

        if (!in_array($code, self::ALLOWED_REGIONS)) {
            throw new \InvalidArgumentException('Invalid region code');
        }

        $this->code = $code;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function isPrague(): bool
    {
        return $this->code === self::PRAGUE;
    }

    public function isBrno(): bool
    {
        return $this->code === self::BRNO;
    }

    public function isOstrava(): bool
    {
        return $this->code === self::OSTRAVA;
    }

    public function equals(Region $other): bool
    {
        return $this->code === $other->getCode();
    }
}
