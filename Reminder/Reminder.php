<?php
# MantisBT - A PHP based bugtracking system
# MantisBT is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 2 of the License, or
# (at your option) any later version.
#
# MantisBT is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with MantisBT.  If not, see <http://www.gnu.org/licenses/>.

#
#  Reminder Plugin for Mantis BugTracker :
#  - Send recapitulative email to developpers 
#  © Hennes Hervé <contact@h-hennes.fr>
#    2013-2016
#  http://www.h-hennes.fr/blog/

class ReminderPlugin extends MantisPlugin {

    function register() {
        $this->name = plugin_lang_get('plugin_reminder_title');
        $this->description = plugin_lang_get('plugin_reminder_description');
        $this->page = 'config.php';
        $this->version = '0.1.5';
        $this->requires = array('MantisCore' => '2.2');
        $this->author = 'Hennes Hervé';
        $this->url = 'http://www.h-hennes.fr/blog/';
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