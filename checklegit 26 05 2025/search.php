<?php
get_header();

$keyword = get_search_query();
$args = array(
  'post_type' => 'to_cao',
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'meta_query' => array(
    'relation' => 'OR',
    array('key' => 'bank_number', 'value' => $keyword, 'compare' => 'LIKE'),
    array('key' => 'target_name', 'value' => $keyword, 'compare' => 'LIKE'),
    array('key' => 'phone', 'value' => $keyword, 'compare' => 'LIKE'),
    array('key' => 'contact', 'value' => $keyword, 'compare' => 'LIKE'),
  )
);

$query = new WP_Query($args);
?>

<style>
  .search-wrapper {
    max-width: 900px;
    margin: 40px auto;
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0,0,0,0.06);
  }

  .search-wrapper h2 {
    color: #dc3545;
    margin-bottom: 25px;
    font-size: 22px;
  }

  .result-item {
    border-left: 5px solid #dc3545;
    padding: 15px;
    background: #fff1f1;
    margin-bottom: 15px;
    border-radius: 6px;
  }

  .result-item h3 {
    margin: 0 0 8px;
    font-size: 18px;
  }

  .result-item a {
    text-decoration: none;
    color: #c82333;
    font-weight: bold;
  }

  .result-item small {
    color: #555;
  }

  /* Giao diện dropdown autocomplete khi tìm kiếm */
  ul.ui-autocomplete {
    background: #fff;
    border: 1px solid #ccc;
    border-radius: 6px;
    padding: 0;
    margin-top: 5px;
    list-style: none;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    max-width: 100%;
    overflow: hidden;
    z-index: 9999;
  }

  ul.ui-autocomplete li {
    padding: 10px 15px;
    border-bottom: 1px solid #eee;
    cursor: pointer;
    font-size: 14px;
  }

  ul.ui-autocomplete li:hover {
    background: #f8f9fa;
  }

  ul.ui-autocomplete li:last-child {
    border-bottom: none;
  }
</style>

<div class="search-wrapper">
  <h2>🔍 Kết quả tìm kiếm: "<?php echo esc_html($keyword); ?>"</h2>

  <?php if ($query->have_posts()) : ?>
    <?php while ($query->have_posts()) : $query->the_post(); ?>
      <div class="result-item">
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <small>
          Số tài khoản: <?php echo esc_html(get_post_meta(get_the_ID(), 'bank_number', true)); ?> –
          Ngân hàng: <?php echo esc_html(get_post_meta(get_the_ID(), 'bank_name', true)); ?>
        </small>
      </div>
    <?php endwhile; ?>
  <?php else : ?>
    <p>🚫 Không tìm thấy hồ sơ tố cáo nào phù hợp với từ khóa trên.</p>
  <?php endif; wp_reset_postdata(); ?>
</div>

<?php get_footer(); ?>
