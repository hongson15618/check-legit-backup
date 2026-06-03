<footer style="
  background: linear-gradient(135deg, #1b3d63, #0f172a);
  color: #e0e0e0;
  padding: 50px 30px;
  font-size: 15px;
  margin-top: 60px;
  font-family: 'Segoe UI', sans-serif;
  box-shadow: 0 -5px 20px rgba(0,0,0,0.25);
">
  <div style="
    max-width: 1100px;
    margin: auto;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 30px;
    text-align: left;
  ">

    <!-- Cột 1 -->
    <div style="flex: 1; min-width: 220px;">
      <h4 style="color: #fff; margin-bottom: 12px;">✅ Check Legit</h4>
      <p>Nền tảng xác minh & đánh giá uy tín người bán online.</p>
      <p style="opacity: 0.8;">© <?php echo date('Y'); ?> By Check Legit.</p>
    </div>

    <!-- Cột 2 -->
    <div style="flex: 1; min-width: 180px;">
      <h4 style="color: #fff; margin-bottom: 12px;">📂 Liên kết</h4>
      <p><a href="<?php echo site_url('/lien-he'); ?>" style="color:#7ee787; text-decoration:none;">📞 Liên hệ</a></p>
      <p><a href="<?php echo site_url('/chinh-sach'); ?>" style="color:#7ee787; text-decoration:none;">📜 Chính sách</a></p>
      <p><a href="<?php echo site_url('/dieu-khoan'); ?>" style="color:#7ee787; text-decoration:none;">📘 Điều khoản</a></p>
    </div>

    <!-- Cột 3 -->
    <div style="flex: 1; min-width: 180px;">
      <h4 style="color: #fff; margin-bottom: 12px;">🌐 Kết nối</h4>
      <p><a href="https://www.facebook.com/profile.php?id=61575814323823" target="_blank" style="color:#7ee787; text-decoration:none;">📘 Facebook</a></p>
      <p><a href="https://zalo.me/0789991555" target="_blank" style="color:#7ee787; text-decoration:none;">💬 Zalo</a></p>
    </div>

  </div>
  <!-- Nút scroll top -->
<button id="scrollTopBtn" title="Lên đầu trang" style="
  position: fixed;
  bottom: 25px;
  right: 25px;
  display: none;
  background: linear-gradient(135deg, #3b82f6, #1d4ed8);
  color: white;
  border: none;
  padding: 14px 16px;
  border-radius: 50%;
  font-size: 20px;
  cursor: pointer;
  box-shadow: 0 8px 20px rgba(59,130,246,0.4);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  z-index: 999;
">
  ⬆️
</button>

<script>
  const btn = document.getElementById("scrollTopBtn");
  window.onscroll = () => {
    btn.style.display = (document.documentElement.scrollTop > 200) ? "block" : "none";
  };
  btn.addEventListener("click", () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
</script>
<!-- Disclaimer nhỏ dưới cùng -->
<div style="
  background: #0e1a2b;
  color: #cccccc;
  text-align: center;
  font-size: 13px;
  padding: 12px 20px;
  border-top: 1px solid rgba(255,255,255,0.1);
  margin-top: 30px;
">
  📌 <strong>Miễn trừ trách nhiệm:</strong> CheckLegit.online là nền tảng cộng đồng nhằm hỗ trợ người dùng tra cứu và cảnh báo, không chịu trách nhiệm về các giao dịch cá nhân hoặc tranh chấp phát sinh.
</div>

</footer>
