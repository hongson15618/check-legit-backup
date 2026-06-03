<?php
/*
Template Name: Đăng nhập
*/
get_header();
?>

<style>
  body {
    margin: 0;
    padding: 0;
    background: linear-gradient(270deg, #e8f5e9, #c8e6c9, #a5d6a7, #81c784, #66bb6a, #4caf50);
    background-size: 1200% 1200%;
    animation: gradientMove 20s ease infinite;
  }

  @keyframes gradientMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
  }

  .login-wrapper {
    max-width: 420px;
    margin: 80px auto;
    padding: 35px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    border: 1px solid #c3e6cb;
  }

  .login-wrapper h2 {
    text-align: center;
    color: #2e7d32;
    margin-bottom: 25px;
  }

  .login-wrapper label {
    display: block;
    margin: 10px 0 5px;
    font-weight: bold;
    color: #333;
  }

  .login-wrapper input[type="text"],
  .login-wrapper input[type="password"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #bbb;
    border-radius: 6px;
    font-size: 16px;
    background: #f9f9f9;
  }

  .login-wrapper input[type="submit"] {
    margin-top: 20px;
    width: 100%;
    background: #2e7d32;
    color: white;
    padding: 12px;
    font-size: 16px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.3s ease;
  }

  .login-wrapper input[type="submit"]:hover {
    background: #256c29;
  }

  .login-links {
    margin-top: 15px;
    text-align: center;
  }

  .login-links a {
    color: #2e7d32;
    text-decoration: none;
    font-weight: 500;
  }
</style>

<div class="login-wrapper">
  <h2>🔐 Đăng nhập</h2>

  <?php wp_login_form(array(
    'label_username' => 'Tài khoản hoặc Email',
    'label_password' => 'Mật khẩu',
    'label_remember' => 'Ghi nhớ',
    'label_log_in'   => 'Đăng nhập',
    'redirect'       => home_url('/quan-ly-ho-so'),
  )); ?>

  <div class="login-links">
    <p>Chưa có tài khoản? <a href="/tao-ho-so-legit">Đăng ký ngay</a></p>
    <p><a href="#" id="lostpass-link">Quên mật khẩu?</a></p>
  </div>
</div>

<style>
  #popup-lostpass {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0.8);
    background: #fff;
    border-radius: 10px;
    padding: 30px;
    width: 300px;
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
    z-index: 9999;
    opacity: 0;
    transition: all 0.3s ease;
  }

  #popup-lostpass.show {
    display: block;
    opacity: 1;
    transform: translate(-50%, -50%) scale(1);
  }

  #popup-lostpass p {
    margin-bottom: 15px;
    text-align: center;
  }

  #popup-lostpass button {
    padding: 8px 16px;
    background: #2e7d32;
    border: none;
    color: white;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
  }

  #popup-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.4);
    z-index: 9998;
  }

  #popup-overlay.show {
    display: block;
  }
</style>

<div id="popup-overlay"></div>

<div id="popup-lostpass">
  <p style="font-weight:bold; color:#2e7d32;">📞 Liên hệ Admin để lấy lại mật khẩu:</p>
  <p style="font-size:18px; color:#c62828;">0789 991 555</p>
  <p><button id="popup-close">Đóng</button></p>
</div>

<script>
  const lostPassLink = document.getElementById('lostpass-link');
  const popup = document.getElementById('popup-lostpass');
  const overlay = document.getElementById('popup-overlay');
  const closeBtn = document.getElementById('popup-close');

  lostPassLink.addEventListener('click', function (e) {
    e.preventDefault();
    popup.classList.add('show');
    overlay.classList.add('show');
  });

  closeBtn.addEventListener('click', function () {
    popup.classList.remove('show');
    overlay.classList.remove('show');
  });

  overlay.addEventListener('click', function () {
    popup.classList.remove('show');
    overlay.classList.remove('show');
  });
</script>

<?php get_footer(); ?>