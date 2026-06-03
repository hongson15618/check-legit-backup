<?php get_header(); ?>

<style>
  .alert-tocao {
    background: #fff1f1;
    border: 3px solid #c82333;
    padding: 30px;
    border-radius: 12px;
    max-width: 860px;
    margin: 40px auto;
    font-family: "Segoe UI", sans-serif;
    box-shadow: 0 8px 20px rgba(0,0,0,0.07);
  }

  .alert-banner {
    background: #ff0000;
    color: #fff;
    font-weight: bold;
    padding: 16px;
    text-align: center;
    border-radius: 8px;
    margin-bottom: 35px;
    font-size: 22px;
    letter-spacing: 1px;
    text-transform: uppercase;
  }

  .title-with-views {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    gap: 14px;
    margin-bottom: 30px;
  }

  .title-with-views h1 {
    font-size: 26px;
    color: #b30000;
    font-weight: 800;
    text-transform: uppercase;
    margin: 0;
    text-align: center;
  }

  .view-badge {
    background: #ffe5e5;
    color: #b30000;
    padding: 6px 14px;
    border-radius: 20px;
    font-weight: bold;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .tocao-info {
    border: 2px solid #dc3545;
    background: #fff;
    padding: 18px 22px;
    border-radius: 10px;
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 10px;
  }

  .tocao-info label {
    color: #b30000;
    font-size: 17px;
    min-width: 180px;
  }

  .tocao-info .value {
    font-size: 18px;
    font-weight: bold;
    color: #111;
    word-break: break-word;
    flex: 1;
    text-align: right;
  }

  .evidence-gallery {
    margin-top: 30px;
    text-align: center;
  }

  .evidence-gallery img {
    max-width: 100%;
    height: auto;
    margin: 10px 0;
    border: 2px solid #c82333;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    max-height: 500px;
  }

  .tocao-buttons {
    margin-top: 40px;
    text-align: center;
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    justify-content: center;
  }

  .tocao-buttons a {
    background: #2e7d32;
    color: #fff;
    padding: 12px 20px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
    text-decoration: none;
    transition: background 0.3s;
  }

  .tocao-buttons a:nth-child(2) {
    background: #c82333;
  }

  .tocao-buttons a:hover {
    filter: brightness(1.1);
  }

  @media (max-width: 600px) {
    .tocao-info {
      flex-direction: column;
      align-items: flex-start;
    }

    .tocao-info .value {
      text-align: left;
    }

    .tocao-buttons {
      flex-direction: column;
    }

    .tocao-buttons a {
      width: 100%;
    }

    .title-with-views {
      flex-direction: column;
    }
  }


</style>

<div class="alert-tocao">
  <div class="alert-banner">⚠️ CẢNH BÁO LỪA ĐẢO – TRA CỨU GẤP ⚠️</div>

<div class="title-with-views" style="position: relative; margin-bottom: 30px;">
  <!-- Tiêu đề ở giữa -->
  <h1 style="
    font-size: 26px;
    color: #b30000;
    font-weight: 800;
    text-transform: uppercase;
    margin: 0;
    text-align: center;
  ">
    <?php the_title(); ?>
  </h1>

  <!-- Nút cảnh cáo + lượt xem bên phải -->
  <div style="
    position: absolute;
    top: 0;
    right: 0;
    display: flex;
    align-items: center;
    gap: 12px;
  ">



    <?php
      $post_id = get_the_ID();
      $init = (int) get_post_meta($post_id, 'initial_views', true);
      $start = (int) get_post_meta($post_id, 'created_time', true);
      $now = time();
      $hours = floor(($now - $start) / 3600);
      $views = $init + $hours * 2;
      echo '<div class="view-badge">👁 ' . $views . ' lượt xem</div>';
    ?>
  </div>
</div>


<?php
  $mo_ta = get_post_meta(get_the_ID(), 'mo_ta_lua_dao', true);
  if ($mo_ta) {
    echo '<p style="margin-top:-20px; margin-bottom:20px; font-style:italic; color:#c82333; text-align:center;">*' . nl2br(esc_html($mo_ta)) . '*</p>';
  }
?>

  <?php
  $id = get_the_ID();
  $fields = array(
    'target_name' => 'Tên tài khoản LỪA ĐẢO',
    'bank_number' => 'TÀI KHOẢN LỪA ĐẢO',
    'bank_name' => 'Ngân hàng',
    'phone' => 'Số điện thoại LỪA ĐẢO',
    'contact' => 'Facebook/Zalo/Hồ sơ LỪA ĐẢO'
  );

  foreach ($fields as $key => $label) {
    $value = get_post_meta($id, $key, true);
    if ($value) {
      echo '<div class="tocao-info">
              <label>' . esc_html($label) . ':</label>
              <div class="value">' . esc_html($value) . '</div>
            </div>';
    }
  }
    // ✅ Hiển thị link bài viết tố cáo nếu có
  $link = get_post_meta($id, 'link_bai_viet', true);
  if ($link) {
    echo '<div class="tocao-info">
            <label>🔗 Link bài viết tố cáo:</label>
            <div class="value"><a href="' . esc_url($link) . '" target="_blank" rel="noopener noreferrer">' . esc_html($link) . '</a></div>
          </div>';
  }

  // ✅ Hiển thị nội dung lý do tố cáo (post_content)
  $content = get_the_content();
  if ($content) {
    echo '<div class="tocao-info">';
    echo '<label>Lý do tố cáo:</label>';
    echo '<div class="value" style="white-space:pre-line; text-align:left;">' . wp_kses_post($content) . '</div>';
    echo '</div>';
  }

  // ✅ Hiển thị ảnh bằng chứng
  $evidence = get_post_meta($id, 'evidence_urls', true);
  if (!empty($evidence) && is_array($evidence)) {
    echo '<div class="evidence-gallery">';
    echo '<h3 style="color:#c82333; text-align:center;">📷 Ảnh bằng chứng</h3>';
   foreach ($evidence as $url) {
  echo '<img src="' . esc_url($url) . '" class="popup-image" style="cursor:pointer;" alt="Ảnh bằng chứng">';
}
    echo '</div>';
  }
  ?>

  <div class="tocao-buttons">
    <a href="<?php echo home_url(); ?>">🔍 Tra cứu số tài khoản khác</a>
    <a href="<?php echo home_url('/bao-cao-lua-dao'); ?>">🚨 Gửi tố cáo mới</a>
  </div>
</div>
<!-- Popup overlay -->
<div id="popupOverlay" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.8); z-index:9999; justify-content:center; align-items:center;">
  <img id="popupImage" src="" style="max-width:90vw; max-height:90vh; border:6px solid white; border-radius:10px; box-shadow:0 0 20px black;">
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const images = document.querySelectorAll('.popup-image');
    const popup = document.getElementById('popupOverlay');
    const popupImg = document.getElementById('popupImage');

    images.forEach(img => {
      img.addEventListener('click', () => {
        popupImg.src = img.src;
        popup.style.display = 'flex';
      });
    });

    popup.addEventListener('click', () => {
      popup.style.display = 'none';
      popupImg.src = '';
    });

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        popup.style.display = 'none';
        popupImg.src = '';
      }
    });
  });
</script>



<?php get_footer(); ?>
