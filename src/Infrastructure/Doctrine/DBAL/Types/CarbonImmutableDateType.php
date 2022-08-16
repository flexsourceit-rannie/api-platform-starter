<?php
declare(strict_types=1);

namespace App\Infrastructure\Doctrine\DBAL\Types;

use Carbon\CarbonImmutable;
use Doctrine\DBAL\Types\DateImmutableType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class CarbonImmutableDateType extends DateImmutableType
{
    /**
     * @param mixed $value
     *
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToPhpValue($value, AbstractPlatform $platform): ?CarbonImmutable
    {
        $value = parent::convertToPHPValue($value, $platform);
        if ($value === null) {
            return null;
        }

        return CarbonImmutable::instance($value);
    }
}