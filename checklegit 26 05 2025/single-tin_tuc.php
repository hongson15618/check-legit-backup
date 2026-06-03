<?php get_header(); ?>
<div style="max-width:800px; margin:60px auto; padding:0 20px;">
  <h1 style="color:#c82333;"><?php the_title(); ?></h1>
  <div style="color:#666; font-size:14px; margin-bottom:10px;">🕓 Đăng ngày: <?php echo get_the_date(); ?></div>
  <?php if (has_post_thumbnail()) : ?>
    <div style="margin-bottom:20px;"><?php the_post_thumbnail('large'); ?></div>
  <?php endif; ?>
  <div style="line-height:1.8; font-size:16px;">
    <?php the_content(); ?>
  </div>
</div>
<?php get_footer(); ?>
