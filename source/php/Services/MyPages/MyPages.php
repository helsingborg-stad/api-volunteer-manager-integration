<?php

namespace APIVolunteerManagerIntegration\Services\MyPages;

interface MyPages
{
    public function loginUrl(?string $redirectUrl = ''): string;

    public function signOutUrl(): string;
}