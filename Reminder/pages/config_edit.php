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

#Page de mise à jour de la configuration du module

auth_reauthenticate( );
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

$f_days = gpc_get_int('days');
$f_email_object = gpc_get_string('email_object');
$f_enable_log = gpc_get_int('enable_log');

#Mise à jour uniquement si les données ont changé
if( plugin_config_get( 'days' ) != $f_days ) {
	plugin_config_set( 'days', $f_days );
}

if( plugin_config_get( 'email_object' ) != $f_email_object ) {
	plugin_config_set( 'email_object', $f_email_object );
}

if( plugin_config_get( 'enable_log' ) != $f_enable_log ) {
	plugin_config_set( 'enable_log', $f_enable_log );
}

print_successful_redirect( plugin_page( 'config&updated=1', true ) );
