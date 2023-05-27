<?php

namespace APIVolunteerManagerIntegration\Virtual\VirtualQuery\Query;

use APIVolunteerManagerIntegration\Virtual\VirtualQuery\Entity\VQEntity;

class VirtualQueryFactory
{

    /**
     * @param  array<int, VQEntity>  $entities
     * @param  array  $sources
     *
     * @return VQ
     */
    public static function createFromEntitiesWithSources(
        array $entities,
        array $sources
    ): VQ {
        $vq = self::createFromSources($sources);
        foreach ($entities as $entity) {
            $entity->registerEntity($vq);
        }

        return $vq;
    }

    public static function createFromSources(array $sources): VQ
    {
        return new VirtualQuery($sources);
    }
}