<?php get_header(); ?>
<meta name="google-site-verification" content="9EQQ0bxZmsJfhRDZUgryuKbOKIN8avTyoAAtk0e_4wo" />
<style>
/* RESET CSS */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

html, body {
  margin: 0;
  padding: 0;
}

.container-wide {
  padding: 60px 5%;
  width: 100%;
  box-sizing: border-box;
}

  .hero {
    background: #eaffea;
    padding: 60px 20px;
    text-align: center;
  }
  .hero h1 {
    font-size: 36px;
    color: #2e7d32;
  }
  .hero p {
    font-size: 18px;
    color: #333;
  }
  .search-box {
    margin-top: 30px;
  }
  .search-box input {
    width: 100%;
    padding: 14px 18px;
    font-size: 16px;
    border: 2px solid #2e7d32;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    outline: none;
  }
  .section {
    padding: 40px 20px;
    max-width: 1000px;
    margin: auto;
  }
  .section h2 {
    color: #2e7d32;
  }
  .card {
    background: white;
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 10px;
    margin: 10px 0;
  }
  .cta {
    background: #2e7d32;
    color: white;
    text-align: center;
    padding: 40px 20px;
  }
  .cta a {
    background: white;
    color: #2e7d32;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
  }

  .featured-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
    gap: 20px;
    justify-items: center;
    padding: 20px 0;
  }
  .featured-item {
    text-align: center;
    font-size: 14px;
  }
  .featured-item img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 50%;
    border: 2px solid #ccc;
    transition: transform 0.2s;
  }
  .featured-item img:hover {
    transform: scale(1.1);
  }
  .featured-item a {
    text-decoration: none;
    color: #333;
    display: block;
    margin-top: 6px;
  }
</style>

<style>
  #suggestions {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #ccc;
    border-top: none;
    z-index: 9999;
    list-style: none;
    margin: 0;
    padding: 0;
    max-height: 200px;
    overflow-y: auto;
    border-radius: 0 0 8px 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  }

  #suggestions li {
    padding: 10px 14px;
    border-bottom: 1px solid #eee;
  }

  #suggestions li:last-child {
    border-bottom: none;
  }

  #suggestions a.scam-suggestion {
    text-decoration: none;
    color: #c82333;
    display: block;
    font-weight: 500;
  }

  #suggestions a.scam-suggestion:hover {
    background: #f8f9fa;
  }

  .fade-in {
    animation: fadeIn 0.15s ease-in-out;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .tocao-wrapper {
  max-width: 1000px;
  margin: 50px auto;
  padding: 20px;
}

.tocao-title {
  color: #c82333;
  font-size: 22px;
  font-weight: bold;
  text-align: center;
  margin-bottom: 30px;
}

.tocao-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 20px;
}

.tocao-card {
  background: #fff5f5;
  border: 1px dashed #dc3545;
  border-radius: 10px;
  padding: 16px;
  box-shadow: 0 4px 12px rgba(220, 53, 69, 0.05);
  transition: transform 0.2s ease;
}

.tocao-card:hover {
  transform: translateY(-3px);
}

.tocao-card a {
  font-weight: bold;
  color: #b30000;
  text-decoration: none;
}

.tocao-card a:hover {
  text-decoration: underline;
}

.tocao-card small {
  display: block;
  font-size: 14px;
  color: #444;
  margin-top: 6px;
}
/* Hiệu ứng khởi tạo mờ và trượt từ dưới lên */
div[style*="background:#f3fff3"] {
  opacity: 0;
  animation: fadeInUp 0.6s ease-out forwards;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* Hover nổi nhẹ + đổ bóng */
div[style*="background:#f3fff3"]:hover {
  transform: translateY(-5px) scale(1.02);
  box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
}

/* Keyframe animation */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

</style>

<div class="hero">
  <h1>Check Legit – Tra cứu & Chứng minh Uy tín</h1>
  <p>Nơi cộng đồng đánh giá người bán và dịch vụ online một cách minh bạch, đáng tin cậy</p>
  <p style="font-size: 13px; color: #888; margin-top: 8px; font-style: italic;">
  * CheckLegit.online chỉ cung cấp thông tin cảnh báo và đánh giá cộng đồng. 
  Chúng tôi <strong>không chịu trách nhiệm</strong> cho bất kỳ giao dịch cá nhân nào giữa các bên liên quan.
</p>

  <div class="search-box">
    <form method="get" action="<?php echo home_url(); ?>" style="position: relative; max-width: 500px; margin: 0 auto;">
      <input type="text" name="s" id="searchInput"
             placeholder="🔍 Nhập tên, SĐT, Zalo hoặc số tài khoản..."
             autocomplete="off">
      <ul id="suggestions"></ul>
    </form>
  </div>
</div>

<section class="container-wide">
  <div style="text-align:center; margin-top:30px;">
    <a href="/danh-sach-legit" style="margin: 10px; display:inline-block; background:#2e7d32; color:white; padding:12px 20px; border-radius:6px; text-decoration:none;">📋 Xem danh sách LEGIT</a>
    <a href="/tao-ho-so-legit" style="margin: 10px; display:inline-block; background:#2e7d32; color:white; padding:12px 20px; border-radius:6px; text-decoration:none;">🧑‍💼 Tạo Hồ Sơ Legit</a>
    <a href="/bao-cao-lua-dao" style="margin: 10px; display:inline-block; background:#dc3545; color:white; padding:12px 20px; border-radius:6px; text-decoration:none;">📣 Báo cáo lừa đảo</a>
  </div>

 <h2 style="text-align:center; margin-bottom: 30px;">💡 Vì sao nên chọn Check Legit?</h2>
<div style="display:flex; justify-content:center; flex-wrap:wrap; gap:30px; margin-top:20px;">
  <div class="why-box" style="flex:1; min-width:250px; max-width:300px; background:#f3fff3; padding:25px; border-radius:16px; box-shadow:0 8px 20px rgba(0,0,0,0.05); text-align:center;">
    <img src="https://cdn-icons-png.flaticon.com/512/709/709699.png" width="50" alt="minh bạch"><br><br>
    <strong style="font-size:16px;">Minh bạch & cộng đồng xác thực</strong>
  </div>
  <div class="why-box" style="flex:1; min-width:250px; max-width:300px; background:#f3fff3; padding:25px; border-radius:16px; box-shadow:0 8px 20px rgba(0,0,0,0.05); text-align:center;">
    <img src="https://cdn-icons-png.flaticon.com/512/2620/2620855.png" width="50" alt="quỹ phòng lừa đảo"><br><br>
    <strong style="font-size:16px;">Hỗ trợ quỹ dự phòng phòng chống lừa đảo</strong>
  </div>
  <div class="why-box" style="flex:1; min-width:250px; max-width:300px; background:#f3fff3; padding:25px; border-radius:16px; box-shadow:0 8px 20px rgba(0,0,0,0.05); text-align:center;">
    <img src="https://cdn-icons-png.flaticon.com/512/3589/3589971.png" width="50" alt="ảnh thật xác minh"><br><br>
    <strong style="font-size:16px;">Hồ sơ Legit có xác minh</strong>
  </div>
</div>


</section>

<section class="section">
  <h3 style="color: #c82333; font-size: 22px; margin-bottom: 20px; font-weight: bold; text-align: center;">
    💼 DANH SÁCH LỪA ĐẢO MỚI NHẤT
  </h3>

  <div class="tocao-grid">
    <?php
    $args = array(
      'post_type' => 'to_cao',
      'post_status' => 'publish',
      'posts_per_page' => 6,
      'orderby' => 'date',
      'order' => 'DESC'
    );
    $recent_reports = new WP_Query($args);
    if ($recent_reports->have_posts()) :
      while ($recent_reports->have_posts()) : $recent_reports->the_post();
        $bank = get_post_meta(get_the_ID(), 'bank_number', true);
        $bank_name = get_post_meta(get_the_ID(), 'bank_name', true);
    ?>
        <div class="tocao-card">
          <a href="<?php the_permalink(); ?>" class="tocao-title"><?php the_title(); ?></a>
          <div class="tocao-meta">
            Số tài khoản: <strong><?php echo esc_html($bank); ?></strong><br>
            Ngân hàng: <strong><?php echo esc_html($bank_name); ?></strong>
          </div>
        </div>
    <?php
      endwhile;
      wp_reset_postdata();
    else :
      echo '<p>Chưa có tố cáo nào được công khai.</p>';
    endif;
    ?>
  </div>
</section>
<section class="section">
  <h2 style="text-align:center;">Hồ sơ Legit nổi bật ✅</h2>

  <style>
  .avatar-wrapper {
  position: relative;
  display: inline-block;
}

.badge {
  position: absolute;
  top: -10px;
  right: -10px;
  font-size: 16px;
  line-height: 1;
  background: none;
  border: none;
  box-shadow: none;
  color: #fbc02d;
  z-index: 2;
}

.badge.co-ban,
.badge.dong,
.badge.bac,
.badge.vang,
.badge.kim-cuong {
  background: none !important;
  color: #fbc02d;
}


    .featured-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
      gap: 30px;
      justify-content: center;
      margin-top: 30px;
    }

    .featured-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
    }

    .featured-item img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 50%;
      border: 2px solid #2e7d32;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
      transition: transform 0.3s ease;
    }

    .featured-item img:hover {
      transform: scale(1.08);
    }

    .featured-item a {
      text-decoration: none;
      color: inherit;
    }

    .featured-item a:hover span {
      color: #1b5e20;
      font-weight: bold;
    }
    .featured-item span {
  margin-top: 10px;
  font-size: 14px;
  font-weight: 600;
  color: #2e7d32;
  background: #e8f5e9;
  border-radius: 20px;
  padding: 6px 16px;
  box-shadow: 0 2px 8px rgba(46, 125, 50, 0.1);
  text-align: center;
  display: inline-block;
  width: fit-content;
  margin-left: auto;
  margin-right: auto;
}

  </style>

  <div class="featured-grid">
    <?php
    $args = array(
      'post_type' => 'ho_so_legit',
      'post_status' => 'publish',
      'posts_per_page' => 24,
      'meta_key' => 'xacminh',
      'orderby' => 'meta_value_num',
      'order' => 'DESC'
    );
    $query = new WP_Query($args);
    if ($query->have_posts()) :
      while ($query->have_posts()) : $query->the_post();
        $avatar = get_the_post_thumbnail_url(get_the_ID(), 'medium');
        if (!$avatar) $avatar = 'https://via.placeholder.com/80?text=?';
    ?>
    <div class="featured-item">
  <div class="avatar-wrapper">
    <a href="<?php the_permalink(); ?>">
      <img src="<?php echo esc_url($avatar); ?>" alt="avatar">
     <?php
$xacminh = get_post_meta(get_the_ID(), 'xacminh', true);

$badge_map = [
  '500000'    => ['co-ban', '👍'],
  '1000000'   => ['dong', '🥉'],
  '2000000'   => ['bac', '🥈'],
  '5000000'   => ['vang', '🥇'],
  '10000000'  => ['kim-cuong', '💎']
];

if (isset($badge_map[$xacminh])) {
  list($class, $icon) = $badge_map[$xacminh];
  echo '<span class="badge ' . esc_attr($class) . '">' . esc_html($icon) . '</span>';
}
?>
    </a>
  </div>
  <span><?php the_title(); ?></span>
</div>


    <?php endwhile; endif; wp_reset_postdata(); ?>
  </div>
</section>


<style>
.cta-legit {
  background: linear-gradient(135deg, #4caf50, #2e7d32);
  border-radius: 20px;
  padding: 60px 40px;
  text-align: center;
  color: #ffffff;
  margin: 70px auto 50px;
  max-width: 960px;
  animation: fadeInUp 0.8s ease;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.cta-legit h3 {
  font-size: 26px;
  margin-bottom: 30px;
  font-weight: 600;
  color: #fff;
}

.cta-legit a {
  display: inline-block;
  background: #ffffff;
  color: #2e7d32;
  font-weight: 600;
  font-size: 16px;
  padding: 14px 30px;
  border-radius: 8px;
  text-decoration: none;
  transition: all 0.3s ease;
  box-shadow: 0 8px 18px rgba(0, 0, 0, 0.2);
}

.cta-legit a:hover {
  background: #e8f5e9;
  transform: translateY(-3px);
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
.news-card {
  background: #fff;
  border-radius: 12px;
  padding: 16px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.05);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  display: flex;
  flex-direction: column;
  height: 100%;
}
.news-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 24px rgba(0,0,0,0.08);
}
.news-card p {
  font-size: 14px;
  color: #555;
  margin-top: 8px;
  line-height: 1.4em;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  min-height: 2.8em;
}

</style>

<div class="cta-legit">
  <h3>🎯 Hãy tạo hồ sơ để tăng độ tin cậy với khách hàng và cộng đồng</h3>
  <a href="/tao-ho-so-legit">🚀 Tạo Hồ Sơ Legit Ngay</a>
</div>



<script>
document.addEventListener('DOMContentLoaded', function () {
  const input = document.getElementById('searchInput');
  const suggestions = document.getElementById('suggestions');

  input.addEventListener('input', function () {
    const val = this.value.trim();
    if (val.length < 2) {
      suggestions.style.display = 'none';
      return;
    }

    fetch('<?php echo admin_url("admin-ajax.php"); ?>?action=cl_suggest_search&term=' + encodeURIComponent(val))
      .then(res => res.json())
      .then(data => {
        if (data.length > 0) {
          suggestions.innerHTML = data.map(item =>
            `<li><a href="${item.link}" class="scam-suggestion">${item.label} ⚠️</a></li>`
          ).join('');
          suggestions.classList.remove('fade-in');
          void suggestions.offsetWidth;
          suggestions.classList.add('fade-in');
          suggestions.style.display = 'block';
        } else {
          suggestions.style.display = 'none';
        }
      });
  });

  document.addEventListener('click', function (e) {
    if (!suggestions.contains(e.target) && e.target !== input) {
      suggestions.style.display = 'none';
    }
  });
});
</script>
<section class="section">
  <h2 style="text-align:center; color:#2e7d32;">📰 Tin tức cảnh báo mới</h2>
  <div style="max-width:960px; margin:30px auto; display:grid; grid-template-columns:repeat(auto-fit,minmax(260px,1fr)); gap:20px;">
    <?php
    $news = new WP_Query([
      'post_type' => 'tin_tuc',
      'posts_per_page' => 3,
      'orderby' => 'date',
      'order' => 'DESC',
    ]);
    if ($news->have_posts()) :
      while ($news->have_posts()) : $news->the_post();
    ?>
    <div class="news-card">

      <a href="<?php the_permalink(); ?>" style="text-decoration:none; color:#222;">
        <?php if (has_post_thumbnail()) : ?>
          <?php the_post_thumbnail('medium', ['style' => 'width:100%; border-radius:10px; margin-bottom:10px;']); ?>
        <?php endif; ?>
        <strong><?php the_title(); ?></strong>
        <p style="font-size:14px; color:#666;"><?php echo get_the_excerpt(); ?></p>
      </a>
    </div>
    <?php endwhile; endif; wp_reset_postdata(); ?>
  </div>
</section>

<?php get_footer(); ?>
