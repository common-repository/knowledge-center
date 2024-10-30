<?php global $std_panel_count, $std_panel_filter, $std_panel_set_list;
$real_post = $post;
$ent_attrs = get_option('knowledge_center_attr_list');
?>
<div class="panel panel-<?php echo emd_get_attr_val('knowledge_center', $post->ID, 'emd_panel', 'emd_panel_color', 'key'); ?>">
            <div class="panel-heading" role="tab" id="heading<?php echo esc_html(emd_mb_meta('emd_panel_id')); ?>
" data-toggle="collapse" data-parent="#faq-grp" data-target="#collapse<?php echo esc_html(emd_mb_meta('emd_panel_id')); ?>
" aria-expanded="false" aria-controls="collapse<?php echo esc_html(emd_mb_meta('emd_panel_id')); ?>
">
                <h4 class="panel-title">
<span><?php echo get_the_title(); ?></span>
             </h4>
            </div>
            <div id="collapse<?php echo esc_html(emd_mb_meta('emd_panel_id')); ?>
" class="panel-collapse collapse  <?php echo emd_get_attr_val('knowledge_center', $post->ID, 'emd_panel', 'emd_panel_initial_state', 'key'); ?>" role="tabpanel">
                <div class="panel-body">
<section class="row rating-wrap">
        <div class="col-sm-6">
           <div class="panel-rating">
               <?php if (shortcode_exists('emd_ratings')) {
	echo do_shortcode("[emd_ratings app='knowledge-center' rname='panel_rating']");
} ?>

           </div>
        </div>
        <div class="col-sm-6">
           <div class="panel-rating-stats text-right textSmall">
               <?php if (shortcode_exists('emd_ratings')) {
	echo do_shortcode("[emd_ratings_stats app='knowledge-center' rname='panel_rating']");
} ?>

           </div>
        </div>
 </section>
                    <?php echo $post->post_content; ?>
                </div>
            </div>
 </div>