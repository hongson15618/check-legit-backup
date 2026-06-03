<?php
/*
Template Name: Báo cáo lừa đảo
*/
get_header();

define('CL_FORM_HANDLING', true); // ✅ Ngăn hook save_post ghi đè dữ liệu khi tạo bài từ form này

// ✅ Xử lý lưu báo cáo vào custom post type 'to_cao'
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['target_name'])) {
  $title = 'Tố cáo: ' . sanitize_text_field($_POST['target_name']);
  $content = sanitize_textarea_field($_POST['reason']);

  $post_id = wp_insert_post(array(
    'post_type' => 'to_cao',
    'post_title' => $title,
    'post_content' => $content,
    'post_status' => 'pending',
  ));

  if ($post_id) {
    update_post_meta($post_id, 'target_name_friendly', sanitize_text_field($_POST['target_name_friendly']));
    update_post_meta($post_id, 'target_name', sanitize_text_field($_POST['target_name']));
    update_post_meta($post_id, 'bank_number', sanitize_text_field($_POST['bank_number']));
    update_post_meta($post_id, 'bank_name', sanitize_text_field($_POST['bank_name']));
    update_post_meta($post_id, 'contact', sanitize_text_field($_POST['contact']));
    update_post_meta($post_id, 'phone', sanitize_text_field($_POST['phone']));
    update_post_meta($post_id, 'mo_ta_lua_dao', sanitize_text_field($_POST['mo_ta_lua_dao']));
    update_post_meta($post_id, 'reporter_name', sanitize_text_field($_POST['reporter_name']));
    update_post_meta($post_id, 'reporter_zalo', sanitize_text_field($_POST['reporter_zalo']));
if (!empty($_POST['link_bai_viet'])) {
  update_post_meta($post_id, 'link_bai_viet', esc_url_raw($_POST['link_bai_viet']));
}

    $uploaded_urls = [];

if (!empty($_FILES['evidence']['name'][0])) {
  require_once(ABSPATH . 'wp-admin/includes/file.php');
  require_once(ABSPATH . 'wp-admin/includes/image.php');
  require_once(ABSPATH . 'wp-admin/includes/media.php');

  foreach ($_FILES['evidence']['tmp_name'] as $i => $tmp_name) {
    $file = [
      'name'     => $_FILES['evidence']['name'][$i],
      'type'     => $_FILES['evidence']['type'][$i],
      'tmp_name' => $_FILES['evidence']['tmp_name'][$i],
      'error'    => $_FILES['evidence']['error'][$i],
      'size'     => $_FILES['evidence']['size'][$i]
    ];

    // Nén + Resize
    $upload = wp_handle_upload($file, ['test_form' => false]);
    if (!isset($upload['url'])) continue;

    $file_path = $upload['file'];
    $image = wp_get_image_editor($file_path);
    if (!is_wp_error($image)) {
      $image->resize(500, 500, false); // Chiều rộng tối đa 500px
      $image->set_quality(50);         // Nén chất lượng 50%
      $image->save($file_path);
    }

    $uploaded_urls[] = $upload['url'];
  }

  if (!empty($uploaded_urls)) {
    update_post_meta($post_id, 'evidence_urls', $uploaded_urls);
  }
}


    echo '<div style="background:#d4edda; padding:15px; margin:20px auto; border-radius:6px; border-left:5px solid #28a745; max-width:800px;">
    ✅ Báo cáo của bạn đã được gửi và lưu vào hệ thống. Chúng tôi sẽ xem xét trong thời gian sớm nhất.
    </div>';
  } else {
    echo '<div style="background:#f8d7da; padding:15px; margin:20px auto; border-radius:6px; border-left:5px solid #dc3545; max-width:800px;">
    ❌ Có lỗi xảy ra khi gửi báo cáo. Vui lòng thử lại.
    </div>';
  }
}
?>

<style>
body {
  background: linear-gradient(270deg, #fff5f5, #ffecec);
  background-size: 800% 800%;
  animation: bgmove 20s ease infinite;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  margin: 0;
  padding: 0;
}
@keyframes bgmove {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}
nav.main-nav {
  background: #2e7d32;
  padding: 15px 20px;
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 20px;
}
nav.main-nav a {
  color: white;
  text-decoration: none;
  font-weight: bold;
  font-size: 16px;
}
nav.main-nav a:hover {
  text-decoration: underline;
}
.report-wrapper {
  max-width: 800px;
  margin: 50px auto;
  background: #fff;
  border: 2px solid #f5c2c7;
  padding: 30px;
  border-radius: 14px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.05);
}
.report-wrapper h1 {
  color: #dc3545;
  text-align: center;
  margin-bottom: 25px;
}
.report-wrapper h3 {
  margin-top: 30px;
  margin-bottom: 20px;
  border-bottom: 1px solid #ddd;
  padding-bottom: 5px;
}
.section-red h3 {
  color: #dc3545;
  border-color: #f5c2c7;
}
.section-blue h3 {
  color: #007bff;
  border-color: #90caf9;
}
.report-wrapper p {
  text-align: center;
  color: #6c757d;
  font-size: 15px;
  margin-bottom: 20px;
}
.form-row {
  display: flex;
  gap: 24px;
  flex-wrap: wrap;
  margin-bottom: 20px;
}
.form-col {
  flex: 1;
  min-width: 220px;
}
.report-wrapper label {
  font-weight: bold;
  display: block;
  margin-bottom: 5px;
  color: #333;
}
.report-wrapper input,
.report-wrapper textarea {
  width: 100%;
  padding: 10px;
  font-size: 15px;
  border: 1px solid #ccc;
  border-radius: 6px;
  margin-bottom: 10px;
}
.report-wrapper input::placeholder,
.report-wrapper textarea::placeholder {
  color: #999;
}
.report-wrapper button {
  margin-top: 25px;
  background: #dc3545;
  color: white;
  padding: 12px 24px;
  font-size: 16px;
  border: none;
  border-radius: 6px;
  width: 100%;
  cursor: pointer;
}
.report-wrapper button:hover {
  background: #c82333;
}
</style>

<div class="report-wrapper">
  <h1>📣 Báo cáo lừa đảo</h1>
  <p>Hãy điền chính xác thông tin để chúng tôi xác minh và cảnh báo cộng đồng.</p>
  <form method="post" enctype="multipart/form-data">
    <div class="section-red">
      <h3>🧾 THÔNG TIN KẺ LỪA ĐẢO</h3>
      <!-- 🔽 THÊM TRƯỜNG TÊN ĐỐI TƯỢNG -->
<label>Tên đối tượng</label>
<input type="text" name="target_name_friendly" placeholder="Tên đối tượng dùng để liên hệ (nickname, tên giả...)">

      <div class="form-row">
        <div class="form-col">
          <label>Tên chủ tài khoản </label>
          <input type="text" name="target_name"  placeholder="Chủ tài khoản nhận tiền">
        </div>
        <div class="form-col">
          <label>Số tài khoản </label>
          <input type="text" name="bank_number"  placeholder="Số tài khoản nhận tiền">
        </div>
      </div>
      <div class="form-row">
        <div class="form-col">
          <label>Ngân hàng </label>
          <input type="text" name="bank_name"  placeholder="Ngân hàng">
        </div>
        <div class="form-col">
          <label>Link Facebook / Zalo / Hồ sơ (nếu có)</label>
          <input type="text" name="contact" placeholder="Link Facebook/Zalo/hồ sơ kẻ lừa đảo">
        </div>
      </div>
      <label>Số điện thoại</label>
      <input type="text" name="phone" placeholder="Số điện thoại của kẻ lừa đảo (nếu có)">
      <label>Ghi chú ngắn (hiển thị công khai dưới tiêu đề)</label>
<input type="text" name="mo_ta_lua_dao" placeholder="VD: Lừa cọc tiền mua máy ảnh">
<p>
  <label for="link_bai_viet">🔗 Link bài viết tố cáo (nếu có):</label><br>
  <input type="url" name="link_bai_viet" id="link_bai_viet" style="width:100%; padding:10px; border-radius:6px;" placeholder="https://facebook.com/..." />
</p>

      <label>Lý do bạn muốn báo cáo *</label>
      <textarea name="reason" rows="4" required placeholder="Nội dung chi tiết vụ việc, bạn đã bị lừa như thế nào..."></textarea>
      <label>Ảnh bằng chứng (nếu có):</label>
      <input type="file" name="evidence[]" multiple accept="image/*">
    </div>
    <div class="section-blue">
      <h3>🙋 NGƯỜI XÁC THỰC</h3>
      <label>Họ và tên *</label>
      <input type="text" name="reporter_name" required placeholder="Nhập họ, tên của bạn">
      <label>Liên hệ Zalo *</label>
      <input type="text" name="reporter_zalo" required placeholder="Nhập số Zalo bạn đang sử dụng (mở tìm kiếm)">
    </div>
    <button type="submit">🚨 Gửi báo cáo</button>
  </form>
</div>
<!-- Overlay loading -->
<div id="loadingOverlay" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.5); z-index:9999; display:flex; align-items:center; justify-content:center;">
  <div style="background:white; padding:30px 40px; border-radius:12px; text-align:center; box-shadow:0 8px 30px rgba(0,0,0,0.2); width:300px;">
    <div style="font-size:18px; font-weight:bold; margin-bottom:12px;">🚨 Đang gửi báo cáo</div>
    <div style="margin-bottom:10px;">Vui lòng chờ vài giây...</div>
    <div style="width:100%; background:#f1f1f1; border-radius:8px; overflow:hidden; height:14px;">
      <div id="fakeProgressBar" style="width:0%; height:100%; background:#dc3545; transition:width 0.3s;"></div>
    </div>
  </div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector('.report-wrapper form');
    const overlay = document.getElementById('loadingOverlay');
    const progressBar = document.getElementById('fakeProgressBar');

    // Hiện overlay khi bấm GỬI
    if (form && overlay && progressBar) {
      form.addEventListener('submit', function () {
        overlay.style.display = 'flex';
        let percent = 0;
        const interval = setInterval(() => {
          percent += Math.random() * 10;
          if (percent > 95) {
            percent = 95;
            clearInterval(interval); // dừng ở 95%
          }
          progressBar.style.width = percent + '%';
        }, 300);
      });
    }

    // Tự tắt overlay khi trang reload lại (POST xử lý xong và HTML trả về)
    window.addEventListener('load', function () {
      if (overlay) {
        overlay.style.display = 'none';
        progressBar.style.width = '0%';
      }
    });
  });
</script>


<?php get_footer(); ?>
