<?php
/* Template Name: Quản Lý Hồ Sơ Legit */
get_header();

if (!is_user_logged_in()) {
    wp_redirect(site_url('/dang-nhap'));
    exit;
}

$current_user_id = get_current_user_id();
$args = [
    'post_type'   => 'ho_so_legit',
    'author'      => $current_user_id,
    'post_status' => ['publish', 'pending', 'draft'],
    'numberposts' => 1,
];

$hoso = get_posts($args);
?>

<div style="max-width: 800px; margin: 40px auto; font-family: 'Segoe UI', sans-serif;">
    <?php if ($hoso):
        $post = $hoso[0];
        setup_postdata($post);

        $phone         = get_post_meta($post->ID, 'phone', true);
        $zalo          = get_post_meta($post->ID, 'zalo', true);
        $bank          = get_post_meta($post->ID, 'bank', true);
        $service       = get_post_meta($post->ID, 'service', true);
        $facebook      = get_post_meta($post->ID, 'facebook', true);
        $facebook_phu  = get_post_meta($post->ID, 'facebook_phu', true);
        $xacminh       = get_post_meta($post->ID, 'xacminh', true);

        $badge = 'Chưa xác minh';
        $color = '#6c757d';
        if ($xacminh == '500000') {
            $badge = 'Hạng Cơ Bản';
            $color = '#8d6e63';
        } elseif ($xacminh == '1000000') {
            $badge = 'Hạng Đồng 🥉';
            $color = '#a8712d';
        } elseif ($xacminh == '2000000') {
            $badge = 'Hạng Bạc 🥈';
            $color = '#c0c0c0';
        } elseif ($xacminh == '5000000') {
            $badge = 'Hạng Vàng 🥇';
            $color = '#ffd700';
        } elseif ($xacminh == '10000000') {
            $badge = 'Hạng Kim Cương 💎';
            $color = '#00bcd4';
        }

        $status = get_post_status($post->ID);
        $status_text = $status === 'publish' ? '✅ Đã duyệt' : ($status === 'pending' ? '⏳ Chờ duyệt' : '📝 Nháp');
    ?>

    <div style="background: white; padding: 40px 30px; border-radius: 16px; box-shadow: 0 0 15px rgba(0,0,0,0.06); text-align: center;">
        <h2 style="color: #2e7d32; margin-bottom: 25px;">📋 Hồ Sơ Legit của bạn</h2>

        <?php if (has_post_thumbnail($post->ID)) : ?>
            <div style="margin-bottom: 15px;">
                <?php echo get_the_post_thumbnail($post->ID, 120, ['style' => 'border-radius: 50%; width: 120px; height: 120px; object-fit: cover;']); ?>
            </div>
        <?php endif; ?>

        <h3 style="color:#2e7d32; font-size: 22px; font-weight: 600; margin-bottom: 25px;">
          <?php echo esc_html(get_the_title()); ?>
        </h3>

        <div style="margin: 0 auto; text-align: left; display: inline-block; font-size: 16px; line-height: 1.9;">
            <p><strong>📱 Zalo:</strong> <?php echo esc_html($zalo); ?></p>
            <p><strong>📞 Số điện thoại:</strong> <?php echo esc_html($phone); ?></p>
            <p><strong>💳 Số tài khoản:</strong><br><?php echo nl2br(esc_html($bank)); ?></p>
            <p><strong>🛠️ Dịch vụ:</strong> <?php echo esc_html($service); ?></p>

            <?php if ($facebook): ?>
                <p><strong>🔗 Facebook:</strong> <a href="<?php echo esc_url($facebook); ?>" target="_blank"><?php echo esc_html($facebook); ?></a></p>
            <?php endif; ?>

            <?php if ($facebook_phu): ?>
                <p><strong>🔄 Facebook phụ:</strong> <a href="<?php echo esc_url($facebook_phu); ?>" target="_blank"><?php echo esc_html($facebook_phu); ?></a></p>
            <?php endif; ?>

            <p><strong>✅ Gói xác minh:</strong> 
                <span style="background:<?php echo $color; ?>; color:white; padding:6px 12px; border-radius:6px;">
                    <?php echo $badge; ?>
                </span>
            </p>

            <p><strong>📄 Trạng thái hồ sơ:</strong> <?php echo $status_text; ?></p>
        </div>

        <div style="margin-top: 35px; text-align:right;">
            <a href="/chinh-sua-ho-so-legit?post_id=<?php echo $post->ID; ?>" style="color:#2e7d32; font-weight:500; text-decoration:none;">✏️ Chỉnh sửa hồ sơ</a>
        </div>
    </div>

    <?php wp_reset_postdata(); ?>
    <?php else: ?>
        <div style="background:#fff3cd; padding: 20px; text-align:center; border-radius: 6px;">
            ⚠️ Bạn chưa có hồ sơ nào.<br>
            <a href="/tao-ho-so-legit" style="text-decoration: underline;">👉 Tạo Hồ Sơ Legit ngay</a>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
