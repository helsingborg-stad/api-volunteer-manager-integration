<?php /** @noinspection PhpUndefinedClassInspection */

/** @noinspection PhpUndefinedNamespaceInspection */

namespace APIVolunteerManagerIntegration\Modularity\AssignmentForm;

use Modularity\Module;

class AssignmentForm extends Module
{
    public $slug = 'volunteer-assignment-form';
    public $supports = [];

    public function init()
    {
        $this->nameSingular = __('Volunteer Assignment Form', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN);
        $this->namePlural   = __('Volunteer Assignment Forms', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN);
        $this->description  = __('Module for Volunteer Assignment form',
            API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN);
    }


    public function data(): array
    {
        return [];
    }

    public function template(): string
    {
        return 'assignment-form.blade.php';
    }
}