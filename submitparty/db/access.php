<?php
defined('MOODLE_INTERNAL') || die();

// En este archivo defino las capacidades del bloque.
// Son los permisos que Moodle usa para decidir quien puede añadirlo.


// Define las capacidades (permisos) usados por el bloque
$capabilities = [

    // Capacidad para agregar una instancia del bloque a un curso o página
    // Esta capacidad permite que profesorado editor y gestores añadan el bloque.
    'block/submitparty:addinstance' => [
        'riskbitmask' => RISK_SPAM | RISK_XSS,
        'captype' => 'write',
        'contextlevel' => CONTEXT_BLOCK,
        'archetypes' => [
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ],
        'clonepermissionsfrom' => 'moodle/site:manageblocks'
    ],
    
    // Capacidad para agregar una instancia del bloque a la página "Mi Moodle"
    // Esta segunda capacidad hace lo mismo pero en el area personal del usuario.
    'block/submitparty:myaddinstance' => [
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => [
            'user' => CAP_ALLOW
        ],
        'clonepermissionsfrom' => 'moodle/my:manageblocks'
    ]
];
