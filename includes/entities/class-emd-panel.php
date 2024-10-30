<?php
/**
 * Entity Class
 *
 * @package KNOWLEDGE_CENTER
 * @since WPAS 4.0
 */
if (!defined('ABSPATH')) exit;
/**
 * Emd_Panel Class
 * @since WPAS 4.0
 */
class Emd_Panel extends Emd_Entity {
	protected $post_type = 'emd_panel';
	protected $textdomain = 'knowledge-center';
	protected $sing_label;
	protected $plural_label;
	protected $menu_entity;
	protected $id;
	/**
	 * Initialize entity class
	 *
	 * @since WPAS 4.0
	 *
	 */
	public function __construct() {
		add_action('init', array(
			$this,
			'set_filters'
		) , 1);
		add_action('admin_init', array(
			$this,
			'set_metabox'
		));
		add_filter('post_updated_messages', array(
			$this,
			'updated_messages'
		));
		add_action('admin_menu', array(
			$this,
			'add_menu_link'
		));
		add_action('admin_head-edit.php', array(
			$this,
			'add_opt_button'
		));
		add_action('admin_menu', array(
			$this,
			'add_top_menu_link'
		) , 1);
		$is_adv_filt_ext = apply_filters('emd_adv_filter_on', 0);
		if ($is_adv_filt_ext === 0) {
			add_action('manage_emd_panel_posts_custom_column', array(
				$this,
				'custom_columns'
			) , 10, 2);
			add_filter('manage_emd_panel_posts_columns', array(
				$this,
				'column_headers'
			));
		}
		add_action('admin_init', array(
			$this,
			'set_single_taxs'
		));
		add_filter('post_row_actions', array(
			$this,
			'duplicate_link'
		) , 10, 2);
		add_action('admin_action_emd_duplicate_entity', array(
			$this,
			'duplicate_entity'
		));
	}
	public function set_single_taxs() {
		global $pagenow;
		if ('post-new.php' === $pagenow || 'post.php' === $pagenow) {
			if ((isset($_REQUEST['post_type']) && $this->post_type === $_REQUEST['post_type']) || (isset($_REQUEST['post']) && get_post_type($_REQUEST['post']) === $this->post_type)) {
				$this->stax = new Emd_Single_Taxonomy('knowledge-center');
			}
		}
	}
	public function change_title_disable_emd_temp($title, $id) {
		$post = get_post($id);
		if ($this->post_type == $post->post_type && (!empty($this->id) && $this->id == $id)) {
			return '';
		}
		return $title;
	}
	/**
	 * Get column header list in admin list pages
	 * @since WPAS 4.0
	 *
	 * @param array $columns
	 *
	 * @return array $columns
	 */
	public function column_headers($columns) {
		$ent_list = get_option(str_replace("-", "_", $this->textdomain) . '_ent_list');
		if (!empty($ent_list[$this->post_type]['featured_img'])) {
			$columns['featured_img'] = __('Featured Image', $this->textdomain);
		}
		foreach ($this->boxes as $mybox) {
			foreach ($mybox['fields'] as $fkey => $mybox_field) {
				if (!in_array($fkey, Array(
					'wpas_form_name',
					'wpas_form_submitted_by',
					'wpas_form_submitted_ip'
				)) && !in_array($mybox_field['type'], Array(
					'textarea',
					'wysiwyg'
				)) && $mybox_field['list_visible'] == 1) {
					$columns[$fkey] = $mybox_field['name'];
				}
			}
		}
		$taxonomies = get_object_taxonomies($this->post_type, 'objects');
		if (!empty($taxonomies)) {
			$tax_list = get_option(str_replace("-", "_", $this->textdomain) . '_tax_list');
			foreach ($taxonomies as $taxonomy) {
				if (!empty($tax_list[$this->post_type][$taxonomy->name]) && $tax_list[$this->post_type][$taxonomy->name]['list_visible'] == 1) {
					$columns[$taxonomy->name] = $taxonomy->label;
				}
			}
		}
		$rel_list = get_option(str_replace("-", "_", $this->textdomain) . '_rel_list');
		if (!empty($rel_list)) {
			foreach ($rel_list as $krel => $rel) {
				if ($rel['from'] == $this->post_type && in_array($rel['show'], Array(
					'any',
					'from'
				))) {
					$columns[$krel] = $rel['from_title'];
				} elseif ($rel['to'] == $this->post_type && in_array($rel['show'], Array(
					'any',
					'to'
				))) {
					$columns[$krel] = $rel['to_title'];
				}
			}
		}
		return $columns;
	}
	/**
	 * Get custom column values in admin list pages
	 * @since WPAS 4.0
	 *
	 * @param int $column_id
	 * @param int $post_id
	 *
	 * @return string $value
	 */
	public function custom_columns($column_id, $post_id) {
		if (taxonomy_exists($column_id) == true) {
			$terms = get_the_terms($post_id, $column_id);
			$ret = array();
			if (!empty($terms)) {
				foreach ($terms as $term) {
					$url = add_query_arg(array(
						'post_type' => $this->post_type,
						'term' => $term->slug,
						'taxonomy' => $column_id
					) , admin_url('edit.php'));
					$a_class = preg_replace('/^emd_/', '', $this->post_type);
					$ret[] = sprintf('<a href="%s"  class="' . $a_class . '-tax ' . $term->slug . '">%s</a>', $url, $term->name);
				}
			}
			echo wp_kses_post(implode(', ', $ret));
			return;
		}
		$rel_list = get_option(str_replace("-", "_", $this->textdomain) . '_rel_list');
		if (!empty($rel_list) && !empty($rel_list[$column_id])) {
			$rel_arr = $rel_list[$column_id];
			if ($rel_arr['from'] == $this->post_type) {
				$other_ptype = $rel_arr['to'];
			} elseif ($rel_arr['to'] == $this->post_type) {
				$other_ptype = $rel_arr['from'];
			}
			$column_id = str_replace('rel_', '', $column_id);
			if (function_exists('p2p_type') && p2p_type($column_id)) {
				$rel_args = apply_filters('emd_ext_p2p_add_query_vars', array(
					'posts_per_page' => - 1
				) , Array(
					$other_ptype
				));
				$connected = p2p_type($column_id)->get_connected($post_id, $rel_args);
				$ptype_obj = get_post_type_object($this->post_type);
				$edit_cap = $ptype_obj->cap->edit_posts;
				$ret = array();
				if (empty($connected->posts)) return '&ndash;';
				foreach ($connected->posts as $myrelpost) {
					$rel_title = get_the_title($myrelpost->ID);
					$rel_title = apply_filters('emd_ext_p2p_connect_title', $rel_title, $myrelpost, '');
					$url = get_permalink($myrelpost->ID);
					$url = apply_filters('emd_ext_connected_ptype_url', $url, $myrelpost, $edit_cap);
					$ret[] = sprintf('<a href="%s" title="%s" target="_blank">%s</a>', $url, $rel_title, $rel_title);
				}
				echo wp_kses_post(implode(', ', $ret));
				return;
			}
		}
		$value = get_post_meta($post_id, $column_id, true);
		$type = "";
		foreach ($this->boxes as $mybox) {
			foreach ($mybox['fields'] as $fkey => $mybox_field) {
				if ($fkey == $column_id) {
					$type = $mybox_field['type'];
					break;
				}
			}
		}
		if ($column_id == 'featured_img') {
			$type = 'featured_img';
		}
		switch ($type) {
			case 'featured_img':
				$thumb_url = wp_get_attachment_image_src(get_post_thumbnail_id($post_id) , 'thumbnail');
				if (!empty($thumb_url)) {
					$value = "<img style='max-width:100%;height:auto;' src='" . $thumb_url[0] . "' >";
				}
			break;
			case 'plupload_image':
			case 'image':
			case 'thickbox_image':
				$image_list = emd_mb_meta($column_id, 'type=image');
				$value = "";
				if (!empty($image_list)) {
					$myimage = current($image_list);
					$value = "<img style='max-width:100%;height:auto;' src='" . $myimage['url'] . "' >";
				}
			break;
			case 'user':
			case 'user-adv':
				$user_id = emd_mb_meta($column_id);
				if (!empty($user_id)) {
					$user_info = get_userdata($user_id);
					$value = $user_info->display_name;
				}
			break;
			case 'file':
				$file_list = emd_mb_meta($column_id, 'type=file');
				if (!empty($file_list)) {
					$value = "";
					foreach ($file_list as $myfile) {
						$fsrc = wp_mime_type_icon($myfile['ID']);
						$value.= "<a style='margin:5px;' href='" . $myfile['url'] . "' target='_blank'><img src='" . $fsrc . "' title='" . $myfile['name'] . "' width='20' /></a>";
					}
				}
			break;
			case 'radio':
			case 'checkbox_list':
			case 'select':
			case 'select_advanced':
				$value = emd_get_attr_val(str_replace("-", "_", $this->textdomain) , $post_id, $this->post_type, $column_id);
			break;
			case 'checkbox':
				if ($value == 1) {
					$value = '<span class="dashicons dashicons-yes"></span>';
				} elseif ($value == 0) {
					$value = '<span class="dashicons dashicons-no-alt"></span>';
				}
			break;
			case 'rating':
				$value = apply_filters('emd_get_rating_value', $value, Array(
					'meta' => $column_id
				) , $post_id);
			break;
		}
		if (is_array($value)) {
			$value = "<div class='clonelink'>" . implode("</div><div class='clonelink'>", $value) . "</div>";
		}
		echo wp_kses_post($value);
	}
	/**
	 * Register post type and taxonomies and set initial values for taxs
	 *
	 * @since WPAS 4.0
	 *
	 */
	public static function register() {
		$labels = array(
			'name' => __('Panels', 'knowledge-center') ,
			'singular_name' => __('Panel', 'knowledge-center') ,
			'add_new' => __('Add New', 'knowledge-center') ,
			'add_new_item' => __('Add New Panel', 'knowledge-center') ,
			'edit_item' => __('Edit Panel', 'knowledge-center') ,
			'new_item' => __('New Panel', 'knowledge-center') ,
			'all_items' => __('KC Panels', 'knowledge-center') ,
			'view_item' => __('View Panel', 'knowledge-center') ,
			'search_items' => __('Search Panels', 'knowledge-center') ,
			'not_found' => __('No Panels Found', 'knowledge-center') ,
			'not_found_in_trash' => __('No Panels Found In Trash', 'knowledge-center') ,
			'menu_name' => __('Panels', 'knowledge-center') ,
		);
		$ent_map_list = get_option('knowledge_center_ent_map_list', Array());
		$myrole = emd_get_curr_usr_role('knowledge_center');
		if (!empty($ent_map_list['emd_panel']['rewrite'])) {
			$rewrite = $ent_map_list['emd_panel']['rewrite'];
		} else {
			$rewrite = 'panels';
		}
		$supports = Array(
			'comments'
		);
		if (empty($ent_map_list['emd_panel']['attrs']['blt_title']) || $ent_map_list['emd_panel']['attrs']['blt_title'] != 'hide') {
			if (empty($ent_map_list['emd_panel']['edit_attrs'])) {
				$supports[] = 'title';
			} elseif ($myrole == 'administrator') {
				$supports[] = 'title';
			} elseif ($myrole != 'administrator' && !empty($ent_map_list['emd_panel']['edit_attrs'][$myrole]['blt_title']) && $ent_map_list['emd_panel']['edit_attrs'][$myrole]['blt_title'] == 'edit') {
				$supports[] = 'title';
			}
		}
		if (empty($ent_map_list['emd_panel']['attrs']['blt_content']) || $ent_map_list['emd_panel']['attrs']['blt_content'] != 'hide') {
			if (empty($ent_map_list['emd_panel']['edit_attrs'])) {
				$supports[] = 'editor';
			} elseif ($myrole == 'administrator') {
				$supports[] = 'editor';
			} elseif ($myrole != 'administrator' && !empty($ent_map_list['emd_panel']['edit_attrs'][$myrole]['blt_content']) && $ent_map_list['emd_panel']['edit_attrs'][$myrole]['blt_content'] == 'edit') {
				$supports[] = 'editor';
			}
		}
		register_post_type('emd_panel', array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'description' => __('Any short length content which may be used to display term definitions, frequently asked questions etc.', 'knowledge-center') ,
			'show_in_menu' => true,
			'menu_position' => 6,
			'has_archive' => false,
			'exclude_from_search' => false,
			'rewrite' => array(
				'slug' => $rewrite
			) ,
			'can_export' => true,
			'show_in_rest' => false,
			'hierarchical' => false,
			'menu_icon' => 'dashicons-list-view',
			'map_meta_cap' => 'false',
			'taxonomies' => array() ,
			'capability_type' => 'post',
			'supports' => $supports,
		));
		$tax_settings = get_option('knowledge_center_tax_settings', Array());
		$myrole = emd_get_curr_usr_role('knowledge_center');
		$kb_group_nohr_labels = array(
			'name' => __('KC Groups', 'knowledge-center') ,
			'singular_name' => __('KC Group', 'knowledge-center') ,
			'search_items' => __('Search KC Groups', 'knowledge-center') ,
			'popular_items' => __('Popular KC Groups', 'knowledge-center') ,
			'all_items' => __('All', 'knowledge-center') ,
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __('Edit KC Group', 'knowledge-center') ,
			'update_item' => __('Update KC Group', 'knowledge-center') ,
			'add_new_item' => __('Add New KC Group', 'knowledge-center') ,
			'new_item_name' => __('Add New KC Group Name', 'knowledge-center') ,
			'separate_items_with_commas' => __('Seperate KC Groups with commas', 'knowledge-center') ,
			'add_or_remove_items' => __('Add or Remove KC Groups', 'knowledge-center') ,
			'choose_from_most_used' => __('Choose from the most used KC Groups', 'knowledge-center') ,
			'menu_name' => __('KC Groups', 'knowledge-center') ,
		);
		if (empty($tax_settings['kb_group']['hide']) || (!empty($tax_settings['kb_group']['hide']) && $tax_settings['kb_group']['hide'] != 'hide')) {
			if (!empty($tax_settings['kb_group']['rewrite'])) {
				$rewrite = $tax_settings['kb_group']['rewrite'];
			} else {
				$rewrite = 'kb_group';
			}
			$targs = array(
				'hierarchical' => false,
				'labels' => $kb_group_nohr_labels,
				'public' => true,
				'show_ui' => true,
				'show_in_nav_menus' => true,
				'show_in_menu' => true,
				'show_tagcloud' => true,
				'update_count_callback' => '_update_post_term_count',
				'query_var' => true,
				'rewrite' => array(
					'slug' => $rewrite,
				) ,
				'show_in_rest' => false,
				'capabilities' => array(
					'manage_terms' => 'manage_kb_group',
					'edit_terms' => 'edit_kb_group',
					'delete_terms' => 'delete_kb_group',
					'assign_terms' => 'assign_kb_group'
				) ,
			);
			if ($myrole != 'administrator' && !empty($tax_settings['kb_group']['edit'][$myrole]) && $tax_settings['kb_group']['edit'][$myrole] != 'edit') {
				$targs['meta_box_cb'] = false;
			}
			register_taxonomy('kb_group', array(
				'emd_panel'
			) , $targs);
		}
		$kb_tags_nohr_labels = array(
			'name' => __('KC Tags', 'knowledge-center') ,
			'singular_name' => __('KC Tag', 'knowledge-center') ,
			'search_items' => __('Search KC Tags', 'knowledge-center') ,
			'popular_items' => __('Popular KC Tags', 'knowledge-center') ,
			'all_items' => __('All', 'knowledge-center') ,
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __('Edit KC Tag', 'knowledge-center') ,
			'update_item' => __('Update KC Tag', 'knowledge-center') ,
			'add_new_item' => __('Add New KC Tag', 'knowledge-center') ,
			'new_item_name' => __('Add New KC Tag Name', 'knowledge-center') ,
			'separate_items_with_commas' => __('Seperate KC Tags with commas', 'knowledge-center') ,
			'add_or_remove_items' => __('Add or Remove KC Tags', 'knowledge-center') ,
			'choose_from_most_used' => __('Choose from the most used KC Tags', 'knowledge-center') ,
			'menu_name' => __('KC Tags', 'knowledge-center') ,
		);
		if (empty($tax_settings['kb_tags']['hide']) || (!empty($tax_settings['kb_tags']['hide']) && $tax_settings['kb_tags']['hide'] != 'hide')) {
			if (!empty($tax_settings['kb_tags']['rewrite'])) {
				$rewrite = $tax_settings['kb_tags']['rewrite'];
			} else {
				$rewrite = 'kb_tags';
			}
			$targs = array(
				'hierarchical' => false,
				'labels' => $kb_tags_nohr_labels,
				'public' => true,
				'show_ui' => true,
				'show_in_nav_menus' => true,
				'show_in_menu' => true,
				'show_tagcloud' => true,
				'update_count_callback' => '_update_post_term_count',
				'query_var' => true,
				'rewrite' => array(
					'slug' => $rewrite,
				) ,
				'show_in_rest' => false,
				'capabilities' => array(
					'manage_terms' => 'manage_kb_tags',
					'edit_terms' => 'edit_kb_tags',
					'delete_terms' => 'delete_kb_tags',
					'assign_terms' => 'assign_kb_tags'
				) ,
			);
			if ($myrole != 'administrator' && !empty($tax_settings['kb_tags']['edit'][$myrole]) && $tax_settings['kb_tags']['edit'][$myrole] != 'edit') {
				$targs['meta_box_cb'] = false;
			}
			register_taxonomy('kb_tags', array(
				'emd_panel'
			) , $targs);
		}
	}
	/**
	 * Set metabox fields,labels,filters, comments, relationships if exists
	 *
	 * @since WPAS 4.0
	 *
	 */
	public function set_filters() {
		do_action('emd_ext_class_init', $this);
		$search_args = Array();
		$filter_args = Array();
		$this->sing_label = __('Panel', 'knowledge-center');
		$this->plural_label = __('Panels', 'knowledge-center');
		$this->menu_entity = 'emd_panel';
		$this->boxes['emd_panel_info_emd_panel_0'] = array(
			'id' => 'emd_panel_info_emd_panel_0',
			'title' => __('Panel Info', 'knowledge-center') ,
			'app_name' => 'knowledge_center',
			'pages' => array(
				'emd_panel'
			) ,
			'context' => 'normal',
		);
		list($search_args, $filter_args) = $this->set_args_boxes();
		if (!post_type_exists($this->post_type) || in_array($this->post_type, Array(
			'post',
			'page'
		))) {
			self::register();
		}
		do_action('emd_set_adv_filtering', $this->post_type, $search_args, $this->boxes, $filter_args, $this->textdomain, $this->plural_label);
		add_action('admin_notices', array(
			$this,
			'show_lite_filters'
		));
		$ent_map_list = get_option(str_replace('-', '_', $this->textdomain) . '_ent_map_list');
	}
	/**
	 * Initialize metaboxes
	 * @since WPAS 4.5
	 *
	 */
	public function set_metabox() {
		if (class_exists('EMD_Meta_Box') && is_array($this->boxes)) {
			foreach ($this->boxes as $meta_box) {
				new EMD_Meta_Box($meta_box);
			}
		}
	}
	/**
	 * Change content for created frontend views
	 * @since WPAS 4.0
	 * @param string $content
	 *
	 * @return string $content
	 */
	public function change_content($content) {
		global $post;
		$layout = "";
		$this->id = $post->ID;
		$tools = get_option('knowledge_center_tools');
		if (!empty($tools['disable_emd_templates'])) {
			add_filter('the_title', array(
				$this,
				'change_title_disable_emd_temp'
			) , 10, 2);
		}
		if (get_post_type() == $this->post_type && is_single()) {
			ob_start();
			do_action('emd_single_before_content', $this->textdomain, $this->post_type);
			emd_get_template_part($this->textdomain, 'single', 'emd-panel');
			do_action('emd_single_after_content', $this->textdomain, $this->post_type);
			$layout = ob_get_clean();
		}
		if ($layout != "") {
			$content = $layout;
		}
		if (!empty($tools['disable_emd_templates'])) {
			remove_filter('the_title', array(
				$this,
				'change_title_disable_emd_temp'
			) , 10, 2);
		}
		return $content;
	}
	/**
	 * Add operations and add new submenu hook
	 * @since WPAS 4.4
	 */
	public function add_menu_link() {
		add_submenu_page(null, __('CSV Import/Export', 'knowledge-center') , __('CSV Import/Export', 'knowledge-center') , 'manage_operations_emd_panels', 'operations_emd_panel', array(
			$this,
			'get_operations'
		));
	}
	/**
	 * Display operations page
	 * @since WPAS 4.0
	 */
	public function get_operations() {
		if (current_user_can('manage_operations_emd_panels')) {
			$myapp = str_replace("-", "_", $this->textdomain);
			if (!function_exists('emd_operations_entity')) {
				emd_lite_get_operations('opr', $this->plural_label, $this->textdomain);
			} else {
				do_action('emd_operations_entity', $this->post_type, $this->plural_label, $this->sing_label, $myapp, $this->menu_entity);
			}
		}
	}
	public function add_top_menu_link() {
		$myapp = str_replace('-', '_', $this->textdomain);
		do_action('emd_add_submenu_pages', $this->post_type, $myapp, $this->menu_entity);
	}
	public function show_lite_filters() {
		if (class_exists('EMD_AFC')) {
			return;
		}
		global $pagenow;
		if (get_post_type() == $this->post_type && $pagenow == 'edit.php') {
			emd_lite_get_filters($this->textdomain);
		}
	}
}
new Emd_Panel;