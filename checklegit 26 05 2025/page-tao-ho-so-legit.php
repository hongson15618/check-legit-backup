<?php 
/* Template Name: Tạo Hồ Sơ Legit */
get_header();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tao_ho_so'])) {
    $username   = sanitize_user($_POST['username']);
    $email      = sanitize_email($_POST['email']);
    $password   = $_POST['password'];
    $full_name  = sanitize_text_field($_POST['full_name']);
    $phone      = sanitize_text_field($_POST['phone']);
    $zalo       = sanitize_text_field($_POST['zalo']);
    $facebook       = esc_url_raw($_POST['facebook']);
    $facebook_phu   = esc_url_raw($_POST['facebook_phu']);
    $bank       = sanitize_textarea_field($_POST['bank']);
    $service    = sanitize_text_field($_POST['service']);
    $xacminh    = sanitize_text_field($_POST['xacminh']);
    $ghichu     = sanitize_textarea_field($_POST['ghichu']);

    if (username_exists($username) || email_exists($email)) {
        echo '<div style="color: red; margin: 10px 0;">❌ Tài khoản đã tồn tại. Vui lòng chọn tên khác hoặc dùng email khác.</div>';
    } elseif (empty($zalo)) {
        echo '<div style="color: red; margin: 10px 0;">❌ Vui lòng nhập Zalo.</div>';
    } else {
        $user_id = wp_create_user($username, $password, $email);

        if (is_wp_error($user_id)) {
            $error_msg = $user_id->get_error_message();
            echo '<div style="color: red; margin: 10px 0;">❌ Có lỗi xảy ra: ' . esc_html($error_msg) . '</div>';
        } else {
            wp_set_current_user($user_id);
            wp_set_auth_cookie($user_id);

            $post_id = wp_insert_post([
                'post_type'    => 'ho_so_legit',
                'post_title'   => $full_name,
                'post_status'  => 'pending',
                'post_author'  => $user_id,
                'post_content' => $ghichu,
            ]);

            if ($post_id) {
                update_post_meta($post_id, 'phone', $phone);
                update_post_meta($post_id, 'zalo', $zalo);
                update_post_meta($post_id, 'facebook', $facebook);
                update_post_meta($post_id, 'facebook_phu', $facebook_phu);
                update_post_meta($post_id, 'bank', $bank);
                update_post_meta($post_id, 'service', $service);
                update_post_meta($post_id, 'xacminh', $xacminh);

                if (!empty($_FILES['avatar']['name'])) {
                    require_once ABSPATH . 'wp-admin/includes/image.php';
                    require_once ABSPATH . 'wp-admin/includes/file.php';
                    require_once ABSPATH . 'wp-admin/includes/media.php';

                    $uploaded = media_handle_upload('avatar', 0);
                    if (!is_wp_error($uploaded)) {
                        set_post_thumbnail($post_id, $uploaded);
                    } else {
                        echo '<div style="color: red;">❌ Lỗi upload ảnh: ' . $uploaded->get_error_message() . '</div>';
                    }
                }
            }

            wp_redirect(site_url('/quan-ly-ho-so-legit'));
            exit;
        }
    }
}
?>

<style>
  .tao-ho-so-wrapper {
    max-width: 600px;
    margin: 40px auto;
    padding: 35px;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    font-family: 'Segoe UI', sans-serif;
    font-size: 15px;
    color: #333;
  }
  .tao-ho-so-wrapper h2 {
    text-align: center;
    color: #2e7d32;
    margin-bottom: 25px;
  }
  .tao-ho-so-wrapper label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
  }
  .tao-ho-so-wrapper input,
  .tao-ho-so-wrapper select,
  .tao-ho-so-wrapper textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 15px;
    margin-bottom: 15px;
  }
  .login-note {
    font-style: italic;
    color: #c62828;
    font-size: 13px;
    float: right;
    margin-top: -18px;
    margin-bottom: 10px;
  }
  .tao-ho-so-wrapper button {
    background: #2e7d32;
    color: white;
    padding: 12px 24px;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
  }
  .tao-ho-so-wrapper button:hover {
    background: #25682b;
  }
  .checkbox-confirm {
    display: flex;
    align-items: center;
    margin: 20px 0;
    font-size: 14px;
    font-style: italic;
    color: #333;
  }
  .checkbox-confirm input[type="checkbox"] {
    width: 18px;
    height: 18px;
    margin-right: 10px;
  }
  .checkbox-confirm a {
    color: #2e7d32;
    font-weight: 500;
    margin: 0 4px;
    text-decoration: underline;
  }
</style>

<div class="tao-ho-so-wrapper">
  <h2>🧑‍💼 Tạo Hồ Sơ Legit</h2>
  <form method="post" enctype="multipart/form-data">

    <label for="username">Tên người dùng (username)</label>
    <div class="login-note">Dùng để đăng nhập</div>
    <input type="text" name="username" id="username" required>

    <label for="password">Mật khẩu</label>
    <div class="login-note">Dùng để đăng nhập</div>
    <input type="password" name="password" id="password" required>

    <label for="email">Email</label>
    <input type="email" name="email" id="email">

    <label for="full_name">Họ và tên</label>
    <input type="text" name="full_name" id="full_name" required>

    <label for="phone">Số điện thoại</label>
    <input type="text" name="phone" id="phone" required>

    <label for="zalo">Zalo</label>
    <input type="text" name="zalo" id="zalo" required>

    <label for="facebook">Facebook</label>
    <input type="text" name="facebook" id="facebook" placeholder="https://facebook.com/tenban">

    <label for="facebook_phu">Facebook phụ (nếu có)</label>
    <input type="text" name="facebook_phu" id="facebook_phu" placeholder="https://facebook.com/phu">

    <label for="bank">Số tài khoản <small>(Có thể nhập nhiều STK, mỗi dòng 1 số)</small></label>
    <textarea name="bank" id="bank" rows="3"></textarea>

<label for="service">📦 Lĩnh vực hoạt động (cách nhau bằng dấu phẩy)</label>
<input type="text" name="service" id="service" placeholder="Ví dụ: Máy Ảnh, Dịch vụ FB, MMO, Tài khoản Game">
<small style="color: #777;">*Nhập các lĩnh vực bạn đang kinh doanh, hoạt động, cách nhau bằng dấu phẩy</small>


    <label for="ghichu">Ghi chú cho admin (giúp duyệt nhanh hơn)</label>
    <textarea name="ghichu" id="ghichu" rows="3"></textarea>

    <label for="avatar">Ảnh đại diện (tùy chọn)</label>
    <input type="file" name="avatar" accept="image/*">

    <label for="xacminh"><strong>Chọn Gói Quỹ Bảo Hiểm – Xác Minh</strong></label>
    <select name="xacminh" id="xacminh">
      <option value="">-- Chọn gói --</option>
      <option value="500000">Cơ bản – 500.000đ – Hồ Sơ Legit Cơ Bản</option>
      <option value="1000000">Đồng – 1.000.000đ – Hồ Sơ Legit Đồng 🥉</option>
      <option value="2000000">Bạc – 2.000.000đ – Hồ Sơ Legit Bạc 🥈</option>
      <option value="5000000">Vàng – 5.000.000đ – Hồ Sơ Legit Vàng 🥇</option>
      <option value="10000000">Kim Cương – 10.000.000đ – Hồ Sơ Legit Kim Cương 💎</option>
    </select>

    <div id="bank-info" style="display:none; background:#fff9c4; padding:15px; border-radius:6px; margin-top:10px;">
      <strong>Thông tin thanh toán:</strong><br>
      💳 VPBank – <strong>176821507</strong><br>
      👤 Chủ tài khoản: <strong>Đào Nguyễn Hồng Sơn</strong><br>
      💬 Nội dung chuyển khoản: <strong id="noidungchuyenkhoan">username_checklegit</strong><br>
      💰 Số tiền: <strong id="sotienchuyenkhoan">--</strong><br><br>
      <img src="http://checklegit.online/wp-content/uploads/2025/05/z6563100698825_07564e6c13142cad88f755858217f939-e1746204165785.jpg"
           alt="QR chuyển khoản"
           style="width:180px; border:1px solid #ccc; border-radius:8px;">
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('xacminh');
        const bankInfo = document.getElementById('bank-info');
        const usernameInput = document.getElementById('username');
        const noidung = document.getElementById('noidungchuyenkhoan');
        const sotien = document.getElementById('sotienchuyenkhoan');

        const tienMap = {
          '500000': '500.000đ',
          '1000000': '1.000.000đ',
          '2000000': '2.000.000đ',
          '5000000': '5.000.000đ',
          '10000000': '10.000.000đ'
        };

        function updateTransferNote() {
          const username = usernameInput.value.trim();
          noidung.textContent = username ? username + ' checklegit' : 'username_checklegit';
        }

        function updateAmount() {
          const value = select.value;
          sotien.textContent = tienMap[value] || '--';
        }

        select.addEventListener('change', function () {
          bankInfo.style.display = select.value ? 'block' : 'none';
          updateTransferNote();
          updateAmount();
        });

        usernameInput.addEventListener('input', updateTransferNote);
      });
    </script>

    <div class="checkbox-confirm">
      <input type="checkbox" name="dong_y" required>
      <span>Tôi đã đọc và hoàn toàn đồng ý với 
        <a href="/chinh-sach" target="_blank">chính sách</a> và 
        <a href="/quy-dinh" target="_blank">quy định</a> của Checklegit.online khi tạo tài khoản (Hồ sơ Legit)
      </span>
    </div>

    <p style="text-align:center; margin-top:30px;">
      <button type="submit" name="tao_ho_so">Tạo tài khoản</button>
    </p>
  </form>
</div>

<?php get_footer(); ?>