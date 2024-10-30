<?php
/**
 * Content Functions
 *
 * @package     EMD
 * @copyright   Copyright (c) 2014,  Emarket Design
 * @since       5.3
 */
if (!defined('ABSPATH')) exit;

function knowledge_center_content(){
        global $post;
        ob_start();
        if(is_single()){
                $file = emd_get_single_template('knowledge_center',$post->post_type);
                if($file == 'emd-no-access.php'){
                        emd_get_template_part('knowledge-center', 'no-access');
                }
                else {
			while ( have_posts() ) : the_post();
                        	emd_get_template_part('knowledge-center', 'single', str_replace("_","-",$post->post_type));
			endwhile;
                }
        }elseif (is_tax()) {
                $file = emd_get_taxonomy_template('knowledge_center');
                if($file == 'emd-no-access.php'){
                        emd_get_template_part('knowledge-center', 'no-access');
                }
                else {
                        $queried_object = get_queried_object();
			if ( have_posts() ) : 
				while ( have_posts() ) : the_post();
                        		emd_get_template_part('knowledge-center', 'taxonomy', str_replace("_","-",$queried_object->taxonomy . '-' . $post->post_type));
				endwhile;
			endif;
                }
        } elseif (is_post_type_archive()){
                $file = emd_get_archive_template('knowledge_center');
                if($file == 'emd-no-access.php'){
                        emd_get_template_part('knowledge-center', 'no-access');
                }
                else {
			if ( have_posts() ) : 
				while ( have_posts() ) : the_post();
                        		emd_get_template_part('knowledge-center', 'archive', str_replace("_","-",$post->post_type));
				endwhile;
			endif;
                }
        }
        $layout = ob_get_clean();
        echo wp_kses_post($layout);
}
