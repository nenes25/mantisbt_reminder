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
#  2013-2020
#  https://www.h-hennes.fr/blog/
#  https://github.com/nenes25/mantisbt_reminder

class ReminderPlugin extends MantisPlugin {

    function register() {
        $this->name = plugin_lang_get('plugin_reminder_title');
        $this->description = plugin_lang_get('plugin_reminder_description');
        $this->page = 'config.php';
        $this->version = '0.1.6';
        $this->requires = array('MantisCore' => '2.2');
        $this->author = 'Hennes Hervé';
        $this->url = 'https://github.com/nenes25/mantisbt_reminder';

        #Cron Manager
        $this->uses = array(
            'HhCronManager' => '0.1.0'
        );
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

    /**
     * Liste des hooks du plugin
     * @return array
     */
    function hooks()
    {
        global $g_event_cache;
        $t_hooks = [];
        #Custom Hook from plugin HhCronManager
        if (array_key_exists('EVENT_PLUGIN_HHCRONMANAGER_COLLECT_CRON', $g_event_cache)) {
            $t_hooks['EVENT_PLUGIN_HHCRONMANAGER_COLLECT_CRON'] = 'collect_cron';
        }
        return $t_hooks;
    }

    /**
     * Définition des tâches cron du module
     * @param string $eventName
     * @return array
     */
    public function collect_cron($eventName)
    {
        $pluginName = str_replace('Plugin','',get_class($this));
        return [
            [
                'plugin' => $pluginName,
                'code' => $pluginName . '_cron_reminder',#unique code
                'frequency' => '0 8 * * * 1',#cron expression
                'description' => plugin_lang_get('cron_reminder_description'),
                'url' => 'reminder-cron',#plugin page name
            ],
        ];
    }

}