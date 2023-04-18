<?php

namespace APIVolunteerManagerIntegration\Services\WpRest\Local;

use APIVolunteerManagerIntegration\Services\WpRest\WpRestClient;
use Exception;
use function json_decode;

class LocalWpRestClientFactory extends LocalWpRestClient
{
    public static function createFromJson(string $json): WpRestClient
    {
        try {
            $args = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (Exception $e) {
            $args = [];
        }

        return self::createFromArgs($args);
    }

    public static function createFromArgs(array $args): WpRestClient
    {
        return new self([
            'types'      => $args['types'] ?? [],
            'posts'      => $args['posts'] ?? [],
            'terms'      => $args['terms'] ?? [],
            'taxonomies' => $args['taxonomies'] ?? [],
        ]);
    }

}