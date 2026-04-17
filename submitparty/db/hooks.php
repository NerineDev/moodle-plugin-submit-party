<?php
defined('MOODLE_INTERNAL') || die();

// Este archivo registra el hook visual del plugin.
// Lo uso para inyectar HTML justo antes de cerrar el footer de la pagina.
$callbacks = [
    [
        'hook'     => \core\hook\output\before_footer_html_generation::class,
        'callback' => \block_submitparty\hook_callbacks::class . '::inject_celebration',
    ],
];
