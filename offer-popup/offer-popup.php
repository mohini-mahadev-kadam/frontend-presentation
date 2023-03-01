<?php
/*
Plugin Name: Offer-Popup Plugin
Plugin URI: https://www.mk.com/offerpopupplugin
Description: This is Offer-Popup Plugin
Author: Mohini Kadam
Author URI: https://www.mk.com
Version: 1.0
*/
 

include('admin-page.php'); 


function popup_with_random_offer_shortcode() {

  $coupons = get_posts(array(
    'post_type' => 'shop_coupon',
    'posts_per_page' => -1
  ));


    // Getting all the offers expiring today
    $todaysCoupons = array();
    $current_date = date('Y-m-d'); // get the current date
    foreach ($coupons as $coupon) {
      $coupon_code = $coupon->post_title; // get the coupon code
      $coupon_obj = new WC_Coupon($coupon_code); // create a new coupon object
      $expiration_date = $coupon_obj->get_date_expires('Y-m-d'); // get the coupon expiration date
      
      
      // check if the coupon is valid for one day
      $validity = new DateTime($expiration_date);
      //$validity->modify('0 day');
      $valid_until = $validity->format('Y-m-d');

      if ($valid_until == $current_date) {
          array_push($todaysCoupons, $coupon);
      }
    }

    if(!$todaysCoupons){
      return;
    }
    

    // selecting the random offer
    $random_offer = $todaysCoupons[array_rand($todaysCoupons)];




  $coupon_post = get_post($random_offer);
  $coupon_code = $coupon_post->post_title;
  
  $randomCoupon = new WC_Coupon($coupon_code);

  $surpriseBoxImg = plugin_dir_url( __FILE__ ). '/assets/images/surprise-box.png';
  $companyLogo = plugin_dir_url( __FILE__ ). '/assets/images/wisdmlogo.png';
   $popup_html = '';
   
   $popup_html.='
   <!-- The Modal -->
     <!-- Modal content -->
     <div id="myModal" class="modal-content modal">';
   
     
      $popupStyle = rand(1,2);

      if($popupStyle == 1){
          $popup_html .= '
            <div class="hero">
              <span class="close">&times;</span>
              <div class="box">
                <h2>Surprise Offer</h2>

                <div class="flip-card">
                  <div class="flip-card-inner">
                    <div class="flip-card-front">
                      <img src="'.$surpriseBoxImg.'" alt="Avatar" style="width:100%;height:100%;">
                    </div>
                    <div class="flip-card-back">
                      <h1>'.$randomCoupon->get_amount().'<span>'.($randomCoupon->get_discount_type()=="percent"?"%":$randomCoupon->get_discount_type()).' off </span></h1>
                      <b>This is very limited offer which is ending Today.</b>
                      <p> <span class="coupon_code_highlight">'.$coupon_code.'</span> Use this coupon code to avail the offer.
                    </div>
                  </div>
                </div>

                <button id="getOfferBtn">Get Offer</button>
                <a id="signUpBtnATag" class="wp-block-pages-list__item__link wp-block-navigation-item__content" href="http://figmatasktowptheme.local/my-account/" aria-current="page"><button id="signUpBtn">Sign Up</button></a></p>
                <img src="'.$companyLogo.'" alt="logo image">

                <div class="ribbon-wrap">
                  <div class="ribbon">Signup Offer</div>
                </div>
              </div>
            </div>
        ';
          
         
      }else if($popupStyle == 2){
        $popup_html .= '
            <div class="heroScratch">
              <span class="close">&times;</span>
              <div class="box">
                <h2>Surprise Offer</h2>

                <div class="scratch-container">
                  <div class="scratch-inner">
                    <div class="scratch-inner-main">
                      <h1>'.$randomCoupon->get_amount().'<span>'.($randomCoupon->get_discount_type()=="percent"?"%":$randomCoupon->get_discount_type()).' off</span></h1>
                      <b>This is very limited offer which is ending Today.</b>
                      <p> <span class="coupon_code_highlight">'.$coupon_code.'</span> Use this coupon code to avail the offer.</p>
                    </div>
                    <canvas id="overlayCanvas"></canvas>
                  </div>
                </div>

                <a class="wp-block-pages-list__item__link wp-block-navigation-item__content" href="http://figmatasktowptheme.local/my-account/" aria-current="page"><button id="signUpBtn" class="signUpBtnCls">Sign Up</button></a>
                <img src="'.$companyLogo.'" alt="logo image">
              </div>
            </div>
        ';

      }

      $popup_html .= '</div>';

      return $popup_html;
       
}
add_shortcode('popup_with_random_offer', 'popup_with_random_offer_shortcode');

//====================================================================================================



function my_plugin_enqueue_styles1() {
  wp_enqueue_style( 'offer-popup', plugins_url( 'offer-popup-style.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'my_plugin_enqueue_styles1' );



function my_enqueue_scripts1() {
  wp_enqueue_script( 'offer-popup2', plugin_dir_url( __FILE__ ) . 'offer-popup-script.js', array( 'jquery' ), '1.0', true );

  /****Spin wheel scripts */
  wp_enqueue_script( 'chart-js', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js', array(), '2.9.4', true );
  wp_enqueue_script( 'chartMin1', "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js", array(), '1.0', true );
  wp_enqueue_script( 'chartMin2', "https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.1.0/chartjs-plugin-datalabels.min.js", array(), '1.0', true );
  
}
add_action( 'wp_enqueue_scripts', 'my_enqueue_scripts1' );  


// This function will show the offer on successful signup
function show_offer_on_signup($user_login)
{

    $coupons = get_posts(array(
      'post_type' => 'shop_coupon',
      'posts_per_page' => -1
    ));


    // Retrieve user email from localStorage
    $randomSignupCouponData = "<script>localStorage.getItem('randomSignupCouponData');</script>";
    echo "<script>alert(".'$randomSignupCouponData'.");</script>";
    $todaysCoupons = array();
    $current_date = date('Y-m-d'); // get the current date
    foreach ($coupons as $coupon) {
      $coupon_code = $coupon->post_title; // get the coupon code
      $coupon_obj = new WC_Coupon($coupon_code); // create a new coupon object
      $expiration_date = $coupon_obj->get_date_expires('Y-m-d'); // get the coupon expiration date
      
      

      // check if the coupon is valid for one day
      $validity = new DateTime($expiration_date);
      //$validity->modify('0 day');
      $valid_until = $validity->format('Y-m-d');
      
    
      if ($valid_until == $current_date) {
          array_push($todaysCoupons, $coupon);

      }
    }

    if(!$todaysCoupons){
      return;
    }
    
    $random_offer = $todaysCoupons[array_rand($todaysCoupons)];
    
    
    $coupon_post = get_post($random_offer);
    $coupon_code = $coupon_post->post_title;
    
    $randomCoupon = new WC_Coupon($coupon_code);
  
      $popup_html = '<button id="myBtn">Today\'s offer</button>
  
      <!-- The Modal -->
  
      
        <!-- Modal content -->
        <div id="myModal" class="modal-content modal">';
          
        //  $popup_html .= $coupon_code.' '.$randomCoupon->get_amount().'  '.$randomCoupon->get_discount_type();
          
          $popup_html .= '
          <div class="hero">
          <span class="close">&times;</span>
          <div class="box">
            <h2>Today\'s offer for you </h2>
            <h1>'.$randomCoupon->get_amount().'<span>'.$randomCoupon->get_discount_type().'</span></h1>
            <b>This is very limited offer which is ending Today.</b>
            <p> <span class="coupon_code_highlight"><u>'.$coupon_code.'</u></span> Use this coupon code to avail the offer.</p>
            <button>SHOP NOW</button>
            
  
            <div class="ribbon-wrap">
              <div class="ribbon">TODAY\'S OFFER</div>
            </div>
          </div>
        </div>
        </div>
      
      ';
      
      echo $popup_html;
}

// action hook
add_action('user_register', 'show_offer_on_signup');



add_action( 'user_register', 'myplugin_registration_save', 10, 1 );

function myplugin_registration_save( $user_id ) {


        echo $user_id;

}

?>

