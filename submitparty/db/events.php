<?php
defined('MOODLE_INTERNAL') || die();

// Aqui conecto los eventos de mod_assign con mi clase observadora.
// Cuando un alumno crea o actualiza una entrega, Moodle llamara al callback.
$observers = [
    [
        'eventname' => '\mod_assign\event\submission_created',
        'callback'  => 'block_submitparty_observer::submission_created',
    ],
    [
        'eventname' => '\mod_assign\event\submission_updated',
        'callback'  => 'block_submitparty_observer::submission_updated',
    ],
];
