<?php $real_post = $post;
$ent_attrs = get_option('knowledge_center_attr_list');
?>
<li><a class="faq-item" href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a></li>