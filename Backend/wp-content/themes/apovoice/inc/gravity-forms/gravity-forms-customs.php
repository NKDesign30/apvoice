<?php 

// ------------ Gravity Forms Customs ------------

$partials = [
    'gravity-forms-helpers',
    'gravity-forms-validation-rules',
    'gravity-forms-settings',
];

foreach ($partials as $partial) {
    require_once get_template_directory() . "/inc/gravity-forms/require/{$partial}.php";
}