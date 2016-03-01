<?php

/**
  Plugin Reminder pour Mantis BugTracker :

  - Envoi d'un email récapitulatif des échéances de la semaine aux développeurs

  @autor Hervé Hennes <contact@h-hennes.fr> 2013-2015
 */
class ReminderPlugin extends MantisPlugin {

    function register() {
        $this->name = plugin_lang_get('plugin_reminder_title');
        $this->description = plugin_lang_get('plugin_reminder_description');
        $this->page = 'config.php';
        $this->version = '0.1.3';
        $this->requires = array('MantisCore' => '1.2.0',);
        $this->author = 'Hennes Hervé';
        $this->url = 'http://www.h-hennes.fr/';
    }

    /**
     * Configuration par défaut du module
     */
    function config() {

        return array(
            'days' => 7,
            'email_object' => plugin_lang_get('email_object'),
            'enable_log' => 0
        );
    }

}

?>