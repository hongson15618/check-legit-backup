<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description"
    content="Check Legit – Nền tảng tra cứu, xác minh và tố cáo người bán, dịch vụ online uy tín. Bảo vệ cộng đồng khỏi các hành vi lừa đảo.">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

  <style>
    .header-bar {
      background: #2e7d32;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 20px;
      flex-wrap: wrap;
      position: relative;
    }

    .header-logo {
      margin-left: 12px;
    }

    .header-logo a {
      color: white;
      font-size: 20px;
      font-weight: bold;
      text-decoration: none;
      display: inline-block;
    }

    .nav-toggle {
      display: none;
      font-size: 24px;
      color: white;
      background: none;
      border: none;
      cursor: pointer;
    }

    .nav-links {
      display: flex;
      gap: 14px;
      flex-wrap: wrap;
      align-items: center;
    }

    .nav-links a {
      color: white;
      text-decoration: none;
      padding: 6px 12px;
      border-radius: 6px;
      font-size: 15px;
      transition: background 0.2s;
    }

    .nav-links a:hover,
    .nav-links a.active {
      background: rgba(255, 255, 255, 0.2);
    }

    .account-dropdown {
      position: relative;
    }

    .account-toggle {
      background: rgba(255, 255, 255, 0.1);
      color: white;
      padding: 6px 12px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 15px;
    }

    .account-menu {
      display: none;
      position: absolute;
      right: 0;
      background: white;
      border-radius: 6px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
      margin-top: 8px;
      z-index: 99;
      min-width: 150px;
    }

    .account-menu a {
      display: block;
      padding: 10px 15px;
      color: #333;
      text-decoration: none;
    }

    .account-menu a:hover {
      background: #f4f4f4;
    }

    @media (max-width: 768px) {
      .header-bar {
        flex-direction: column;
        align-items: center;
        gap: 10px;
      }

      .header-logo {
        width: 100%;
        text-align: center;
        margin-left: 0;
      }

      .header-logo a {
        display: inline-block;
      }

      .nav-toggle {
        display: block;
        position: absolute;
        left: 20px;
        top: 12px;
      }

      .nav-links {
        display: none;
        flex-direction: column;
        align-items: flex-start;
        width: 100%;
        padding: 10px 0;
      }

      .nav-links.show {
        display: flex;
      }

      .nav-links a {
        width: 100%;
        padding: 10px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 6px;
        margin-bottom: 4px;
      }

      .account-dropdown {
        width: 100%;
        text-align: right;
      }

      .account-toggle {
        width: auto;
        margin-right: 20px;
      }

      .account-menu {
        position: relative;
        margin-top: 6px;
      }
      html, body {
  margin: 0 !important;
  padding: 0 !important;
  border: none !important;
}

body > *:first-child {
  margin-top: 0 !important;
  padding-top: 0 !important;
}
html {
  margin-top: 0 !important;
}

#wpadminbar {
  position: fixed !important;
  top: 0;
  left: 0;
  right: 0;
  z-index: 99999;
}

/* Đẩy header xuống đúng 32px khi đăng nhập (WordPress mặc định admin bar cao 32px) */
body.admin-bar .header-bar {
  margin-top: 32px !important;
}

    }
  </style>

  <nav class="header-bar">
    <div class="header-logo">
      <a href="/">✅ Check Legit</a>
    </div>

    <button class="nav-toggle" id="menuToggle">☰</button>

    <div class="nav-links" id="mainMenu">
      <a href="/danh-sach-legit" class="<?php echo is_page('danh-sach-legit') ? 'active' : ''; ?>">📋 Danh sách LEGIT</a>
      <a href="/bao-cao-lua-dao" class="<?php echo is_page('bao-cao-lua-dao') ? 'active' : ''; ?>">📣 Báo cáo lừa đảo</a>

      <?php if (is_user_logged_in()) : ?>
        <a href="/quan-ly-ho-so-legit" class="<?php echo is_page('quan-ly-ho-so-legit') ? 'active' : ''; ?>">📁 Quản lý Hồ Sơ</a>
      <?php else : ?>
        <a href="/tao-ho-so-legit" class="<?php echo is_page('tao-ho-so-legit') ? 'active' : ''; ?>">🧑‍💼 Tạo Hồ Sơ Legit</a>
      <?php endif; ?>
    </div>

    <div class="account-dropdown">
      <button class="account-toggle">👤 Tài khoản ▾</button>
      <div class="account-menu" id="accountMenu">
        <?php if (is_user_logged_in()) : ?>
          <a href="<?php echo wp_logout_url(home_url()); ?>">🚪 Đăng xuất</a>
        <?php else : ?>
          <a href="/dang-nhap">🔐 Đăng nhập</a>
          <a href="/tao-ho-so-legit">📝 Đăng ký</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const toggle = document.querySelector('.account-toggle');
      const menu = document.getElementById('accountMenu');
      const navToggle = document.getElementById('menuToggle');
      const navMenu = document.getElementById('mainMenu');

      toggle.addEventListener('click', function () {
        menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
      });

      navToggle.addEventListener('click', function () {
        navMenu.classList.toggle('show');
      });

      document.addEventListener('click', function (e) {
        if (!toggle.contains(e.target) && !menu.contains(e.target)) {
          menu.style.display = 'none';
        }
      });
    });
  </script>
