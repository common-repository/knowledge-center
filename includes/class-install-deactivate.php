<?php
/**
 * Install and Deactivate Plugin Functions
 * @package KNOWLEDGE_CENTER
 * @since WPAS 4.0
 */
if (!defined('ABSPATH')) exit;
if (!class_exists('Knowledge_Center_Install_Deactivate')):
	/**
	 * Knowledge_Center_Install_Deactivate Class
	 * @since WPAS 4.0
	 */
	class Knowledge_Center_Install_Deactivate {
		private $option_name;
		/**
		 * Hooks for install and deactivation and create options
		 * @since WPAS 4.0
		 */
		public function __construct() {
			$this->option_name = 'knowledge_center';
			add_action('admin_init', array(
				$this,
				'check_update'
			));
			register_activation_hook(KNOWLEDGE_CENTER_PLUGIN_FILE, array(
				$this,
				'install'
			));
			register_deactivation_hook(KNOWLEDGE_CENTER_PLUGIN_FILE, array(
				$this,
				'deactivate'
			));
			add_action('wp_head', array(
				$this,
				'version_in_header'
			));
			add_action('admin_init', array(
				$this,
				'setup_pages'
			));
			add_action('admin_notices', array(
				$this,
				'install_notice'
			));
			add_action('admin_init', array(
				$this,
				'register_settings'
			) , 0);
			add_action('init', array(
				$this,
				'init_extensions'
			) , 99);
			do_action('emd_ext_actions', $this->option_name);
			add_filter('tiny_mce_before_init', array(
				$this,
				'tinymce_fix'
			));
		}
		public function check_update() {
			$curr_version = get_option($this->option_name . '_version', 1);
			$new_version = constant(strtoupper($this->option_name) . '_VERSION');
			if (version_compare($curr_version, $new_version, '<')) {
				$this->set_options();
				$this->set_roles_caps();
				if (!get_option($this->option_name . '_activation_date')) {
					$triggerdate = mktime(0, 0, 0, date('m') , date('d') + 7, date('Y'));
					add_option($this->option_name . '_activation_date', $triggerdate);
				}
				set_transient($this->option_name . '_activate_redirect', true, 30);
				do_action($this->option_name . '_upgrade', $new_version);
				update_option($this->option_name . '_version', $new_version);
			}
		}
		public function version_in_header() {
			$version = constant(strtoupper($this->option_name) . '_VERSION');
			$name = constant(strtoupper($this->option_name) . '_NAME');
			echo '<meta name="generator" content="' . esc_attr($name) . ' v' . esc_attr($version) . ' - https://emdplugins.com" />' . "\n";
		}
		public function init_extensions() {
			do_action('emd_ext_init', $this->option_name);
		}
		/**
		 * Runs on plugin install to setup custom post types and taxonomies
		 * flushing rewrite rules, populates settings and options
		 * creates roles and assign capabilities
		 * @since WPAS 4.0
		 *
		 */
		public function install() {
			$this->set_options();
			Emd_Panel::register();
			flush_rewrite_rules();
			$this->set_roles_caps();
			set_transient($this->option_name . '_activate_redirect', true, 30);
			do_action('emd_ext_install_hook', $this->option_name);
		}
		/**
		 * Runs on plugin deactivate to remove options, caps and roles
		 * flushing rewrite rules
		 * @since WPAS 4.0
		 *
		 */
		public function deactivate() {
			flush_rewrite_rules();
			$this->remove_caps_roles();
			$this->reset_options();
			do_action('emd_ext_deactivate', $this->option_name);
		}
		/**
		 * Register notification and/or license settings
		 * @since WPAS 4.0
		 *
		 */
		public function register_settings() {
			do_action('emd_ext_register', $this->option_name);
			if (!get_transient($this->option_name . '_activate_redirect')) {
				return;
			}
			// Delete the redirect transient.
			delete_transient($this->option_name . '_activate_redirect');
			$query_args = array(
				'page' => $this->option_name
			);
			wp_safe_redirect(add_query_arg($query_args, admin_url('admin.php')));
		}
		/**
		 * Sets caps and roles
		 *
		 * @since WPAS 4.0
		 *
		 */
		public function set_roles_caps() {
			global $wp_roles;
			$cust_roles = Array();
			update_option($this->option_name . '_cust_roles', $cust_roles);
			$add_caps = Array(
				'edit_kb_tags' => Array(
					'administrator'
				) ,
				'assign_kb_tags' => Array(
					'administrator'
				) ,
				'view_knowledge_center_dashboard' => Array(
					'administrator'
				) ,
				'delete_kb_tags' => Array(
					'administrator'
				) ,
				'manage_kb_tags' => Array(
					'administrator'
				) ,
				'edit_kb_group' => Array(
					'administrator'
				) ,
				'assign_kb_group' => Array(
					'administrator'
				) ,
				'edit_emd_panels' => Array(
					'administrator'
				) ,
				'manage_operations_emd_panels' => Array(
					'administrator'
				) ,
				'delete_kb_group' => Array(
					'administrator'
				) ,
				'manage_kb_group' => Array(
					'administrator'
				) ,
			);
			update_option($this->option_name . '_add_caps', $add_caps);
			if (class_exists('WP_Roles')) {
				if (!isset($wp_roles)) {
					$wp_roles = new WP_Roles();
				}
			}
			if (is_object($wp_roles)) {
				if (!empty($cust_roles)) {
					foreach ($cust_roles as $krole => $vrole) {
						$myrole = get_role($krole);
						if (empty($myrole)) {
							$myrole = add_role($krole, $vrole);
						}
					}
				}
				$this->set_reset_caps($wp_roles, 'add');
			}
		}
		/**
		 * Removes caps and roles
		 *
		 * @since WPAS 4.0
		 *
		 */
		public function remove_caps_roles() {
			global $wp_roles;
			if (class_exists('WP_Roles')) {
				if (!isset($wp_roles)) {
					$wp_roles = new WP_Roles();
				}
			}
			if (is_object($wp_roles)) {
				$this->set_reset_caps($wp_roles, 'remove');
			}
		}
		/**
		 * Set  capabilities
		 *
		 * @since WPAS 4.0
		 * @param object $wp_roles
		 * @param string $type
		 *
		 */
		public function set_reset_caps($wp_roles, $type) {
			$caps['enable'] = get_option($this->option_name . '_add_caps', Array());
			$caps['enable'] = apply_filters('emd_ext_get_caps', $caps['enable'], $this->option_name);
			foreach ($caps as $stat => $role_caps) {
				foreach ($role_caps as $mycap => $roles) {
					foreach ($roles as $myrole) {
						if (($type == 'add' && $stat == 'enable') || ($stat == 'disable' && $type == 'remove')) {
							$wp_roles->add_cap($myrole, $mycap);
						} else if (($type == 'remove' && $stat == 'enable') || ($type == 'add' && $stat == 'disable')) {
							$wp_roles->remove_cap($myrole, $mycap);
						}
					}
				}
			}
		}
		/**
		 * Set app specific options
		 *
		 * @since WPAS 4.0
		 *
		 */
		private function set_options() {
			$access_views = Array();
			if (get_option($this->option_name . '_setup_pages', 0) == 0) {
				update_option($this->option_name . '_setup_pages', 1);
			}
			//conf parameters for rating
			$has_ratings = Array(
				'panel_rating' => Array(
					'label' => __('Panel Rating', 'knowledge-center') ,
					'lite' => 0,
					'entity' => 'emd_panel',
					'entity_label' => __('Panels', 'knowledge-center') ,
					'mid_name' => 'emd_panel_info_emd_panel_0',
					'menu_parent' => 'edit.php?post_type=emd_panel'
				)
			);
			update_option($this->option_name . '_has_ratings', $has_ratings);
			$ent_list = Array(
				'emd_panel' => Array(
					'label' => __('Panels', 'knowledge-center') ,
					'rewrite' => 'panels',
					'archive_view' => 0,
					'rest_api' => 0,
					'sortable' => 0,
					'searchable' => 1,
					'class_title' => Array(
						'emd_panel_id'
					) ,
					'unique_keys' => Array(
						'emd_panel_id'
					) ,
					'blt_list' => Array(
						'blt_content' => __('Content', 'knowledge-center') ,
					) ,
					'req_blt' => Array(
						'blt_title' => Array(
							'msg' => __('Title', 'knowledge-center')
						) ,
					) ,
				) ,
			);
			update_option($this->option_name . '_ent_list', $ent_list);
			$shc_list['app'] = 'Knowledge Center';
			$shc_list['has_gmap'] = 0;
			$shc_list['has_form_lite'] = 1;
			$shc_list['has_lite'] = 1;
			$shc_list['has_bs'] = 1;
			$shc_list['has_autocomplete'] = 0;
			$shc_list['remove_vis'] = 1;
			$shc_list['shcs']['std_panel'] = Array(
				"class_name" => "emd_panel",
				"type" => "std",
				'page_title' => __('Frequently Asked Questions', 'knowledge-center') ,
			);
			if (!empty($shc_list)) {
				update_option($this->option_name . '_shc_list', $shc_list);
			}
			$attr_list['emd_panel']['emd_panel_id'] = Array(
				'label' => __('ID', 'knowledge-center') ,
				'display_type' => 'hidden',
				'required' => 0,
				'srequired' => 0,
				'filterable' => 1,
				'list_visible' => 1,
				'mid' => 'emd_panel_info_emd_panel_0',
				'desc' => __('Unique identifier for a panel. It is incremented by 1.', 'knowledge-center') ,
				'autoinc_start' => 1,
				'autoinc_incr' => 1,
				'type' => 'char',
				'hidden_func' => 'autoinc',
				'uniqueAttr' => true,
			);
			$attr_list['emd_panel']['emd_panel_featured'] = Array(
				'label' => __('Featured', 'knowledge-center') ,
				'display_type' => 'checkbox',
				'required' => 0,
				'srequired' => 0,
				'filterable' => 1,
				'list_visible' => 1,
				'mid' => 'emd_panel_info_emd_panel_0',
				'type' => 'binary',
				'options' => array(
					1 => 1
				) ,
			);
			$attr_list['emd_panel']['emd_panel_color'] = Array(
				'label' => __('Context Color', 'knowledge-center') ,
				'display_type' => 'select',
				'required' => 0,
				'srequired' => 0,
				'filterable' => 0,
				'list_visible' => 1,
				'mid' => 'emd_panel_info_emd_panel_0',
				'desc' => __('Colors the panel header to highlight or group similar content.', 'knowledge-center') ,
				'type' => 'char',
				'options' => array(
					'' => __('Please Select', 'knowledge-center') ,
					'default' => esc_attr(__('Default', 'knowledge-center')) ,
					'primary' => esc_attr(__('Primary', 'knowledge-center')) ,
					'success' => esc_attr(__('Success', 'knowledge-center')) ,
					'info' => esc_attr(__('Info', 'knowledge-center')) ,
					'danger' => esc_attr(__('Danger', 'knowledge-center')) ,
					'warning' => esc_attr(__('Warning', 'knowledge-center'))
				) ,
				'std' => 'default',
			);
			$attr_list['emd_panel']['emd_panel_initial_state'] = Array(
				'label' => __('Initial State', 'knowledge-center') ,
				'display_type' => 'radio',
				'required' => 0,
				'srequired' => 0,
				'filterable' => 0,
				'list_visible' => 1,
				'mid' => 'emd_panel_info_emd_panel_0',
				'desc' => __('Sets the initial state of a panel\'s content.', 'knowledge-center') ,
				'type' => 'char',
				'options' => array(
					'' => esc_attr(__('Hide content', 'knowledge-center')) ,
					'in' => esc_attr(__('Show content', 'knowledge-center'))
				) ,
			);
			$attr_list = apply_filters('emd_ext_attr_list', $attr_list, $this->option_name);
			if (!empty($attr_list)) {
				update_option($this->option_name . '_attr_list', $attr_list);
			}
			update_option($this->option_name . '_glob_init_list', Array());
			if (!empty($glob_forms_list)) {
				update_option($this->option_name . '_glob_forms_init_list', $glob_forms_list);
				if (get_option($this->option_name . '_glob_forms_list') === false) {
					update_option($this->option_name . '_glob_forms_list', $glob_forms_list);
				}
			}
			$tax_list['emd_panel']['kb_group'] = Array(
				'archive_view' => 0,
				'label' => __('KC Groups', 'knowledge-center') ,
				'single_label' => __('KC Group', 'knowledge-center') ,
				'default' => '',
				'type' => 'single',
				'hier' => 0,
				'sortable' => 0,
				'list_visible' => 1,
				'required' => 0,
				'srequired' => 0,
				'rewrite' => 'kb_group'
			);
			$tax_list['emd_panel']['kb_tags'] = Array(
				'archive_view' => 0,
				'label' => __('KC Tags', 'knowledge-center') ,
				'single_label' => __('KC Tag', 'knowledge-center') ,
				'default' => '',
				'type' => 'multi',
				'hier' => 0,
				'sortable' => 0,
				'list_visible' => 1,
				'required' => 0,
				'srequired' => 0,
				'rewrite' => 'kb_tags'
			);
			$tax_list = apply_filters('emd_ext_tax_list', $tax_list, $this->option_name);
			if (!empty($tax_list)) {
				update_option($this->option_name . '_tax_list', $tax_list);
			}
			$emd_activated_plugins = get_option('emd_activated_plugins');
			if (!$emd_activated_plugins) {
				update_option('emd_activated_plugins', Array(
					'knowledge-center'
				));
			} elseif (!in_array('knowledge-center', $emd_activated_plugins)) {
				array_push($emd_activated_plugins, 'knowledge-center');
				update_option('emd_activated_plugins', $emd_activated_plugins);
			}
			//conf parameters for incoming email
			//conf parameters for inline entity
			//conf parameters for calendar
			//action to configure different extension conf parameters for this plugin
			do_action('emd_ext_set_conf', 'knowledge-center');
		}
		/**
		 * Reset app specific options
		 *
		 * @since WPAS 4.0
		 *
		 */
		private function reset_options() {
			delete_option($this->option_name . '_shc_list');
			do_action('emd_ext_reset_conf', 'knowledge-center');
		}
		/**
		 * Show admin notices
		 *
		 * @since WPAS 4.0
		 *
		 * @return html
		 */
		public function install_notice() {
			if (isset($_GET[$this->option_name . '_adm_notice1'])) {
				update_option($this->option_name . '_adm_notice1', true);
			}
			if (current_user_can('manage_options') && get_option($this->option_name . '_adm_notice1') != 1) {
?>
<div class="updated">
<?php
				printf('<p><a href="%1s" target="_blank"> %2$s </a>%3$s<a style="float:right;" href="%4$s"><span class="dashicons dashicons-dismiss" style="font-size:15px;"></span>%5$s</a></p>', 'https://docs.emdplugins.com/docs/knowledge-center-community-documentation/?pk_campaign=kc-com&pk_source=plugin&pk_medium=link&pk_content=notice', __('New To Knowledge Center? Review the documentation!', 'wpas') , __('&#187;', 'wpas') , esc_url(add_query_arg($this->option_name . '_adm_notice1', true)) , __('Dismiss', 'wpas'));
?>
</div>
<?php
			}
			if (isset($_GET[$this->option_name . '_adm_notice2'])) {
				update_option($this->option_name . '_adm_notice2', true);
			}
			if (current_user_can('manage_options') && get_option($this->option_name . '_adm_notice2') != 1) {
?>
<div class="updated">
<?php
				printf('<p><a href="%1s" target="_blank"> %2$s </a>%3$s<a style="float:right;" href="%4$s"><span class="dashicons dashicons-dismiss" style="font-size:15px;"></span>%5$s</a></p>', 'https://emdplugins.com/plugins/knowledge-center-wordpress-plugin/?pk_campaign=kc-com&pk_source=plugin&pk_medium=link&pk_content=notice', __('Get More Features to Empower Your Customers!', 'wpas') , __('&#187;', 'wpas') , esc_url(add_query_arg($this->option_name . '_adm_notice2', true)) , __('Dismiss', 'wpas'));
?>
</div>
<?php
			}
			if (current_user_can('manage_options') && get_option($this->option_name . '_setup_pages') == 1) {
				echo "<div id=\"message\" class=\"updated\"><p><strong>" . __('Welcome to Knowledge Center', 'knowledge-center') . "</strong></p>
           <p class=\"submit\"><a href=\"" . add_query_arg('setup_knowledge_center_pages', 'true', admin_url('index.php')) . "\" class=\"button-primary\">" . __('Setup Knowledge Center Pages', 'knowledge-center') . "</a> <a class=\"skip button-primary\" href=\"" . add_query_arg('skip_setup_knowledge_center_pages', 'true', admin_url('index.php')) . "\">" . __('Skip setup', 'knowledge-center') . "</a></p>
         </div>";
			}
		}
		/**
		 * Setup pages for components and redirect to dashboard
		 *
		 * @since WPAS 4.0
		 *
		 */
		public function setup_pages() {
			if (!is_admin()) {
				return;
			}
			if (!empty($_GET['setup_' . $this->option_name . '_pages'])) {
				$shc_list = get_option($this->option_name . '_shc_list');
				emd_create_install_pages($this->option_name, $shc_list);
				update_option($this->option_name . '_setup_pages', 2);
				wp_redirect(admin_url('admin.php?page=' . $this->option_name . '_settings&knowledge-center-installed=true'));
				exit;
			}
			if (!empty($_GET['skip_setup_' . $this->option_name . '_pages'])) {
				update_option($this->option_name . '_setup_pages', 2);
				wp_redirect(admin_url('admin.php?page=' . $this->option_name . '_settings'));
				exit;
			}
		}
		public function tinymce_fix($init) {
			global $post;
			$ent_list = get_option($this->option_name . '_ent_list', Array());
			if (!empty($post) && in_array($post->post_type, array_keys($ent_list))) {
				$init['wpautop'] = false;
				$init['indent'] = true;
			}
			return $init;
		}
	}
endif;
return new Knowledge_Center_Install_Deactivate();