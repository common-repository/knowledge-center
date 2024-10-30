<?php
/**
 * Entity Widget Classes
 *
 * @package KNOWLEDGE_CENTER
 * @since WPAS 4.0
 */
if (!defined('ABSPATH')) exit;
/**
 * Entity widget class extends Emd_Widget class
 *
 * @since WPAS 4.0
 */
class knowledge_center_featured_panels_widget extends Emd_Widget {
	public $title;
	public $text_domain = 'knowledge-center';
	public $class_label;
	public $class = 'emd_panel';
	public $type = 'entity';
	public $has_pages = false;
	public $css_label = 'featured-panels';
	public $id = 'knowledge_center_featured_panels_widget';
	public $query_args = array(
		'post_type' => 'emd_panel',
		'post_status' => 'publish',
		'orderby' => 'menu_order',
		'order' => 'DESC',
		'context' => 'knowledge_center_featured_panels_widget',
	);
	public $filter = 'attr::emd_panel_featured::is::1';
	public $header = '';
	public $footer = '';
	/**
	 * Instantiate entity widget class with params
	 *
	 * @since WPAS 4.0
	 */
	public function __construct() {
		parent::__construct($this->id, __('Featured Panels', 'knowledge-center') , __('Panels', 'knowledge-center') , __('The most recent panels', 'knowledge-center'));
	}
	/**
	 * Get header and footer for layout
	 *
	 * @since WPAS 4.6
	 */
	protected function get_header_footer() {
		ob_start();
		emd_get_template_part('knowledge_center', 'widget', 'featured-panels-header');
		$this->header = ob_get_clean();
		ob_start();
		emd_get_template_part('knowledge_center', 'widget', 'featured-panels-footer');
		$this->footer = ob_get_clean();
	}
	/**
	 * Enqueue css and js for widget
	 *
	 * @since WPAS 4.5
	 */
	protected function enqueue_scripts() {
		wp_enqueue_style('emd-pagination');
		$emd_widg_paging_vars['ajax_url'] = admin_url('admin-ajax.php');
		wp_enqueue_script('emd-widg-paging-js');
		wp_localize_script('emd-widg-paging-js', 'emd_widg_paging_vars', $emd_widg_paging_vars);
		knowledge_center_enq_custom_css_js();
	}
	/**
	 * Returns widget layout
	 *
	 * @since WPAS 4.0
	 */
	public static function layout() {
		ob_start();
		emd_get_template_part('knowledge_center', 'widget', 'featured-panels-content');
		$layout = ob_get_clean();
		return $layout;
	}
}
/**
 * Entity widget class extends Emd_Widget class
 *
 * @since WPAS 4.0
 */
class knowledge_center_recent_panels_widget extends Emd_Widget {
	public $title;
	public $text_domain = 'knowledge-center';
	public $class_label;
	public $class = 'emd_panel';
	public $type = 'entity';
	public $has_pages = false;
	public $css_label = 'recent-panels';
	public $id = 'knowledge_center_recent_panels_widget';
	public $query_args = array(
		'post_type' => 'emd_panel',
		'post_status' => 'publish',
		'orderby' => 'date',
		'order' => 'DESC',
		'context' => 'knowledge_center_recent_panels_widget',
	);
	public $filter = '';
	public $header = '';
	public $footer = '';
	/**
	 * Instantiate entity widget class with params
	 *
	 * @since WPAS 4.0
	 */
	public function __construct() {
		parent::__construct($this->id, __('Recent Panels', 'knowledge-center') , __('Panels', 'knowledge-center') , __('The most recent panels', 'knowledge-center'));
	}
	/**
	 * Get header and footer for layout
	 *
	 * @since WPAS 4.6
	 */
	protected function get_header_footer() {
		ob_start();
		emd_get_template_part('knowledge_center', 'widget', 'recent-panels-header');
		$this->header = ob_get_clean();
		ob_start();
		emd_get_template_part('knowledge_center', 'widget', 'recent-panels-footer');
		$this->footer = ob_get_clean();
	}
	/**
	 * Enqueue css and js for widget
	 *
	 * @since WPAS 4.5
	 */
	protected function enqueue_scripts() {
		wp_enqueue_style('emd-pagination');
		$emd_widg_paging_vars['ajax_url'] = admin_url('admin-ajax.php');
		wp_enqueue_script('emd-widg-paging-js');
		wp_localize_script('emd-widg-paging-js', 'emd_widg_paging_vars', $emd_widg_paging_vars);
		knowledge_center_enq_custom_css_js();
	}
	/**
	 * Returns widget layout
	 *
	 * @since WPAS 4.0
	 */
	public static function layout() {
		ob_start();
		emd_get_template_part('knowledge_center', 'widget', 'recent-panels-content');
		$layout = ob_get_clean();
		return $layout;
	}
}
$access_views = get_option('knowledge_center_access_views', Array());
if (empty($access_views['widgets']) || (!empty($access_views['widgets']) && in_array('featured_panels', $access_views['widgets']) && current_user_can('view_featured_panels'))) {
	register_widget('knowledge_center_featured_panels_widget');
}
if (empty($access_views['widgets']) || (!empty($access_views['widgets']) && in_array('recent_panels', $access_views['widgets']) && current_user_can('view_recent_panels'))) {
	register_widget('knowledge_center_recent_panels_widget');
}