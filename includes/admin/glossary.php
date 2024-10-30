<?php
/**
 * Settings Glossary Functions
 *
 * @package KNOWLEDGE_CENTER
 * @since WPAS 4.0
 */
if (!defined('ABSPATH')) exit;
add_action('knowledge_center_settings_glossary', 'knowledge_center_settings_glossary');
/**
 * Display glossary information
 * @since WPAS 4.0
 *
 * @return html
 */
function knowledge_center_settings_glossary() {
	global $title;
?>
<div class="wrap">
<h2><?php echo esc_html($title); ?></h2>
<p><?php _e('Knowledge Center helps categorize related short content in a user-friendly way.', 'knowledge-center'); ?></p>
<p><?php _e('The below are the definitions of entities, attributes, and terms included in Knowledge Center.', 'knowledge-center'); ?></p>
<div id="glossary" class="accordion-container">
<ul class="outer-border">
<li id="emd_panel" class="control-section accordion-section open">
<h3 class="accordion-section-title hndle" tabindex="1"><?php _e('Panels', 'knowledge-center'); ?></h3>
<div class="accordion-section-content">
<div class="inside">
<table class="form-table"><p class"lead"><?php _e('Any short length content which may be used to display term definitions, frequently asked questions etc.', 'knowledge-center'); ?></p><tr><th style='font-size: 1.1em;color:cadetblue;border-bottom: 1px dashed;padding-bottom: 10px;' colspan=2><div><?php _e('Attributes', 'knowledge-center'); ?></div></th></tr>
<tr>
<th><?php _e('Title', 'knowledge-center'); ?></th>
<td><?php _e(' Title is a required field. Title is filterable in the admin area. Title does not have a default value. ', 'knowledge-center'); ?></td>
</tr>
<tr>
<th><?php _e('Content', 'knowledge-center'); ?></th>
<td><?php _e(' Content does not have a default value. ', 'knowledge-center'); ?></td>
</tr>
<tr>
<th><?php _e('ID', 'knowledge-center'); ?></th>
<td><?php _e('Unique identifier for a panel. It is incremented by 1. Being a unique identifier, it uniquely distinguishes each instance of Panel entity. ID is filterable in the admin area. ID does not have a default value. ', 'knowledge-center'); ?></td>
</tr>
<tr>
<th><?php _e('Featured', 'knowledge-center'); ?></th>
<td><?php _e(' Featured is filterable in the admin area. Featured does not have a default value. ', 'knowledge-center'); ?></td>
</tr>
<tr>
<th><?php _e('Context Color', 'knowledge-center'); ?></th>
<td><?php _e('Colors the panel header to highlight or group similar content. Context Color has a default value of <b>\'default\'</b>.Context Color is displayed as a dropdown and has predefined values of: default, primary, success, info, danger, warning.', 'knowledge-center'); ?></td>
</tr>
<tr>
<th><?php _e('Initial State', 'knowledge-center'); ?></th>
<td><?php _e('Sets the initial state of a panel\'s content. Initial State does not have a default value. ', 'knowledge-center'); ?></td>
</tr><tr><th style='font-size:1.1em;color:cadetblue;border-bottom: 1px dashed;padding-bottom: 10px;' colspan=2><div><?php _e('Taxonomies', 'knowledge-center'); ?></div></th></tr>
<tr>
<th><?php _e('KC Group', 'knowledge-center'); ?></th>

<td><?php _e(' KC Group accepts multiple values like tags', 'knowledge-center'); ?>. <?php _e('KC Group does not have a default value', 'knowledge-center'); ?>.<div class="taxdef-block"><p><?php _e('There are no preset values for <b>KC Group.</b>', 'knowledge-center'); ?></p></div></td>
</tr>

<tr>
<th><?php _e('KC Tag', 'knowledge-center'); ?></th>

<td><?php _e(' KC Tag accepts multiple values like tags', 'knowledge-center'); ?>. <?php _e('KC Tag does not have a default value', 'knowledge-center'); ?>.<div class="taxdef-block"><p><?php _e('There are no preset values for <b>KC Tag.</b>', 'knowledge-center'); ?></p></div></td>
</tr>
</table>
</div>
</div>
</li>
</ul>
</div>
</div>
<?php
}