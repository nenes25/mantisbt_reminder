<?php

/**
  Plugin Reminder pour Mantis BugTracker :
  Page appellée via cron de manière hebdomadaire pour envoyer un récapitulatif des bugs en attente de traitement
  @autor Hervé Hennes <contact@h-hennes.fr>
  2013 - 2015
 */
require_once( dirname(__FILE__) . '/../../../core.php' );

ini_set('display_errors','on');

#Recherche des informations sur les bugs
$sql_bugs = 'SELECT b.id,b.handler_id,b.summary,b.due_date,u.enabled,u.email,t.name
						FROM ' . db_get_table('mantis_bug_table') . ' b
						LEFT JOIN ' . db_get_table('mantis_user_table') . ' u ON ( b.handler_id = u.id )
						LEFT JOIN ' . db_get_table('mantis_project_table') . ' t ON ( t.id = b.project_id)
						WHERE b.due_date <> 1
						AND b.status < 80';


$t_bug_result = db_query($sql_bugs);

#Si il y'a des bugs à traiter
if (db_num_rows($t_bug_result) > 0) {
    
    $t_date_now = date('Y-m-d');
    $t_date_var = explode('-', $t_date_now);
    $t_date_x_days = date('Y-m-d', mktime($t_date_var[1], $t_date_var[2], $t_date_var[0]) + 24 * 3600 * plugin_config_get('days'));
    $t_developpers_reminder_bugs = array();

    #Traitement des bugs et insertion des données dans un tableau
    while ($t_result = db_fetch_array($t_bug_result)) {

        $t_bug_date = date('Y-m-d', $t_result['due_date']);
        $t_result['date_formated'] = $t_bug_date;

        #Bug avec une échéance dépassée
        if ($t_bug_date < $t_date_now) {
            #On groupe les bugs par utilisateurs uniquement si ils sont actifs
            if ($t_result['enabled'] == 1)
                $t_developpers_reminder_bugs[$t_result['handler_id']]['overdue'][] = $t_result;
        }

        #Bug avec une échéance à venir dans les 7 prochains jours //
        if ($t_bug_date >= $t_date_now && $t_bug_date <= $t_date_x_days) {
            #On groupe les bugs par utilisateurs uniquement si ils sont actifs
            if ($t_result['enabled'] == 1)
                $t_developpers_reminder_bugs[$t_result['handler_id']]['to_come'][] = $t_result;
        }
    }

    var_dump($t_developpers_reminder_bugs);
    
    #Envoi des emails recapitulatif
    #@todo : Voir pour historiser les envois dans une table sql pour éviter les envois multiples
    foreach ($t_developpers_reminder_bugs as $t_user_id => $t_bugs_arrays) {

        $message = '<html><head><title>' . plugin_config_get('email_object') . '</title></head><body>';
        $message .= plugin_lang_get('email_start');

        #Bugs dont la date d'échéance est dépassée
        if (sizeof($t_bugs_arrays['overdue'])) {

            $message .= '<br /><strong>' . plugin_lang_get('email_overdue_bugs') . '</strong><ul>';

            foreach ($t_bugs_arrays['overdue'] as $t_overdue_bug)
                $message .= '<li>' . $t_overdue_bug['id'] . '(' . $t_overdue_bug['name'] . ') ' . $t_overdue_bug['summary'] . ' - ' . $t_overdue_bug['date_formated'] . '</li>';

            $message .= '</ul>';

            $t_user_email = $t_bugs_arrays['overdue'][0]['email'];
        }

        #Bugs à venir
        if (sizeof($t_bugs_arrays['to_come'])) {

            $message .= '<br /><strong>' . plugin_lang_get('email_to_come_bugs') . '</strong><ul>';

            foreach ($t_bugs_arrays['to_come'] as $t_coming_bug)
                $message .= '<li> ' . $t_coming_bug['id'] . ' - (' . $t_coming_bug['name'] . ') ' . $t_coming_bug['summary'] . ' - ' . $t_coming_bug['date_formated'] . '</li>';

            $message .= '</ul>';

            $t_user_email = $t_bugs_arrays['to_come'][0]['email'];
        }

        $message .= '<br />' . plugin_lang_get('email_end') . '</body></html>';

        #Envoi de l'email
        $t_from_email = config_get('from_name').' <'.config_get('from_email').'>';
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: ' . $t_from_email . "\r\n";
        echo $t_from_email.'<br />';
        echo 'Envoi du mail '.plugin_config_get('email_object').' a '.$t_user_email.'<br />'.$message.'<br />';
        mail($t_user_email, plugin_config_get('email_object'), $message, $headers);
    }
}
    