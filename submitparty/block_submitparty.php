<?php
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
