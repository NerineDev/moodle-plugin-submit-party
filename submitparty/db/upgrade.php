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

// En este upgrade voy aplicando cambios de esquema cuando el plugin sube de version.
function xmldb_block_submitparty_upgrade($oldversion) {
    global $DB;
    $dbman = $DB->get_manager();

    // Si el sitio viene de una version anterior, añado el campo celebrated.
    // Me sirve para saber si una entrega ya mostro o no la animacion al usuario.
    if ($oldversion < 2026041700) {
        $table = new xmldb_table('block_submitparty_log');
        $field = new xmldb_field('celebrated', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0', 'timecreated');
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        // Este savepoint le dice a Moodle que la migracion termino correctamente.
        upgrade_block_savepoint(true, 2026041700, 'submitparty');
    }
    return true;
}
