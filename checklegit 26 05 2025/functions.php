<?php
add_theme_support('post-thumbnails');

// === CSS style
function checklegit_enqueue_styles() {
    wp_enqueue_style('checklegit-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'checklegit_enqueue_styles');

// === Post type: Tố cáo
function checklegit_register_post_type_tocao() {
  register_post_type('to_cao', array(
    'labels' => array(
      'name' => 'Tố cáo',
      'singular_name' => 'Tố cáo',
      'add_new' => 'Thêm mới',
      'add_new_item' => 'Thêm báo cáo mới',
      'edit_item' => 'Chỉnh sửa tố cáo',
      'new_item' => 'Báo cáo mới',
      'view_item' => 'Xem báo cáo',
      'search_items' => 'Tìm tố cáo',
      'not_found' => 'Không tìm thấy',
    ),
    'public' => true,
    'show_ui' => true,
    'has_archive' => false,
    'menu_icon' => 'dashicons-shield',
    'supports' => array('title', 'editor', 'custom-fields'),
    'rewrite' => array('slug' => 'ho-so-lua-dao', 'with_front' => false),
  ));
}
add_action('init', 'checklegit_register_post_type_tocao');

// === Post type: Hồ sơ Legit (ho_so_legit)
function register_ho_so_legit_post_type() {
  register_post_type('ho_so_legit', array(
    'labels' => array(
      'name' => 'Hồ sơ Legit',
      'singular_name' => 'Hồ sơ Legit',
      'add_new_item' => 'Thêm hồ sơ mới',
      'edit_item' => 'Chỉnh sửa hồ sơ',
      'all_items' => 'Tất cả hồ sơ',
    ),
    'public' => true,
    'publicly_queryable' => true,
    'exclude_from_search' => false,
    'show_ui' => true,
    'show_in_menu' => true,
    'show_in_rest' => true,
    'menu_icon' => 'dashicons-id',
    'supports' => array('title', 'editor', 'custom-fields', 'thumbnail'),
    'rewrite' => array('slug' => 'ho-so-legit', 'with_front' => false),
    'has_archive' => false,
  ));
}
add_action('init', 'register_ho_so_legit_post_type');

function cl_redirect_old_page_slug() {
  if (is_page('quan-ly-ho-so')) {
    wp_redirect(site_url('/quan-ly-ho-so-legit'));
    exit;
  }
}
add_action('template_redirect', 'cl_redirect_old_page_slug');

function checklegit_include_custom_fields_in_search($query) {
  if (!is_admin() && $query->is_search() && $query->is_main_query()) {
    $query->set('post_type', array('to_cao'));
    $query->set('meta_query', array(
      'relation' => 'OR',
      array('key' => 'bank_number', 'value' => $query->query_vars['s'], 'compare' => 'LIKE'),
      array('key' => 'target_name', 'value' => $query->query_vars['s'], 'compare' => 'LIKE'),
      array('key' => 'phone', 'value' => $query->query_vars['s'], 'compare' => 'LIKE'),
      array('key' => 'contact', 'value' => $query->query_vars['s'], 'compare' => 'LIKE'),
    ));
    $query->set('posts_per_page', -1);
  }
}
add_action('pre_get_posts', 'checklegit_include_custom_fields_in_search');

function checklegit_add_pending_count_badge_to_menu() {
  global $menu;
  $count = wp_count_posts('ho_so_legit');
  $pending = isset($count->pending) ? $count->pending : 0;
  foreach ($menu as $key => $item) {
    if ($item[2] === 'edit.php?post_type=ho_so_legit' && $pending > 0) {
      $menu[$key][0] .= " <span class='update-plugins count-$pending' style='background:#dc3545; color:white; padding:2px 8px; border-radius:12px; font-size:11px;'>$pending</span>";
    }
  }
}
add_action('admin_menu', 'checklegit_add_pending_count_badge_to_menu');

function cl_add_legit_meta_box() {
  add_meta_box(
    'cl_legit_info',
    'Thông Tin Hồ Sơ Legit',
    'cl_legit_meta_box_callback',
    'ho_so_legit',
    'normal',
    'default'
  );
}
add_action('add_meta_boxes', 'cl_add_legit_meta_box');

function cl_legit_meta_box_callback($post) {
  $fields = [
    'phone' => 'Số điện thoại',
    'zalo' => 'Zalo',
    'facebook' => 'Facebook chính',
    'facebook2' => 'Facebook phụ',
    'bank' => 'Số tài khoản',
    'service' => 'Lĩnh vực',
    'xacminh' => 'Gói xác minh',
    'tien_bao_hiem' => 'Tiền bảo hiểm (VND)',

  ];

  $current_data = [];
  foreach (['phone', 'zalo', 'bank'] as $key) {
    $current_data[$key] = get_post_meta($post->ID, $key, true);
  }

  $duplicate_notice = '';
  $matches = [];

  foreach (['phone', 'zalo', 'bank'] as $field) {
    $value = $current_data[$field];
    if (!$value) continue;

    $args = [
      'post_type' => 'ho_so_legit',
      'post_status' => ['publish', 'pending'],
      'post__not_in' => [$post->ID],
      'meta_query' => [[
        'key' => $field,
        'value' => $value,
        'compare' => '='
      ]]
    ];
    $query = new WP_Query($args);
    if ($query->have_posts()) {
      while ($query->have_posts()) {
        $query->the_post();
        $matches[] = [
          'field' => $field,
          'field_label' => $fields[$field],
          'value' => $value,
          'post_id' => get_the_ID(),
          'post_title' => get_the_title(),
          'edit_link' => get_edit_post_link(get_the_ID())
        ];
      }
      wp_reset_postdata();
    }
  }

  if (!empty($matches)) {
    $duplicate_notice .= '<div style="background:#fff3cd; padding:12px 15px; border-left:4px solid #ffc107; margin-bottom:20px;">';
    $duplicate_notice .= '<strong>⚠️ Cảnh báo:</strong> Có thông tin trùng với các hồ sơ sau:<br><ul style="margin:8px 0 0 18px;">';
    foreach ($matches as $m) {
      $duplicate_notice .= '<li>Trùng <strong>' . esc_html($m['field_label']) . '</strong> <code>' . esc_html($m['value']) . '</code> với hồ sơ: <a href="' . esc_url($m['edit_link']) . '" target="_blank">' . esc_html($m['post_title']) . '</a></li>';
    }
    $duplicate_notice .= '</ul></div>';
    echo $duplicate_notice;
  }

// === Giao diện chỉnh sửa meta
echo '<table class="form-table">';

echo '<tr><th><label for="cl_publish_now">Duyệt hồ sơ</label></th><td><input type="checkbox" name="cl_publish_now" value="1" /> <em>(Chuyển sang trạng thái đã duyệt)</em></td></tr>';

foreach ($fields as $key => $label) {
  $value = get_post_meta($post->ID, $key, true);

  if ($key === 'bank') {
    echo '<tr><th><label for="bank">' . esc_html($label) . '</label></th>';
    echo '<td><textarea id="bank" name="bank" rows="4" style="width:100%;">' . esc_textarea($value) . '</textarea></td></tr>';
  } else {
    echo '<tr><th><label for="' . esc_attr($key) . '">' . esc_html($label) . '</label></th>';
    echo '<td><input type="text" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '" class="regular-text"></td></tr>';
  }
}

echo '</table>';
}

function cl_save_legit_meta_box($post_id) {
  $keys = ['phone','zalo','facebook','facebook2','bank','service','xacminh','tien_bao_hiem'];
  if (isset($_POST['cl_publish_now'])) {
    remove_action('save_post_ho_so_legit', 'cl_save_legit_meta_box');
    wp_update_post(['ID' => $post_id, 'post_status' => 'publish']);
    add_action('save_post_ho_so_legit', 'cl_save_legit_meta_box');
  }
 foreach ($keys as $key) {
  if (isset($_POST[$key])) {
    $value = ($_POST[$key]);

    // Nếu là trường bank thì giữ xuống dòng
    if ($key === 'bank') {
      $value = sanitize_textarea_field($value);
    } else {
      $value = sanitize_text_field($value);
    }

    update_post_meta($post_id, $key, $value);
  }
}

}
add_action('save_post_ho_so_legit', 'cl_save_legit_meta_box');

function cl_add_legit_columns($columns) {
  $columns['xacminh'] = 'Gói xác minh';
  return $columns;
}
add_filter('manage_ho_so_legit_posts_columns', 'cl_add_legit_columns');

function cl_show_legit_column($column, $post_id) {
  if ($column == 'xacminh') {
    $xacminh = get_post_meta($post_id, 'xacminh', true);
    if ($xacminh == '500000') echo 'Cơ Bản';
    elseif ($xacminh == '1000000') echo 'Đồng 🥉';
    elseif ($xacminh == '2000000') echo 'Bạc 🥈';
    elseif ($xacminh == '5000000') echo 'Vàng 🥇';
    elseif ($xacminh == '10000000') echo 'Kim Cương 💎';
    else echo '—';
  }
}
add_action('manage_ho_so_legit_posts_custom_column', 'cl_show_legit_column', 10, 2);

function cl_ajax_suggest_search() {
  $term = isset($_GET['term']) ? sanitize_text_field($_GET['term']) : '';

  $args = [
    'post_type' => 'to_cao',
    'post_status' => 'publish',
    'posts_per_page' => 5,
    'meta_query' => [
      'relation' => 'OR',
      ['key' => 'bank_number', 'value' => $term, 'compare' => 'LIKE'],
      ['key' => 'phone', 'value' => $term, 'compare' => 'LIKE'],
      ['key' => 'contact', 'value' => $term, 'compare' => 'LIKE'],
      ['key' => 'target_name', 'value' => $term, 'compare' => 'LIKE'],
      ['key' => 'target_name_friendly', 'value' => $term, 'compare' => 'LIKE'],
    ]
  ];

  $query = new WP_Query($args);
  $results = [];

  if ($query->have_posts()) {
    while ($query->have_posts()) {
      $query->the_post();

      $post_id  = get_the_ID();
      $name     = get_post_meta($post_id, 'target_name', true);
      $nickname = get_post_meta($post_id, 'target_name_friendly', true);
      $bank     = get_post_meta($post_id, 'bank_number', true);
      $phone    = get_post_meta($post_id, 'phone', true);
      $contact  = get_post_meta($post_id, 'contact', true);

      // === Tên hiển thị
      $title = 'Không rõ tên';
      if (!empty($name) && !empty($nickname)) {
        $title = $name . ' (' . $nickname . ')';
      } elseif (!empty($name)) {
        $title = $name;
      } elseif (!empty($nickname)) {
        $title = $nickname;
      }

      // === Nếu search trùng phone hoặc contact thì thêm phần đó
      $note = '';
      if (!empty($phone) && stripos($phone, $term) !== false) {
        $note = $phone;
      } elseif (!empty($contact) && stripos($contact, $term) !== false) {
        $note = $contact;
      }

      // === Gộp label
      $label = esc_html($title) . ' – ' . esc_html($bank);
      if (!empty($note)) {
        $label .= ' – ' . esc_html($note);
      }

      $results[] = [
        'label' => $label,
        'value' => $title,
        'link'  => get_permalink()
      ];
    }
  }

  wp_send_json($results);
}
add_action('wp_ajax_cl_suggest_search', 'cl_ajax_suggest_search');
add_action('wp_ajax_nopriv_cl_suggest_search', 'cl_ajax_suggest_search');

// === Meta box cảnh báo trùng hồ sơ đã bị tố cáo
// Mục đích: khi duyệt 1 hồ sơ 'to_cao', hệ thống sẽ kiểm tra xem các trường `phone`, `contact`, `bank_number` có trùng với hồ sơ nào khác không
// Điều kiện:
// - Chỉ kiểm tra các trường không rỗng
// - Bỏ qua chính hồ sơ đang duyệt (post__not_in)
// Kết quả:
// - Nếu có hồ sơ trùng, hiển thị danh sách + ghi rõ trùng trường nào (VD: "trùng STK, SĐT")
// - Nếu không có, hiển thị thông báo ✅ không trùng
// - Nếu không có đủ dữ liệu để kiểm tra, báo "Không đủ thông tin để kiểm tra trùng"

// === Meta box cảnh báo trùng tố cáo khi duyệt bài 'to_cao'
function cl_tocao_warning_meta_box_callback($post) {
  $post_id = $post->ID;

  // Lấy dữ liệu gốc của bài viết
  $phone   = get_post_meta($post_id, 'phone', true);
  $contact = get_post_meta($post_id, 'contact', true);
  $bank    = get_post_meta($post_id, 'bank_number', true);

  // Chuẩn bị điều kiện truy vấn — chỉ thêm nếu KHÔNG rỗng
  $meta_query = ['relation' => 'OR'];
  if (!empty($phone))   $meta_query[] = ['key' => 'phone', 'value' => $phone, 'compare' => '='];
  if (!empty($contact)) $meta_query[] = ['key' => 'contact', 'value' => $contact, 'compare' => '='];
  if (!empty($bank))    $meta_query[] = ['key' => 'bank_number', 'value' => $bank, 'compare' => '='];

  if (count($meta_query) === 1) {
    echo '<div style="color:#6c757d;">⚠️ Không có đủ thông tin để kiểm tra trùng lặp.</div>';
    return;
  }

  // Truy vấn các hồ sơ có thể trùng (ngoại trừ bản thân)
  $query = new WP_Query([
    'post_type'    => 'to_cao',
    'post_status'  => ['publish', 'pending'],
    'post__not_in' => [$post_id],
    'meta_query'   => $meta_query,
  ]);

  if ($query->have_posts()) {
    echo '<div style="background:#fff3cd; padding:10px; border-left:4px solid #ffc107;">';
    echo '⚠️ <strong>Hồ sơ này trùng thông tin với các báo cáo sau:</strong><ul>';

    while ($query->have_posts()) {
      $query->the_post();
      $match_fields = [];

      // Kiểm tra trùng trường nào (chỉ khi trường gốc không rỗng)
      if (!empty($phone) && $phone === get_post_meta(get_the_ID(), 'phone', true)) {
        $match_fields[] = 'SĐT';
      }
      if (!empty($contact) && $contact === get_post_meta(get_the_ID(), 'contact', true)) {
        $match_fields[] = 'Liên hệ';
      }
      if (!empty($bank) && $bank === get_post_meta(get_the_ID(), 'bank_number', true)) {
        $match_fields[] = 'STK';
      }

      $match_text = !empty($match_fields) ? ' (trùng ' . implode(', ', $match_fields) . ')' : '';
      echo '<li><a href="' . get_edit_post_link(get_the_ID()) . '" target="_blank">' . get_the_title() . '</a>' . esc_html($match_text) . '</li>';
    }

    echo '</ul></div>';
    wp_reset_postdata();
  } else {
    echo '<div style="color:#28a745;"><strong>✅ Không phát hiện hồ sơ trùng trong hệ thống.</strong></div>';
  }
}


// === Thêm cột "Cảnh báo trùng" vào danh sách Tố Cáo
function cl_add_tocao_columns($columns) {
  $columns['duplicate_warning'] = '⚠️ Trùng dữ liệu?';
  return $columns;
}
add_filter('manage_to_cao_posts_columns', 'cl_add_tocao_columns');
// === Cột "⚠️ Trùng dữ liệu?" trong danh sách admin Tố cáo
// Mục đích: hiển thị dấu cảnh báo nếu hồ sơ đang có trùng với bất kỳ hồ sơ tố cáo nào khác (dựa trên SĐT, STK, Liên hệ)
// Điều kiện:
// - Bỏ qua chính hồ sơ đang kiểm tra (post__not_in)
// - Chỉ truy vấn nếu có ít nhất 1 trường trong số phone / contact / bank_number có giá trị
// - Nếu có hồ sơ khác trùng, hiển thị badge đỏ "⚠️ Trùng"
// - Nếu không trùng, hiển thị dấu "✔ Không"
// - Nếu thiếu toàn bộ thông tin để so sánh (các trường đều rỗng), hiển thị "Không đủ dữ liệu"
function cl_show_tocao_column($column, $post_id) {
  if ($column !== 'duplicate_warning') return;

  $phone   = get_post_meta($post_id, 'phone', true);
  $contact = get_post_meta($post_id, 'contact', true);
  $bank    = get_post_meta($post_id, 'bank_number', true);

  $meta_query = ['relation' => 'OR'];
  if (!empty($phone))   $meta_query[] = ['key' => 'phone', 'value' => $phone, 'compare' => '='];
  if (!empty($contact)) $meta_query[] = ['key' => 'contact', 'value' => $contact, 'compare' => '='];
  if (!empty($bank))    $meta_query[] = ['key' => 'bank_number', 'value' => $bank, 'compare' => '='];

  // Nếu không có trường nào để so sánh
  if (count($meta_query) === 1) {
    echo '<span style="color:#6c757d;">Không đủ dữ liệu</span>';
    return;
  }

  $query = new WP_Query([
    'post_type'    => 'to_cao',
    'post_status'  => ['publish', 'pending'],
    'post__not_in' => [$post_id],
    'meta_query'   => $meta_query
  ]);

  if ($query->have_posts()) {
    echo '<span style="background:#dc3545; color:#fff; padding:2px 6px; border-radius:4px; font-size:12px;">⚠️ Trùng</span>';
  } else {
    echo '<span style="color:#28a745;">✔ Không</span>';
  }

  wp_reset_postdata();
}
add_action('manage_to_cao_posts_custom_column', 'cl_show_tocao_column', 10, 2);

// === Tạo lượt xem ảo cho bài tố cáo mới tạo
function cl_init_tocao_view_count($post_id, $post, $update) {
  if ($post->post_type !== 'to_cao') return;

  if (!$update && get_post_meta($post_id, 'initial_views', true) === '') {
    $init = rand(50, 100);
    update_post_meta($post_id, 'initial_views', $init);
    update_post_meta($post_id, 'created_time', time());
  }
}
add_action('save_post', 'cl_init_tocao_view_count', 10, 3);

// === Hiển thị badge cảnh báo nếu có hồ sơ tố cáo đang chờ duyệt
function checklegit_add_pending_tocao_badge_to_menu() {
  global $menu;
  $count = wp_count_posts('to_cao');
  $pending = isset($count->pending) ? $count->pending : 0;
  foreach ($menu as $key => $item) {
    if ($item[2] === 'edit.php?post_type=to_cao' && $pending > 0) {
      $menu[$key][0] .= " <span class='update-plugins count-$pending' style='background:#dc3545; color:white; padding:2px 8px; border-radius:12px; font-size:11px;'>$pending</span>";
    }
  }
}
add_action('admin_menu', 'checklegit_add_pending_tocao_badge_to_menu');

// === Lưu dữ liệu khi admin nhập trực tiếp meta (không lưu nếu gọi từ form ngoài frontend)
function cl_save_tocao_meta_box($post_id) {
  if (get_post_type($post_id) !== 'to_cao') return;

  if (defined('CL_FORM_HANDLING')) return; // ⚠️ Form đã xử lý rồi → không lưu lại nữa

  // ➕ Thêm 'mo_ta_lua_dao' vào đây
$fields = ['target_name_friendly', 'target_name', 'bank_number', 'bank_name', 'phone', 'contact', 'mo_ta_lua_dao'];


  foreach ($fields as $key) {
    if (isset($_POST[$key])) {
      update_post_meta($post_id, $key, sanitize_text_field($_POST[$key]));
    }
  }
}

add_action('save_post_to_cao', 'cl_save_tocao_meta_box');

function cl_save_post_content_tocao($post_id) {
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if (get_post_type($post_id) !== 'to_cao') return;

  if (isset($_POST['post_content'])) {
    // Ngắt để tránh lặp
    remove_action('save_post_to_cao', 'cl_save_post_content_tocao');

    $content = wp_kses_post($_POST['post_content']);
    wp_update_post([
      'ID' => $post_id,
      'post_content' => $content
    ]);

    // Gắn lại sau update
    add_action('save_post_to_cao', 'cl_save_post_content_tocao');
  }
}
add_action('save_post_to_cao', 'cl_save_post_content_tocao');



//=== Ảnh hồ sơ lừa đảo trong admin khi cần duyệt
function cl_add_evidence_metabox() {
  add_meta_box(
    'cl_evidence_imgur',
    'Ảnh bằng chứng (Imgur)',
    'cl_show_evidence_metabox',
    'to_cao',
    'normal',
    'default'
  );
}

add_action('add_meta_boxes', 'cl_add_evidence_metabox');
function cl_add_mota_metabox() {
  add_meta_box(
    'cl_mota_lua_dao',
    'Mô tả ngắn (hiển thị dưới tiêu đề)',
    'cl_show_mota_metabox',
    'to_cao',
    'normal',
    'default'
  );
}
add_action('add_meta_boxes', 'cl_add_mota_metabox');

function cl_show_mota_metabox($post) {
  $value = get_post_meta($post->ID, 'mo_ta_lua_dao', true);
  echo '<input type="text" name="mo_ta_lua_dao" style="width:100%; font-size:16px; padding:8px;" value="' . esc_attr($value) . '" placeholder="VD: Lừa cọc tiền mua máy ảnh">';
}
function cl_add_lydo_metabox() {
  add_meta_box(
    'cl_ly_do_tocao',
    'Lý do bạn muốn báo cáo (nội dung chi tiết)',
    'cl_show_lydo_metabox',
    'to_cao',
    'normal',
    'default'
  );
}

function cl_show_lydo_metabox($post) {
  $content = $post->post_content;
  echo '<textarea name="post_content" style="width:100%; height:200px; font-size:15px;">' . esc_textarea($content) . '</textarea>';
}

function cl_show_evidence_metabox($post) {
  $images = get_post_meta($post->ID, 'evidence_urls', true);
  if (is_array($images) && !empty($images)) {
    echo '<div style="display:flex; flex-wrap:wrap; gap:10px;">';
    foreach ($images as $img) {
      echo '<a href="' . esc_url($img) . '" target="_blank">
              <img src="' . esc_url($img) . '" style="max-width:150px; border:1px solid #ccc; border-radius:4px;">
            </a>';
    }
    echo '</div>';
  } else {
    echo '<p>Không có ảnh bằng chứng nào.</p>';
  }
}

add_filter('use_block_editor_for_post_type', function ($use_block_editor, $post_type) {
    if ($post_type === 'ho_so_legit') return false;
    return $use_block_editor;
}, 10, 2);
if (!defined('WP_MEMORY_LIMIT')) {
  define('WP_MEMORY_LIMIT', '768M');
}
if (!defined('WP_MAX_MEMORY_LIMIT')) {
  define('WP_MAX_MEMORY_LIMIT', '768M');
}
// ✅ Redirect user không phải admin khi vào wp-admin
add_action('admin_init', function () {
  if (!current_user_can('administrator') && !wp_doing_ajax()) {
    wp_redirect(home_url('/quan-ly-ho-so-legit'));
    exit;
  }
});
// ✅ Thêm metabox "Link bài viết tố cáo" cho post type 'to_cao'
function cl_add_link_bai_viet_meta_box() {
  add_meta_box(
    'cl_link_bai_viet',
    '🔗 Link bài viết tố cáo',
    'cl_render_link_bai_viet_meta_box',
    'to_cao',
    'normal',
    'default'
  );
}
add_action('add_meta_boxes', 'cl_add_link_bai_viet_meta_box');

function cl_render_link_bai_viet_meta_box($post) {
  $value = get_post_meta($post->ID, 'link_bai_viet', true);
  echo '<input type="url" name="link_bai_viet" value="' . esc_attr($value) . '" style="width:100%; padding:10px; border-radius:6px;" placeholder="https://facebook.com/...">';
}

// ✅ Lưu dữ liệu khi admin cập nhật bài
function cl_save_link_bai_viet_meta_box($post_id) {
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if (isset($_POST['link_bai_viet'])) {
    update_post_meta($post_id, 'link_bai_viet', esc_url_raw($_POST['link_bai_viet']));
  }
}


add_action('save_post_to_cao', 'cl_save_link_bai_viet_meta_box');
// Tin tức
function cl_register_post_type_tin_tuc() {
  register_post_type('tin_tuc', array(
    'labels' => array(
      'name' => 'Tin tức',
      'singular_name' => 'Bài viết',
      'add_new' => 'Viết bài mới',
      'add_new_item' => 'Thêm bài viết mới',
      'edit_item' => 'Sửa bài viết',
      'new_item' => 'Bài viết mới',
      'view_item' => 'Xem bài viết',
      'search_items' => 'Tìm bài viết',
      'not_found' => 'Không có bài viết',
      'not_found_in_trash' => 'Không có bài viết trong thùng rác',
    ),
    'public' => true,
    'has_archive' => true,
    'rewrite' => array('slug' => 'tin-tuc'),
    'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
    'menu_icon' => 'dashicons-welcome-write-blog',
    'show_in_rest' => false
  ));
}
add_action('init', 'cl_register_post_type_tin_tuc');
// ✅ Metabox hiển thị "Tên đối tượng" (nickname, tên giả)
function cl_add_target_name_friendly_metabox() {
  add_meta_box(
    'cl_target_name_friendly_box',
    '👤 Tên đối tượng (nickname, tên giả)',
    'cl_render_target_name_friendly_metabox',
    'to_cao',
    'normal',
    'default'
  );
}
add_action('add_meta_boxes', 'cl_add_target_name_friendly_metabox');

function cl_render_target_name_friendly_metabox($post) {
  $value = get_post_meta($post->ID, 'target_name_friendly', true);
  echo '<input type="text" name="target_name_friendly" value="' . esc_attr($value) . '" style="width:100%; font-size:16px;" placeholder="Tên giả / tên Facebook / biệt danh...">';
}
// Thêm cột vào danh sách Tố cáo
function cl_add_target_name_friendly_column($columns) {
  $columns['target_name_friendly'] = '👤 Tên đối tượng';
  return $columns;
}
add_filter('manage_to_cao_posts_columns', 'cl_add_target_name_friendly_column');

// Hiển thị giá trị trong cột
function cl_show_target_name_friendly_column($column, $post_id) {
  if ($column === 'target_name_friendly') {
    echo esc_html(get_post_meta($post_id, 'target_name_friendly', true));
  }
}
add_action('manage_to_cao_posts_custom_column', 'cl_show_target_name_friendly_column', 10, 2);

// Gửi thông báo Discord khi có tố cáo hoặc hồ sơ legit mới
add_action('wp_insert_post', 'cl_send_discord_alert', 10, 3);
function cl_send_discord_alert($post_ID, $post, $update) {
  if ($update) return;

  $webhook_url = 'https://discord.com/api/webhooks/1376252975239926033/1aWJAVL7tsFGx57mX-b8_5aVMCj2V8GOQxJohBLI5BRAegiIY8g7JNP-0dRl2tRJfZ-3'; // 🔁 Thay bằng Webhook thật

  if ($post->post_type == 'to_cao') {
    $title = $post->post_title;
    $link = get_permalink($post_ID);
    $msg = "**🚨 TỐ CÁO MỚI**\n**Tên:** $title\n🔗 [Xem chi tiết]($link)";
  } elseif ($post->post_type == 'ho_so_legit') {
    $title = $post->post_title;
    $link = get_permalink($post_ID);
    $msg = "**🟢 HỒ SƠ LEGIT MỚI**\n**Tên:** $title\n🔗 [Xem chi tiết]($link)";
  } else {
    return;
  }

  $payload = json_encode(['content' => $msg]);

  wp_remote_post($webhook_url, [
    'headers' => ['Content-Type' => 'application/json'],
    'body'    => $payload,
  ]);
}
