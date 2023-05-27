<?php

namespace APIVolunteerManagerIntegration\Services\ACFService;

interface ACFGetField
{
    /**
     * ACF function: get_field
     *
     * @param  string  $selector  — the field name or key
     * @param  string|int  $postId  — the post_id of which the value is saved against.
     *
     * @return mixed
     */
    public function getField(string $selector, $postId);
}
