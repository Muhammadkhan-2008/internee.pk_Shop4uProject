<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); color: #fff; padding: 15px 0; border-bottom: 3px solid #007cba; box-shadow: 0 2px 10px rgba(0,0,0,0.2); position: sticky; top: 0; z-index: 100;">
    <div class="container" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <h1 style="margin:0; font-size: clamp(20px, 5vw, 28px); font-weight: 800; letter-spacing: 1px; flex-shrink: 0;">🛍️ Shop4U</h1>
        <div style="position:relative; flex: 1; min-width: 180px;">
            <input type="text" id="s-input" placeholder="🔍 Search products..." style="width: 100%; padding: 10px 15px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
            <ul id="s-results" style="position:absolute; background:#fff; color:#000; list-style:none; width:100%; padding:0; display:none; z-index:10; border-radius: 5px; margin-top: 2px;"></ul>
        </div>
        <a href="<?php echo wc_get_cart_url(); ?>" style="color:#fff; text-decoration: none; font-weight: bold; white-space: nowrap; padding: 8px 15px; background: #007cba; border-radius: 5px; transition: all 0.3s;">
            🛒 Cart (<span id="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>)
        </a>
    </div>
</header>
<script>
document.getElementById('s-input').onkeyup = function() {
    let t = this.value;
    if(t.length > 1) {
        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'action=live_search&term=' + encodeURIComponent(t)
        }).then(res => res.text()).then(data => {
            document.getElementById('s-results').innerHTML = data;
            document.getElementById('s-results').style.display = 'block';
        });
    } else {
        document.getElementById('s-results').style.display = 'none';
    }
};

document.addEventListener('click', function(e) {
    if (e.target.id !== 's-input') {
        document.getElementById('s-results').style.display = 'none';
    }
});
</script>