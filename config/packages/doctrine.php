<?php
declare(strict_types=1);

use App\Infrastructure\Doctrine\DBAL\Types\CarbonImmutableDateTimeWithMicrosecondsType;
use App\Infrastructure\Doctrine\DBAL\Types\CarbonImmutableDateType;
use App\Infrastructure\Doctrine\DBAL\Types\JsonbType;
use App\Infrastructure\Doctrine\ORM\Query\AST\Functions\Cast;
use App\Infrastructure\Doctrine\ORM\Query\AST\Functions\Contains;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('doctrine', [
        'dbal' => [
            'url' => '%env(resolve:DATABASE_URL)%',
            'types' => [
                JsonbType::JSONB => JsonbType::class,
                Types::DATE_IMMUTABLE => CarbonImmutableDateType::class,
                Types::DATETIME_IMMUTABLE => CarbonImmutableDateTimeWithMicrosecondsType::class,
            ],
        ],
        'orm' => [
            'auto_generate_proxy_classes' => true,
            'naming_strategy' => 'doctrine.orm.naming_strategy.underscore_number_aware',
            'auto_mapping' => true,
            'mappings' => [
                'App' => [
                    'is_bundle' => false,
                    'dir' => '%kernel.project_dir%/src/Entity',
                    'prefix' => 'App\Entity',
                    'alias' => 'App'
                ]
            ],
            'dql' => [
                'string_functions' => [
                    'CAST' => Cast::class,
                    'CONTAINS' => Contains::class,
                ],
            ],
        ]
    ]);
};
