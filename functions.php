<?php
// 1. Core Setup
add_action('after_setup_theme', function() {
    add_theme_support('woocommerce');
    add_theme_support('post-thumbnails');
});

// 2. Disable WooCommerce Default CSS (To Fix Layout)
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

// Reset Products (For Testing - visit /?reset_products=1)
add_action('init', 'shop4u_reset_check');
function shop4u_reset_check() {
    if (isset($_GET['reset_products']) && $_GET['reset_products'] == '1') {
        delete_option('shop4u_final_fix_v2');
        delete_option('shop4u_desc_added');
        wp_safe_remote_get(home_url()); // Reload to trigger product sync
        wp_die('Products reset! Reloading...');
    }
}

// 3. Force Sync Products with Online Images
add_action('init', 'shop4u_master_sync');
function shop4u_master_sync() {
    if (!class_exists('WooCommerce') || get_option('shop4u_final_fix_v2')) return;

    $items = [
        [
            'n' => 'RGB Keyboard - Mechanical Gaming',
            's' => 'S4U-001',
            'p' => '4500',
            'img' => get_template_directory_uri() . '/images/1.jpg',
            'desc' => 'Professional mechanical RGB keyboard with 104 keys, Cherry MX switches, customizable lighting effects, and anti-ghosting technology. Perfect for gaming and typing.'
        ],
        [
            'n' => '4K Monitor - 27" Premium Display',
            's' => 'S4U-002',
            'p' => '35000',
            'img' => get_template_directory_uri() . '/images/2.jpg',
            'desc' => '27-inch 4K UHD Monitor with IPS panel, 60Hz refresh rate, HDR support, USB-C connectivity, and factory calibrated colors. Ideal for designers and content creators.'
        ],
        [
            'n' => 'Smartphone X - Latest Model',
            's' => 'S4U-003',
            'p' => '95000',
            'img' => get_template_directory_uri() . '/images/3.jpg',
            'desc' => 'Latest generation smartphone with 108MP camera system, 5G connectivity, 12GB RAM, 256GB storage, and all-day battery life.'
        ],
        [
            'n' => 'Pro Microphone - Studio Quality',
            's' => 'S4U-004',
            'p' => '8500',
            'img' => get_template_directory_uri() . '/images/4.jpg',
            'desc' => 'Professional USB condenser microphone with noise cancellation, cardioid pickup pattern, 16-bit/48kHz audio, perfect for streaming and podcasting.'
        ],
        [
            'n' => 'USB-C Cable - Premium Quality',
            's' => 'S4U-005',
            'p' => '1200',
            'img' => get_template_directory_uri() . '/images/5.png',
            'desc' => 'Premium USB-C 3.1 cable with 100W fast charging, 480Mbps data transfer speed, durable braided design, and lifetime warranty.'
        ]
    ];

    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    foreach ($items as $item) {
        $old_id = wc_get_product_id_by_sku($item['s']);
        if ($old_id) wp_delete_post($old_id, true);

        $product = new WC_Product_Simple();
        $product->set_name($item['n']);
        $product->set_regular_price($item['p']);
        $product->set_sku($item['s']);
        $product->set_description($item['desc']);
        $product->set_short_description($item['desc']);
        $product->set_status('publish');
        $product->set_stock_quantity(50);
        $product->set_stock_status('instock');
        $id = $product->save();

        // Store image URL directly as meta
        update_post_meta($id, '_product_image_url', $item['img']);
    }
    
    update_option('shop4u_final_fix_v2', true);
}

// 4. Live Search AJAX Handler
add_action('wp_ajax_nopriv_live_search', 'shop4u_live_search');
add_action('wp_ajax_live_search', 'shop4u_live_search');
function shop4u_live_search() {
    $term = sanitize_text_field($_POST['term']);
    
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 8,
        's'              => $term,
        'fields'         => 'ids'
    );
    
    $products = get_posts($args);
    
    if (!empty($products)) {
        foreach ($products as $product_id) {
            $product = wc_get_product($product_id);
            echo '<li onclick="window.location.href=\'' . esc_url($product->get_permalink()) . '\'" style="cursor:pointer;">
                    <strong>' . esc_html($product->get_name()) . '</strong> - ' . wp_kses_post($product->get_price_html()) . '
                  </li>';
        }
    } else {
        echo '<li style="padding:10px; color:#999;">No products found</li>';
    }
    
    wp_die();
}

// 5. Enqueue Styles & Scripts
add_action('wp_enqueue_scripts', 'shop4u_enqueue_assets');
function shop4u_enqueue_assets() {
    wp_enqueue_style('shop4u-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_script('wc-add-to-cart');
}

// 6. Display Cart Count via AJAX
add_action('wp_ajax_nopriv_get_cart_count', 'shop4u_get_cart_count');
add_action('wp_ajax_get_cart_count', 'shop4u_get_cart_count');
function shop4u_get_cart_count() {
    echo WC()->cart->get_cart_contents_count();
    wp_die();
}

// 7. Add Product Descriptions
add_action('init', 'shop4u_add_descriptions');
function shop4u_add_descriptions() {
    if (get_option('shop4u_desc_added')) return;
    
    $descriptions = [
        'S4U-001' => 'Professional RGB mechanical keyboard with 7-color lighting effects. Ultra-responsive switches perfect for gaming and typing.',
        'S4U-002' => '4K Ultra HD Monitor with 60Hz refresh rate. IPS panel for accurate colors. Perfect for designers and content creators.',
        'S4U-003' => 'Latest flagship smartphone with 108MP camera, 5G connectivity, and all-day battery life.',
        'S4U-004' => 'Studio-quality USB microphone with noise cancellation. Perfect for streaming and podcasting.',
        'S4U-005' => 'Premium USB-C 3.1 cable with 100W power delivery and 480Mbps data transfer speed.'
    ];
    
    foreach ($descriptions as $sku => $desc) {
        $product_id = wc_get_product_id_by_sku($sku);
        if ($product_id) {
            wp_update_post([
                'ID'           => $product_id,
                'post_excerpt' => $desc,
            ]);
        }
    }
    
    update_option('shop4u_desc_added', true);
}