<?php
/*
Template Name: Danh sách Hồ Sơ Legit
*/
get_header();

// Lọc theo gói xác minh
$filter = isset($_GET['rank']) ? $_GET['rank'] : '';

$args = array(
  'post_type' => 'ho_so_legit',
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'meta_query' => array(),
  'orderby' => 'meta_value_num',
  'meta_key' => 'xacminh',
  'order' => 'DESC'
);

if ($filter) {
  $args['meta_query'][] = array(
    'key' => 'xacminh',
    'value' => $filter,
    'compare' => '='
  );
}

$query = new WP_Query($args);
?>

<style>
  .filter-bar {
    max-width: 1000px;
    margin: 30px auto 10px;
    text-align: center;
  }
  .filter-bar a {
    margin: 5px;
    display: inline-block;
    padding: 8px 16px;
    border-radius: 20px;
    text-decoration: none;
    border: 1px solid #2e7d32;
    color: #2e7d32;
    font-weight: 500;
  }
  .filter-bar a.active,
  .filter-bar a:hover {
    background: #2e7d32;
    color: white;
  }
  .seller-grid {
    max-width: 1000px;
    margin: 30px auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
  }
  .seller-card {
    background: white;
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 3px 6px rgba(0,0,0,0.05);
  }
  .seller-card img {
    border-radius: 50%;
    width: 90px;
    height: 90px;
    object-fit: cover;
    margin-bottom: 10px;
  }
  .seller-card h3 {
    font-size: 16px;
    margin: 5px 0 10px;
    color: #333;
  }
  .rank-label {
    display: inline-block;
    padding: 4px 10px;
    font-size: 13px;
    border-radius: 6px;
    color: white;
  }
</style>

<h2 style="text-align:center; margin-top:30px; color:#2e7d32;">🧑‍💼 Danh sách Hồ Sơ Legit</h2>

<div class="filter-bar">
  <a href="<?php echo get_permalink(); ?>" class="<?php echo $filter == '' ? 'active' : ''; ?>">Tất cả</a>
  <a href="?rank=500000" class="<?php echo $filter == '500000' ? 'active' : ''; ?>">Cơ Bản</a>
  <a href="?rank=1000000" class="<?php echo $filter == '1000000' ? 'active' : ''; ?>">Đồng 🥉</a>
  <a href="?rank=2000000" class="<?php echo $filter == '2000000' ? 'active' : ''; ?>">Bạc 🥈</a>
  <a href="?rank=5000000" class="<?php echo $filter == '5000000' ? 'active' : ''; ?>">Vàng 🥇</a>
  <a href="?rank=10000000" class="<?php echo $filter == '10000000' ? 'active' : ''; ?>">Kim Cương 💎</a>
</div>

<div class="seller-grid">
<?php if ($query->have_posts()) :
  while ($query->have_posts()) : $query->the_post();
    $avatar = get_the_post_thumbnail_url(get_the_ID(), 'medium');
    if (!$avatar) $avatar = 'https://via.placeholder.com/100';
    $xacminh = get_post_meta(get_the_ID(), 'xacminh', true);
    $rank_label = 'Chưa xác minh'; $rank_color = '#888';
    if ($xacminh == '500000') { $rank_label = 'Cơ Bản'; $rank_color = '#8d6e63'; }
    elseif ($xacminh == '1000000') { $rank_label = 'Hạng Đồng 🥉'; $rank_color = '#a8712d'; }
    elseif ($xacminh == '2000000') { $rank_label = 'Hạng Bạc 🥈'; $rank_color = '#9e9e9e'; }
    elseif ($xacminh == '5000000') { $rank_label = 'Hạng Vàng 🥇'; $rank_color = '#fbc02d'; }
    elseif ($xacminh == '10000000') { $rank_label = 'Kim Cương 💎'; $rank_color = '#00bcd4'; }
?>
  <div class="seller-card">
    <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($avatar); ?>" alt="avatar"></a>
    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    <span class="rank-label" style="background: <?php echo $rank_color; ?>"><?php echo $rank_label; ?></span>
  </div>
<?php endwhile; else: ?>
  <p style="text-align:center;">Không tìm thấy hồ sơ nào.</p>
<?php endif; wp_reset_postdata(); ?>
</div>

<?php get_footer(); ?>
