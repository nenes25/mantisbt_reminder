<?php
/**
  Plugin Reminder pour Mantis BugTracker :

  - Envoi d'un email récapitulatif des échéances de la semaine aux développeurs

  @autor Hervé Hennes <contact@h-hennes.fr> 2013-2015
 */

#Page de mise à jour de la configuration du module

auth_reauthenticate( );
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

$f_days = gpc_get_int('days');
$f_email_object = gpc_get_string('email_object');

#Mise à jour uniquement si les données ont changé
if( plugin_config_get( 'days' ) != $f_days ) {
	plugin_config_set( 'days', $f_days );
}

if( plugin_config_get( 'email_object' ) != $f_email_object ) {
	plugin_config_set( 'email_object', $f_email_object );
}

print_successful_redirect( plugin_page( 'config', true ) );

