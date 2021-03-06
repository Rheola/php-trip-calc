<?php

declare(strict_types=1);

namespace App\Geo;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class PointType extends Type
{
    private const POINT = 'point';

    public function getName()
    {
        return self::POINT;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return 'POINT';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        [$longitude, $latitude] = sscanf($value, '(%f,%f)');
        return new Point($latitude, $longitude);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof Point) {
            $value = sprintf('(%F, %F)', $value->getLongitude(), $value->getLatitude());
        }

        return $value;
    }

    public function canRequireSQLConversion()
    {
        return true;
    }

    public function convertToPHPValueSQL($sqlExpr, $platform)
    {
        return sprintf('(%s)', $sqlExpr);
    }


    public function convertToDatabaseValueSQL($sqlExpr, AbstractPlatform $platform)
    {
        return sprintf('%s', $sqlExpr);
    }
}