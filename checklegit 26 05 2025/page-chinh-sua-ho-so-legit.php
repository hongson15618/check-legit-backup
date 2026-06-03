<?php
/* Template Name: Chỉnh Sửa Hồ Sơ Legit */
get_header();

if (!is_user_logged_in()) {
    wp_redirect(site_url('/dang-nhap'));
    exit;
}

$current_user_id = get_current_user_id();
$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
$post = get_post($post_id);

if (
    !$post || 
    $post->post_type !== 'ho_so_legit' || 
    intval($post->post_author) !== $current_user_id
) {
    echo '<div style="color:red; text-align:center; padding:20px;">❌ Không tìm thấy hồ sơ hoặc bạn không có quyền chỉnh sửa.</div>';
    get_footer();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['chinh_sua_ho_so'])) {
    $full_name     = sanitize_text_field($_POST['full_name']);
    $phone         = sanitize_text_field($_POST['phone']);
    $zalo          = sanitize_text_field($_POST['zalo']);
    $bank = sanitize_textarea_field($_POST['bank']);
    $service       = sanitize_text_field($_POST['service']);
    $xacminh       = sanitize_text_field($_POST['xacminh'] ?? '');
    $facebook      = esc_url_raw($_POST['facebook']);
    $facebook_phu  = esc_url_raw($_POST['facebook_phu']);

    wp_update_post([
        'ID'         => $post_id,
        'post_title' => $full_name,
    ]);

    update_post_meta($post_id, 'phone', $phone);
    update_post_meta($post_id, 'zalo', $zalo);
    update_post_meta($post_id, 'bank', $bank);
    update_post_meta($post_id, 'service', $service);
    update_post_meta($post_id, 'xacminh', $xacminh);
    update_post_meta($post_id, 'facebook', $facebook);
    update_post_meta($post_id, 'facebook_phu', $facebook_phu);

    if (!empty($_FILES['avatar']['name'])) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');

        $uploaded = media_handle_upload('avatar', $post_id);
        if (!is_wp_error($uploaded)) {
            set_post_thumbnail($post_id, $uploaded);
        } else {
            echo '<div style="color:red;">❌ Upload ảnh đại diện thất bại: ' . esc_html($uploaded->get_error_message()) . '</div>';
        }
    }

    echo '<div style="background:#d4edda; padding:15px; margin:20px auto; border-left:5px solid #28a745; max-width:600px; border-radius:6px;">✅ Hồ sơ đã được cập nhật thành công.</div>';
}

$full_name     = get_the_title($post_id);
$phone         = get_post_meta($post_id, 'phone', true);
$zalo          = get_post_meta($post_id, 'zalo', true);
$bank          = get_post_meta($post_id, 'bank', true);
$service       = get_post_meta($post_id, 'service', true);
$xacminh       = get_post_meta($post_id, 'xacminh', true);
$facebook      = get_post_meta($post_id, 'facebook', true);
$facebook_phu  = get_post_meta($post_id, 'facebook_phu', true);
$avatar_url    = get_the_post_thumbnail_url($post_id, 'medium');
?>

<style>
  .edit-legit-wrapper {
    max-width: 640px;
    margin: 40px auto;
    padding: 35px;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    font-family: 'Segoe UI', sans-serif;
    font-size: 15px;
    color: #333;
  }
  .edit-legit-wrapper h2 {
    text-align: center;
    color: #2e7d32;
    margin-bottom: 30px;
  }
  .edit-legit-wrapper label {
    font-weight: bold;
    display: block;
    margin-bottom: 6px;
    color: #444;
  }
  .edit-legit-wrapper input,
  .edit-legit-wrapper select {
    width: 100%;
    padding: 10px;
    font-size: 15px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 6px;
    background: #fafafa;
  }
  .edit-legit-wrapper img {
    border-radius: 8px;
    margin-bottom: 15px;
    max-width: 120px;
  }
  .edit-legit-wrapper button {
    background: #2e7d32;
    color: white;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    margin-top: 10px;
  }
  .edit-legit-wrapper button:hover {
    background: #25682b;
  }
</style>

<div class="edit-legit-wrapper">
  <h2>✏️ Chỉnh Sửa Hồ Sơ Legit</h2>
  <form method="post" enctype="multipart/form-data">

    <label>Họ và tên</label>
    <input type="text" name="full_name" value="<?php echo esc_attr($full_name); ?>" required>

    <label>Số điện thoại</label>
    <input type="text" name="phone" value="<?php echo esc_attr($phone); ?>">

    <label>Zalo</label>
    <input type="text" name="zalo" value="<?php echo esc_attr($zalo); ?>">

    <label>Số tài khoản <small>(mỗi dòng 1 STK)</small></label>
<textarea name="bank" rows="3" style="width:100%; padding:10px; border-radius:6px;"><?php echo esc_textarea($bank); ?></textarea>


 <label>📦 Lĩnh vực (phân cách bằng dấu phẩy)</label>
<input type="text" name="service" value="<?php echo esc_attr($service); ?>" placeholder="Ví dụ: Máy Ảnh, Homestay, MMO">
<small style="color:#777;">*Nhập các lĩnh vực bạn đang kinh doanh. Mỗi mục cách nhau bằng dấu phẩy.</small>

    <label>Facebook</label>
    <input type="text" name="facebook" value="<?php echo esc_attr($facebook); ?>" placeholder="https://facebook.com/tenban">

    <label>Facebook phụ (nếu có)</label>
    <input type="text" name="facebook_phu" value="<?php echo esc_attr($facebook_phu); ?>" placeholder="https://facebook.com/phu">

    <label>Chọn Gói Quỹ Bảo Hiểm – Xác Minh</label>
    <select name="xacminh">
      <option value="">-- Chọn gói --</option>
      <option value="500000" <?php selected($xacminh, '500000'); ?>>Cơ bản – 500k</option>
      <option value="1000000" <?php selected($xacminh, '1000000'); ?>>Đồng – 1 triệu 🥉</option>
      <option value="2000000" <?php selected($xacminh, '2000000'); ?>>Bạc – 2 triệu 🥈</option>
      <option value="5000000" <?php selected($xacminh, '5000000'); ?>>Vàng – 5 triệu 🥇</option>
      <option value="10000000" <?php selected($xacminh, '10000000'); ?>>Kim Cương – 10 triệu 💎</option>
    </select>

    <?php if ($avatar_url): ?>
      <label>Ảnh hiện tại:</label>
      <img src="<?php echo esc_url($avatar_url); ?>" alt="Avatar">
    <?php endif; ?>

    <label>Thay ảnh đại diện (nếu muốn)</label>
    <input type="file" name="avatar" accept="image/*">

    <div style="text-align:center;">
      <button type="submit" name="chinh_sua_ho_so">💾 Lưu thay đổi</button>
    </div>
  </form>
</div>

<?php get_footer(); ?>
