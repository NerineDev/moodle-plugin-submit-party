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

// Esta es la clase principal del bloque.
// Aqui decido donde puede mostrarse y que contenido se pinta cuando el usuario
// tiene una celebracion pendiente despues de entregar una tarea.
class block_submitparty extends block_base {

    // En la inicializacion solo asigno el titulo visible del bloque.
    public function init() {
        $this->title = get_string('pluginname', 'block_submitparty');
    }

    // Limito los contextos para que el bloque aparezca solo en vistas utiles
    // para este caso: tareas, curso, dashboard y portada.
    public function applicable_formats() {
        return [
            'mod-assign-view' => true,
            'course-view'     => true,
            'my'              => true,
            'site-index'      => true,
        ];
    }


}
