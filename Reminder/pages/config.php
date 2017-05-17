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

auth_reauthenticate();
access_ensure_global_level(config_get('manage_plugin_threshold'));

layout_page_header(plugin_lang_get('title'));

layout_page_begin('manage_overview_page.php');

print_manage_menu('manage_plugin_page.php');
?>
<h2><?php echo plugin_lang_get('title'); ?></h2>

<?php
//Confirmation Message
if (gpc_get('updated', 0) == 1) {
    echo '<div class="alert alert-success">'.plugin_lang_get('config_updated').'</div>';
}
?>

<p><?php echo plugin_lang_get('process_description'); ?></p>
<p><?php echo plugin_lang_get('process_cron'); ?></p>

<form action="<?php echo plugin_page('config_edit') ?>" method="post">
    <div class="widget-box widget-color-blue2">
        <div class="widget-header widget-header-small">
            <h4 class="widget-title lighter">
                <i class="ace-icon fa fa-edit"></i>
                <?php echo plugin_lang_get('edit_reminder'); ?>
            </h4>
        </div>
        <div class="widget-body">
            <div class="widget-main no-padding">

                <table class="table table-bordered table-condensed table-striped">
                    <tr <?php echo helper_alternate_class() ?>>
                        <td class="category"><?php echo plugin_lang_get('config_upcomming_days'); ?></td>
                        <td><input type="text" name="days" size="3" value="<?php echo plugin_config_get('days'); ?>" class="input-sm"/></td>
                    </tr>
                    <tr <?php echo helper_alternate_class() ?>>
                        <td class="category"><?php echo plugin_lang_get('email_object_title'); ?></td>
                        <td><input type="text" name="email_object" size="100" value="<?php echo plugin_config_get('email_object'); ?>" class="input-sm"/></td>
                    </tr>
                    <tr <?php echo helper_alternate_class() ?>>
                        <td class="category"><?php echo plugin_lang_get('enable_log'); ?></td>
                        <td>
                            <select name="enable_log" class="input-sm">
                                <option value="0" <?php if (plugin_config_get('enable_log') == 0) : ?> selected="selected" <?php endif; ?>><?php echo plugin_lang_get('no'); ?></option>
                                <option value="1" <?php if (plugin_config_get('enable_log') == 1) : ?> selected="selected" <?php endif; ?>><?php echo plugin_lang_get('yes'); ?></option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="widget-toolbox padding-8 clearfix">
                <input type="submit" class="btn btn-primary btn-white btn-round" value="<?php echo plugin_lang_get("config_action_update") ?>"/>
            </div>
        </div>
    </div>
</form>
