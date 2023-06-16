<?php

namespace APIVolunteerManagerIntegration\Services\MyPages;

use Error;

class MyPagesService implements MyPages
{
    /** @noinspection PhpFullyQualifiedNameUsageInspection */
    public function loginUrl(?string $redirectUrl = ''): string
    {
        if ( ! class_exists('\ModMyPages\Service\LoginUrlService\LoginUrlServiceFactory')) {
            throw new Error('\ModMyPages\Service\LoginUrlService\LoginUrlServiceFactory does not exists');
        }

        return \ModMyPages\Service\LoginUrlService\LoginUrlServiceFactory::createFromEnv()->buildUrl($redirectUrl);
    }
}