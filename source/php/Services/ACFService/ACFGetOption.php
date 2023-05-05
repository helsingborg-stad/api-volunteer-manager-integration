<?php

namespace APIVolunteerManagerIntegration\Services\ACFService;

interface ACFGetOption
{
    /**
     * ACF helper: get_field($selector, 'options')
     *
     * @param  string  $selector  — the field name or key
     *
     * @return mixed
     */
    public function getOption(string $selector);
}
