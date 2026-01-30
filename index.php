<?php get_header(); ?>

<section class="hero" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 60px 20px; text-align: center; margin-bottom: 50px;">
    <div class="container">
        <h2 style="margin-bottom: 20px;">Welcome to Shop4U</h2>
        <p style="margin-bottom: 30px;">Premium Tech Products at Best Prices</p>
        <a href="<?php echo wc_get_page_id( 'shop' ); ?>" style="background: #fff; color: #667eea; padding: 14px 35px; border-radius: 5px; text-decoration: none; font-weight: bold; display: inline-block;">Browse All Products</a>
    </div>
</section>

<main class="container" style="padding: 50px 20px;">
    <section style="margin-bottom: 50px;">
        <h3 style="text-align: center; margin-bottom: 40px;">⭐ Featured Products</h3>
        <div class="products-grid">
            <?php
                $args = array(
                    'post_type'      => 'product',
                    'posts_per_page' => -1,
                    'orderby'        => 'date',
                    'order'          => 'DESC'
                );
                $products = new WP_Query( $args );
                
                if ( $products->have_posts() ) {
                    while ( $products->have_posts() ) {
                        $products->the_post();
                        $product = wc_get_product( get_the_ID() );
                        ?>
                        <div class="product-card">
                            <div style="flex-grow: 1;">
                                <?php 
                                $img_url = get_post_meta($product->get_id(), '_product_image_url', true);
                                if ($img_url) { 
                                ?>
                                    <div style="overflow: hidden; border-radius: 8px; margin-bottom: 10px; background: #f0f0f0;">
                                        <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title(); ?>" style="width: 100%; height: 220px; object-fit: cover; display: block;">
                                    </div>
                                <?php } else if (has_post_thumbnail()) { ?>
                                    <div style="overflow: hidden; border-radius: 8px; margin-bottom: 10px;">
                                        <?php the_post_thumbnail( 'medium' ); ?>
                                    </div>
                                <?php } ?>
                                
                                <h4 style="margin: 15px 0; font-weight: bold; color: #333;">
                                    <?php the_title(); ?>
                                </h4>
                                
                                <p style="color: #666; margin-bottom: 10px;">
                                    <?php 
                                    $desc = wp_trim_words( $product->get_short_description(), 12 );
                                    echo !empty($desc) ? $desc : wp_trim_words( $product->get_description(), 12 );
                                    ?>
                                </p>
                                
                                <div style="margin: 15px 0;">
                                    <span style="color: #007cba; font-weight: bold; display: block; font-size: 20px;">
                                        <?php echo $product->get_price_html(); ?>
                                    </span>
                                </div>
                            </div>
                            
                            <div style="margin-top: 15px;">
                                <?php
                                if ( $product->is_in_stock() ) {
                                    ?>
                                    <a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" 
                                       data-quantity="1" 
                                       class="product_type_<?php echo esc_attr( $product->get_type() ); ?>" 
                                       data-product_id="<?php echo esc_attr( $product->get_id() ); ?>" 
                                       data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>" 
                                       style="display: block; width: 100%; padding: 12px; background: #007cba; color: white; text-align: center; text-decoration: none; font-weight: bold; border-radius: 6px; border: none;">
                                        <?php echo esc_html( $product->add_to_cart_text() ); ?>
                                    </a>
                                    <?php
                                } else {
                                    echo '<button style="display: block; width: 100%; padding: 12px; background: #ccc; color: #333; text-align: center; font-weight: bold; border-radius: 6px; border: none; cursor: not-allowed;">Out of Stock</button>';
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                    wp_reset_postdata();
                } else {
                    echo '<p style="text-align: center; grid-column: 1/-1; font-size: 18px;">No products found. Please add products from WordPress admin.</p>';
                }
            ?>
        </div>
    </section>

    <section style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 40px; border-radius: 10px; margin-bottom: 50px;">
        <h3 style="font-size: 28px; margin-bottom: 25px; text-align: center;">✨ Why Choose Shop4U?</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 25px;">
            <div style="text-align: center;">
                <div style="font-size: 40px; margin-bottom: 10px;">🎯</div>
                <h4 style="margin-bottom: 10px; font-size: 18px;">Premium Quality</h4>
                <p style="font-size: 15px;">Only authentic, high-quality tech products</p>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 40px; margin-bottom: 10px;">💰</div>
                <h4 style="margin-bottom: 10px; font-size: 18px;">Best Prices</h4>
                <p style="font-size: 15px;">Competitive pricing with special discounts</p>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 40px; margin-bottom: 10px;">🚀</div>
                <h4 style="margin-bottom: 10px; font-size: 18px;">Fast Delivery</h4>
                <p style="font-size: 15px;">Quick and secure shipping worldwide</p>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 40px; margin-bottom: 10px;">💬</div>
                <h4 style="margin-bottom: 10px; font-size: 18px;">24/7 Support</h4>
                <p style="font-size: 15px;">Live chat and customer support always available</p>
            </div>
        </div>
    </section>

    <section style="background: #fff; padding: 40px; border: 2px solid #007cba; border-radius: 10px; text-align: center;">
        <h3 style="font-size: 28px; margin-bottom: 15px; color: #333;">🎁 Special Offer!</h3>
        <p style="font-size: 16px; color: #666; margin-bottom: 20px;">Subscribe to our newsletter for exclusive deals and 10% off your first order</p>
        <form method="post" style="display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;">
            <input type="email" placeholder="Enter your email" required style="padding: 12px; min-width: 250px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
            <button type="submit" class="button" style="background: #007cba !important;">Subscribe Now</button>
        </form>
    </section>
</main>

<?php get_footer(); ?>
