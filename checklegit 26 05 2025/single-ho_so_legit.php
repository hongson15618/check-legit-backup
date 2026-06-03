<?php get_header(); ?>

<style>
  .cl-legit-box {
    max-width: 800px;
    margin: 50px auto 10px;
    padding: 40px 30px 20px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
    font-family: 'Segoe UI', sans-serif;
    position: relative;
  }

  .cl-legit-header {
    text-align: center;
    margin-bottom: 30px;
  }

  .cl-avatar {
    border-radius: 50%;
    width: 100px;
    height: 100px;
    object-fit: cover;
    margin-bottom: 10px;
    box-shadow: 0 0 0 4px #2e7d32 inset;
  }

  .cl-meta p {
    margin: 10px 0;
    font-size: 16px;
    line-height: 1.7;
  }

  .cl-meta a {
    color: #007bff;
    text-decoration: none;
  }

  .cl-meta a:hover {
    text-decoration: underline;
  }

  .cl-badge {
    background: #6c757d;
    color: white;
    padding: 6px 12px;
    border-radius: 5px;
    font-weight: bold;
  }

  .cl-evidence img {
    width: 150px;
    border-radius: 6px;
    transition: transform 0.3s ease;
  }

  .cl-evidence img:hover {
    transform: scale(1.05);
  }

  .cl-inside-share {
    text-align: right;
    margin-top: 30px;
  }

  .cl-button-copy {
    background: #28a745;
    color: white;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 500;
    font-size: 14px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .cl-button-copy:hover {
    background: #218838;
  }

  .cl-copy-msg {
    font-size: 14px;
    color: #28a745;
    font-weight: bold;
    margin-top: 6px;
    display: none;
    text-align: right;
  }

  .cl-button-bar-outer {
    max-width: 800px;
    margin: 20px auto 50px;
    padding: 0 30px;
    display: flex;
    justify-content: flex-start;
    gap: 10px;
    flex-wrap: wrap;
  }

  .cl-button-bar-outer a {
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 500;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.3s ease;
  }

  .cl-button-list {
    background: #f8f9fa;
    color: #333;
    border: 1px solid #ccc;
  }

  .cl-button-list:hover {
    background: #e2e6ea;
  }

  .cl-button-report {
    background: #dc3545;
    color: white;
  }

  .cl-button-report:hover {
    background: #b52b37;
  }
  .cl-service-badges {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  margin-top: 6px;
}

.cl-service-badge {
  background: #e8f5e9;               /* nền xanh nhạt */
  color: #2e7d32;                    /* chữ xanh đậm */
  padding: 6px 12px;
  border-radius: 20px;
  font-size: 14px;
  border: 1px solid #c8e6c9;
  font-weight: 500;
  white-space: nowrap;
}

</style>

<div class="cl-legit-box">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <div class="cl-legit-header">
      <h2>📄 Hồ Sơ Legit</h2>
      <?php if (has_post_thumbnail()) : ?>
        <div><img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>" class="cl-avatar" /></div>
      <?php endif; ?>
      <h3 style="color:#2e7d32;"><?php the_title(); ?></h3>
    </div>

    <div class="cl-meta">
    <?php
$meta = [
  'zalo' => ['Zalo', '📱'],
  'phone' => ['Số điện thoại', '📞'],
  'bank' => ['Số tài khoản', '💳'],
  'facebook' => ['Facebook', '🔗'],
  'facebook_phu' => ['Facebook phụ', '📘']
];

foreach ($meta as $key => $arr) {
  $label = $arr[0];
  $icon = $arr[1];
  $value = get_post_meta(get_the_ID(), $key, true);
  if ($value) {
    echo "<p><strong>$icon $label:</strong> ";
    if (strpos($key, 'facebook') !== false) {
      echo "<a href='" . esc_url($value) . "' target='_blank'>" . esc_html($value) . "</a>";
    } elseif ($key === 'bank') {
     echo '<div style="white-space: pre-line;">' . esc_html($value) . '</div>';

    } else {
      echo esc_html($value);
    }
    echo "</p>";
  }
}

// ✅ DỊCH VỤ dạng badge
$services = get_post_meta(get_the_ID(), 'service', true);
if (!empty($services)) {
  $tags = array_map('trim', explode(',', $services));
echo '<p><strong>📦 Dịch vụ:</strong></p>';
echo '<div class="cl-service-badges">';
foreach ($tags as $tag) {
  echo '<span class="cl-service-badge">' . esc_html($tag) . '</span>';
}
echo '</div>';

}

// ✅ TIỀN BẢO HIỂM
$tien_bao_hiem = get_post_meta(get_the_ID(), 'tien_bao_hiem', true);
if ($tien_bao_hiem) {
  echo '<p><strong>💰 Tiền bảo hiểm:</strong> ' . number_format($tien_bao_hiem, 0, ',', '.') . 'đ</p>';
  echo '<p style="font-size:13px; color:#777; margin-top:-10px;">*đây là số tiền đảm bảo cho giao dịch</p>';
}
?>

    </div>

    <?php
      $attachments = get_attached_media('image', get_the_ID());
      if (!empty($attachments)) {
        echo '<div style="margin-top:30px;"><h4>📌 Ảnh minh chứng:</h4><div class="cl-evidence" style="display:flex; gap:10px; flex-wrap:wrap; margin-top:10px;">';
        foreach ($attachments as $img) {
          echo '<img src="' . esc_url(wp_get_attachment_url($img->ID)) . '">';
        }
        echo '</div></div>';
      }

      $xacminh = get_post_meta(get_the_ID(), 'xacminh', true);
      $badge = 'Chưa xác minh'; $color = '#6c757d';
      if ($xacminh == '500000') { $badge = 'Cơ bản'; $color = '#8d6e63'; }
      elseif ($xacminh == '1000000') { $badge = 'Hạng Đồng 🥉'; $color = '#a8712d'; }
      elseif ($xacminh == '2000000') { $badge = 'Hạng Bạc 🥈'; $color = '#c0c0c0'; }
      elseif ($xacminh == '5000000') { $badge = 'Hạng Vàng 🥇'; $color = '#ffd700'; }
      elseif ($xacminh == '10000000') { $badge = 'Hạng Kim Cương 💎'; $color = '#00bcd4'; }

      echo '<div style="margin-top:30px;"><strong>🔰 Gói xác minh:</strong> <span class="cl-badge" style="background:' . $color . ';">' . $badge . '</span></div>';
    ?>

    <div class="cl-inside-share">
      <button class="cl-button-copy" onclick="copyToClipboard('<?php echo get_permalink(); ?>')">📤 Chia sẻ</button>
      <div id="cl-copy-msg" class="cl-copy-msg">✅ Đã copy link!</div>
    </div>

  <?php endwhile; endif; ?>
</div>

<!-- 🔻 Nút nằm ngoài khung -->
<div class="cl-button-bar-outer">
  <a href="/danh-sach-legit" class="cl-button-list">🗂️ Hồ Sơ Legit Khác</a>
  <a href="/bao-cao-lua-dao" class="cl-button-report">📣 Báo cáo lừa đảo</a>
</div>

<style>
  .cl-button-bar-outer {
    max-width: 800px;
    margin: 20px auto 50px;
    padding: 0 30px;
    display: flex;
    justify-content: flex-start;
    gap: 10px;
    flex-wrap: wrap;
  }

  .cl-button-bar-outer a {
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 500;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.3s ease;
  }

  .cl-button-list {
    background: #f8fff8;
    color: #28a745;
    border: 1px solid #28a745;
  }

  .cl-button-list:hover {
    background: #e8fce8;
    color: #1e7e34;
    border-color: #1e7e34;
  }

  .cl-button-report {
    background: #dc3545;
    color: white;
  }

  .cl-button-report:hover {
    background: #b52b37;
  }
</style>


<script>
  function copyToClipboard(link) {
    navigator.clipboard.writeText(link).then(function () {
      document.getElementById("cl-copy-msg").style.display = "block";
      setTimeout(function () {
        document.getElementById("cl-copy-msg").style.display = "none";
      }, 3000);
    });
  }
</script>

<?php get_footer(); ?>
