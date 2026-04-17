# Submit Party

[Español](#espanol)

**Submit Party** is a **Moodle 5.1.3 block plugin**.  
Its purpose is to serve as the foundation for a future submission celebration feature inside the platform, adding a small interactive element and a base structure for further visual improvements.

## General description

The plugin adds a custom block to Moodle that can be installed, enabled and displayed inside the interface. In its current version, the block provides a simple visible output and an interactive button that allows testing the basic behavior of the plugin within the system.

During development, the first goal was to build a minimal and stable working version focused on correct plugin detection, installation as a Moodle block and integration with the platform. Once that base was working, a simple interactive action was added for testing purposes.

## Objective

The main objective of this plugin is to provide a functional base for a visual improvement related to student submissions. The idea is to use this structure as a starting point for a more dynamic and engaging response when a user completes certain actions inside Moodle.

## Current functionality

At the moment, the plugin allows:

- installation as a Moodle block plugin,
- detection and activation inside the platform,
- addition through the Moodle block interface,
- display of a visible message inside the block,
- execution of a simple interaction through a button.

In other words, this is a first functional version that proves correct integration with Moodle.

## Plugin structure

The plugin follows the usual structure of a Moodle block. Its main elements include:

- `version.php`, where the plugin version and compatibility are defined,
- `block_submitparty.php`, as the main block file,
- the `db` folder, prepared for capabilities and future database-related extensions,
- the `lang` folder, containing multiple language files,
- the `pix` folder, reserved for graphical resources.

## Available languages

The plugin includes support for several languages:

- English
- Spanish
- Catalan
- Galician
- Basque
- French

This makes it easier to adapt the block to multilingual educational environments.

## Installation

To install the plugin in Moodle, it must be placed in the corresponding blocks directory and then completed through the site administration process.

Once recognized by the platform, the block becomes available to be added from the Moodle block interface.

## Possible future improvements

Although the current version focuses on providing a stable functional base, the plugin is intended to grow in future versions. Some possible improvements include:

- allowing the option to be enabled or disabled for each user,
- improving the randomization system,
- incorporating more elaborate visual elements,
- linking the block behavior to real submission actions.

## Repository and presentation

This repository contains the code developed for the plugin.

### Presentation video:  
[View on Youtube](https://youtu.be/yvYbLau81es)

## License
This project is licensed under the GNU GPL v3 or later.

## Author
Nerine Aoi 

---

## Espanol

**Submit Party** es un plugin de tipo bloque para **Moodle 5.1.3**.  
Su finalidad es servir como base para una futura funcionalidad de celebración de entregas dentro de la plataforma, incorporando una pequeña interacción visual y un punto de partida para posibles mejoras posteriores.

## Descripción general

El plugin añade un bloque personalizado a Moodle que puede instalarse, activarse y mostrarse dentro de la interfaz. En su versión actual, el bloque ofrece un contenido básico visible y un botón de interacción que permite comprobar que la estructura del plugin funciona correctamente dentro del sistema.

Durante su desarrollo se trabajó primero sobre una versión mínima y estable, centrada en asegurar la correcta detección del plugin por parte de Moodle, su instalación como bloque y su integración en la plataforma. Una vez conseguida esa base, se añadió una acción simple para verificar el comportamiento interactivo.

## Objetivo

El objetivo principal de este plugin es disponer de una base funcional para una mejora visual relacionada con las entregas del alumnado. La idea es que, a partir de esta estructura, el sistema pueda evolucionar hacia una respuesta más dinámica y atractiva cuando el usuario complete determinadas acciones dentro de Moodle.

## Funcionamiento actual

Actualmente, el plugin permite:

- instalarse como plugin de tipo bloque,
- aparecer como bloque disponible dentro de Moodle,
- añadirse desde la interfaz de bloques,
- mostrar un mensaje visible dentro del bloque,
- lanzar una acción básica desde un botón de interacción.

En otras palabras, se trata de una primera versión funcional que demuestra la integración correcta del plugin con la plataforma.

## Estructura del plugin

El plugin sigue la estructura habitual de un bloque de Moodle. Entre sus elementos principales se encuentran:

- `version.php`, donde se define la versión y compatibilidad del plugin,
- `block_submitparty.php`, como archivo principal del bloque,
- la carpeta `db`, preparada para capacidades y ampliaciones relacionadas con base de datos,
- la carpeta `lang`, con varios archivos de idioma,
- la carpeta `pix`, reservada para recursos gráficos.

## Idiomas disponibles

El plugin incorpora soporte para varios idiomas:

- español
- catalán
- gallego
- euskera
- francés
- inglés

Esto permite adaptarlo mejor a contextos multilingües y facilita su presentación dentro de distintos entornos educativos.

## Instalación

Para instalar el plugin en Moodle, debe colocarse en la carpeta correspondiente a los bloques personalizados y completar después el proceso desde la administración del sitio.

Una vez reconocido por la plataforma, el bloque queda disponible para ser añadido desde la interfaz correspondiente.

## Posibles mejoras futuras

Aunque la versión actual se centra en ofrecer una base funcional estable, el plugin está planteado para crecer en futuras versiones. Algunas posibles ampliaciones son:

- permitir activar o desactivar la opción para cada usuario,
- mejorar el sistema de aleatorización,
- incorporar elementos visuales más elaborados,
- relacionar el comportamiento del bloque con acciones reales de entrega.

## Repositorio y presentación

Este repositorio recoge el código del plugin desarrollado para la práctica.

Vídeo de presentación:  
[Ver en Youtube](https://youtu.be/yvYbLau81es)

## Licencia
Este proyecto está licenciado bajo GNU GPL v3 o posterior.

## Autoría
Nerine Aoi
