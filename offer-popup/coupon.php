<?php

function get_all_coupons_details() {
    $coupons = get_posts(array(
        'post_type' => 'shop_coupon',
        'posts_per_page' => -1
    ));

    foreach ($coupons as $coupon) {
        $coupon_post = get_post($coupon);
        $coupon_code = $coupon_post->post_title;
        $coupon_discount_type = get_post_meta($coupon, 'discount_type', true);
        $coupon_amount = get_post_meta($coupon, 'coupon_amount', true);
        $coupon_usage_limit = get_post_meta($coupon, 'usage_limit', true);

        echo 'Coupon Code: ' . $coupon_code . '<br>';
        echo 'Discount Type: ' . $coupon_discount_type . '<br>';
        echo 'Amount: ' . $coupon_amount . '<br>';
        echo 'Usage Limit: ' . $coupon_usage_limit . '<br>';
    }
}

//get_all_coupons_details();

?>