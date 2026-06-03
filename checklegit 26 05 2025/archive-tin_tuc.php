<?php get_header(); ?>

<div style="max-width:1000px; margin:60px auto; padding:0 20px;">
  <h1 style="text-align:center; color:#2e7d32;">📰 Tin tức & Cảnh báo mới nhất</h1>
  <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px, 1fr)); gap:30px; margin-top:40px;">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <div style="background:white; border:1px solid #ddd; border-radius:10px; padding:20px;">
        <a href="<?php the_permalink(); ?>" style="text-decoration:none; color:#333;">
          <?php if (has_post_thumbnail()) : ?>
            <div style="margin-bottom:15px;">
              <?php the_post_thumbnail('medium', ['style' => 'width:100%; border-radius:10px;']); ?>
            </div>
          <?php endif; ?>
          <h2><?php the_title(); ?></h2>
          <p><?php echo get_the_excerpt(); ?></p>
        </a>
      </div>
    <?php endwhile; endif; ?>
  </div>
</div>

<?php get_footer(); ?>
