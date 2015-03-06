<?php

/**
  Plugin Reminder pour Mantis BugTracker :

  - Envoi d'un email récapitulatif des échéances de la semaine aux développeurs

  @autor Hervé Hennes <contact@h-hennes.fr> 2013-2015
 */
auth_reauthenticate();
access_ensure_global_level(config_get('manage_plugin_threshold'));

html_page_top(plugin_lang_get('title'));
?>
<h2><?php echo plugin_lang_get('title'); ?></h2>
<p><?php echo plugin_lang_get('process_description'); ?></p>
<p><?php echo plugin_lang_get('process_cron'); ?></p>

<form action="<?php echo plugin_page('config_edit') ?>" method="post">
    <table>
        <tr <?php echo helper_alternate_class() ?>>
            <td class="category"><?php echo plugin_lang_get('config_upcomming_days'); ?></td>
            <td><input type="text" name="days" size="3" value="<?php echo plugin_config_get('days'); ?>" /></td>
        </tr>
        <tr <?php echo helper_alternate_class() ?>>
            <td class="category"><?php echo plugin_lang_get('email_object_title'); ?></td>
            <td><input type="text" name="email_object" size="100" value="<?php echo plugin_config_get('email_object'); ?>" /></td>
        </tr>
        <tr <?php echo helper_alternate_class() ?>>
            <td class="center" colspan="2"><input type="submit" value="<?php echo plugin_lang_get("config_action_update") ?>"/></td>
        </tr>
    </table>
</form>
