<?php

namespace Tests\Unit\Domain\Client\ValueObjects;

use App\Domain\Client\ValueObjects\Region;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class RegionTest extends TestCase
{
    public function testCanCreateRegionWithValidCode(): void
    {
        $region = new Region('PR');

        $this->assertEquals('PR', $region->getCode());
    }

    public function testCanCreateRegionWithLowercaseCode(): void
    {
        $region = new Region('pr');

        $this->assertEquals('PR', $region->getCode());
    }

    public function testCannotCreateRegionWithInvalidCode(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Region('INVALID');
    }

    public function testIsPragueReturnsTrue(): void
    {
        $region = new Region('PR');

        $this->assertTrue($region->isPrague());
        $this->assertFalse($region->isBrno());
        $this->assertFalse($region->isOstrava());
    }

    public function testIsBrnoReturnsTrue(): void
    {
        $region = new Region('BR');

        $this->assertFalse($region->isPrague());
        $this->assertTrue($region->isBrno());
        $this->assertFalse($region->isOstrava());
    }

    public function testIsOstravaReturnsTrue(): void
    {
        $region = new Region('OS');

        $this->assertFalse($region->isPrague());
        $this->assertFalse($region->isBrno());
        $this->assertTrue($region->isOstrava());
    }

    public function testEqualsReturnsTrueForSameRegion(): void
    {
        $region1 = new Region('PR');
        $region2 = new Region('PR');

        $this->assertTrue($region1->equals($region2));
    }

    public function testEqualsReturnsFalseForDifferentRegions(): void
    {
        $region1 = new Region('PR');
        $region2 = new Region('BR');

        $this->assertFalse($region1->equals($region2));
    }
}
