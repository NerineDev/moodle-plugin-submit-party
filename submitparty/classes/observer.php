<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
defined('MOODLE_INTERNAL') || die();

// Este observador escucha los eventos de entrega de la actividad Tarea.
// Mi objetivo aqui es registrar la entrega y dejar una marca en sesion para
// lanzar la celebracion en la siguiente carga de pagina.
class block_submitparty_observer {
    // Si la entrega se crea por primera vez, reutilizo la misma logica comun.
    public static function submission_created($event) {
        self::log_submission($event->userid);
    }

    // Si la entrega se actualiza, vuelvo a registrar el momento mas reciente.
    public static function submission_updated($event) {
        self::log_submission($event->userid);
    }

    // Este metodo privado concentra la parte importante del observador.
    // Guardo la fecha en sesion para el hook visual y en base de datos para que
    // el bloque tenga historico y sepa si ya mostro la celebracion o no.
    private static function log_submission($userid) {
        global $DB, $SESSION;

        $now = time();

        // Store in session so the hook can inject JS on the very next page load.
        $SESSION->submitparty_timecreated = $now;

        // Tambien persisto el dato en base de datos para el bloque y el historial.
        $existing = $DB->get_record('block_submitparty_log', ['userid' => $userid]);
        if ($existing) {
            // Si ya habia una fila, la reciclo y marco la celebracion como pendiente.
            $existing->timecreated = $now;
            $existing->celebrated  = 0;
            $DB->update_record('block_submitparty_log', $existing);
        } else {
            // Si no existe, creo un registro nuevo con el estado inicial.
            $DB->insert_record('block_submitparty_log', [
                'userid'      => $userid,
                'timecreated' => $now,
                'celebrated'  => 0,
            ]);
        }
    }
}
