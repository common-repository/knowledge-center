<?php $real_post = $post;
$ent_attrs = get_option('knowledge_center_attr_list');
?>
<div id="single-emd-panel-<?php echo get_the_ID(); ?>" class="emd-container emd-panel-wrap single-wrap">
<?php $is_editable = 0; ?>
<h1 class="entry-title"><?php echo get_the_title(); ?></h1>
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
<section id="panel-content">
<?php echo $post->post_content; ?>
</section>

</div><!--container-end-->