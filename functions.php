<?php
/**
 * Fireworks Crazy Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Fireworks Crazy
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_FIREWORKS_CRAZY_VERSION', '1.0.0' );

/**
 * SEOPress - disable shortcodes in sitemaps
 */
add_filter('seopress_sitemaps_single_shortcodes', '__return_false');

/**
 * Enqueue styles
 */
function child_enqueue_styles() {
wp_enqueue_style( 'fireworks-crazy-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_FIREWORKS_CRAZY_VERSION, 'all' );

wp_enqueue_style( 'fireworks-crazy-theme-css-custom', get_stylesheet_directory_uri() . '/assets/css/minified/style.min.css', false, CHILD_THEME_FIREWORKS_CRAZY_VERSION, 'all' );
}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

//Reviews Page Shortcode
function reviews_full_page() {
echo '<script src="https://widget.reviews.co.uk/badge-ribbon/dist.js"></script>
<div id="badge-ribbon"></div>
<script>
	reviewsBadgeRibbon("badge-ribbon", {
		store: "fireworks-crazy",
		mono: "",
		size: "medium",
	});
</script>
<script src="https://widget.reviews.co.uk/rich-snippet-reviews-widgets/dist.js" type="text/javascript"></script>
<div id="compound-widget"></div>

<script>
        richSnippetReviewsWidgets("compound-widget", {
            store: "fireworks-crazy",
            primaryClr: "#EF7F23",
            neutralClr: "#333333",
            reviewTextClr: "#333333",
            widgetName: "compound",
            layout: "fullWidth",
            numReviews: 40,
            contentMode: "company;third-party",
            compound: "google local"
        });
</script>';}

add_shortcode("reviews_full_page", "reviews_full_page");

//reviews carousel shortcode
function reviews_carousel() {
    echo '<script src="https://widget.reviews.co.uk/rich-snippet-reviews-widgets/dist.js"></script>
<div id="carousel-inline-widget-810" style="width:100%;max-width:100%;margin:0 auto;"></div>
<script>
richSnippetReviewsWidgets("carousel-inline-widget-810", {
    store: "fireworks-crazy",
    widgetName: "carousel-inline",
    primaryClr: "#EF7F23",
    neutralClr: "#f4f4f4",
    reviewTextClr: "#2f2f2f",
    ratingTextClr: "#2f2f2f",
    layout: "fullWidth",
    numReviews: 21
});
</script>';
}

add_shortcode("reviews_carousel", "reviews_carousel");

//Shop sidebar reviews shortcode
function sidebar_reviews() {
    echo '<script src="https://widget.reviews.co.uk/badge/dist.js"></script>
<div id="badge-250" style="max-width:100%;"></div>
            <script>
            reviewsBadge("badge-250",{
              store: "fireworks-crazy",
              primaryClr: "#EF7F23",
              neutralClr: "#f4f4f4",
              starsClr: "#fff",
              textClr: "#fff"
            });
            </script>';
}
add_shortcode("sidebar_reviews", "sidebar_reviews");

function showroom_360_script() {
	$post_id = get_the_ID();
	if ($post_id = 8287) {
    echo '<script async src="https://theta360.com/widgets.js" charset="utf-8"></script>';
	}
}
add_action( 'wp_footer', 'showroom_360_script' );

//rename add to cart text
add_filter( 'woocommerce_product_add_to_cart_text', 'woo_custom_cart_button_text' );                   
//add_filter( 'woocommerce_product_search_field_product_add_to_cart_html', 'woo_custom_cart_button_text' );

function woo_custom_cart_button_text( $post_id ) {

        return '';

}
/*Set Wordpress password Security level */
add_filter( 'woocommerce_min_password_strength', 'reduce_min_strength_password_requirement' );
function reduce_min_strength_password_requirement( $strength ) {
    // 3 => Strong (default) | 2 => Medium | 1 => Weak | 0 => Very Weak (anything).
    return 2; 
}

/**
 * Adjust the Loqate mapping to use the `Province` rather than `ProvinceCode` for
 * country lookups that do not use a ProvinceCode (e.g. UK)
 *
 * @param array $params array of mappings.
 */

function sv_wc_address_validation_addressy_addresses( $params ) {
	foreach ( $params as $param_type => $settings ) {
		$params[ $param_type ] = sv_lookup_province_code( $settings );
	}
	return $params;
}
add_filter( 'wc_address_validation_addressy_addresses', 'sv_wc_address_validation_addressy_addresses', 10, 1 );
/**
 * Helper method to lookup `ProvinceCode` to adjust it to use `Province` instead
 *
 * @param array $settings the column mappings for the parameter type.
 */
function sv_lookup_province_code( $settings ) {
	$new_settings = array();
	foreach ( $settings as $setting ) {
		if ( 'ProvinceCode' === $setting['field'] ) {
			$setting['field'] = 'Province';
		}
		$new_settings[] = $setting;
	}
	return $new_settings;
}

/*Custom Function for forgot password*/
function wc_custom_lost_password_form( $atts ) {
    return wc_get_template( 'myaccount/form-lost-password.php', array( 'form' => 'lost_password' ) );
}
add_shortcode( 'lost_password_form', 'wc_custom_lost_password_form' );

/* Set London Addresses to London County
function woocommerce_checkout_london_fix( $rates, $package, $countries ) {
if ( is_admin() && ! defined( 'DOING_AJAX' ) ) 
return;
$countyField = (WC()->customer->get_billing_city());
$london = "London";
if (strcasecmp($countyField, $london)== 0) {
	$countries['GB']['state']['default'] = 'LO';
	return $countries;
}
	
add_filter( 'woocommerce_get_country_locale', 'woocommerce_checkout_london_fix', 10, 1 );*/

/* Replace field label for Phone on Checkout */
add_filter( 'woocommerce_billing_fields', 'checkout_fields_mod', 10, 1 );
function checkout_fields_mod( $address_fields ) {
	$address_fields['billing_phone']['label'] = 'Mobile';
	//$address_fields['billing_state']['type'] = 'textarea';
	return $address_fields;
}
add_filter( 'woocommerce_get_country_locale', 'mp_change_locale_field_defaults');
 
function mp_change_locale_field_defaults($countries) {
    $countries['GB']['state']['required'] = true;
	$countries['GB']['state']['label'] = 'County (please select)';
	//$countries['GB']['state']['type'] = 'textarea';
		return $countries;
}
/* Percentage Discount Calc */
  
function bbloomer_show_sale_percentage_loop() {
    global $product;
    if ( ! $product->is_on_sale() ) return;
    if ( $product->is_type( 'simple' ) ) {
        $max_percentage = ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100;
    } elseif ( $product->is_type( 'variable' ) ) {
        $max_percentage = 0;
        foreach ( $product->get_children() as $child_id ) {
            $variation = wc_get_product( $child_id );
            $price = $variation->get_regular_price();
            $sale = $variation->get_sale_price();
            if ( $price != 0 && ! empty( $sale ) ) $percentage = ( $price - $sale ) / $price * 100;
            if ( $percentage > $max_percentage ) {
                $max_percentage = $percentage;
            }
        }
    }
    if ( $max_percentage > 0 ) echo "<div class='sale-perc'>-" . round($max_percentage) . "% off</div>"; 
}

add_shortcode('percentage_discount', 'bbloomer_show_sale_percentage_loop');

/* Shop & Single Prices */
function shop_and_single_prices() {
	global $product;
	$regPrice = $product->get_regular_price();
	$discPrice = $product->get_sale_price();
	if ( !$product->is_on_sale() ) {
		echo '<div class="isPrice soloPrice">£'.$regPrice.'</div>';
	}
	
	else {
		echo '<div class="priceWithDiscount"><em class="wasPrice">'.$regPrice.'</em> <em class="sale-perc">'. round(($regPrice - $discPrice) / $regPrice *100) . '% off</em><a href="#" class="isPrice">£'.$discPrice.'</a></div>';
	}
}

add_action('astra_woo_shop_title_after', 'shop_and_single_prices');
add_shortcode('customPrice', 'shop_and_single_prices');

// Display Product Description on List
function product_description_on_list() {
	global $product;
	$desc = $product->get_short_description();
    if (!empty($desc)) {
	echo '<p class="listDescription">'.$desc.' <a href="'.$product->get_permalink().'" class="listMoreInfoBtn"><b>More Info</b></a></p>';}
    else {echo '<p class="listDescription">'.$desc.'</p>';}
}

add_action('astra_woo_shop_title_after', 'product_description_on_list');

/* Shop Icon button for Shop (Grid View)
function cart_icon_button_shop_grid() {

	global $product;
	$product_id = $product->get_id() ;
	$url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
	$escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
	$result = explode('/?',$escaped_url);
	$useful_url = $result[0];
	echo '<a href="'.$useful_url.'/?add-to-cart=' .$product_id.'" data_quantity="1" class="add_to_cart_grid button product_type_simple" data-product_id="'.$product_id.'" rel="nofollow"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>';
}
	
add_action ('astra_woo_shop_add_to_cart_after', 'cart_icon_button_shop_grid');
*/

/* Hide stars when no reviews */

function no_stars_if_no_reviews() {
	global $product;
	$average = $product->get_average_rating() ;
    if($average > 3) {
		echo ('<div class="star-rating"><span style="width:'.( ( $average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.__( 'out of 5', 'woocommerce' ).'</span></div>');
	}
	else { return; }
}

add_action ( 'astra_woo_shop_title_after', 'no_stars_if_no_reviews');

/* List View Add to Wishlist Btn 
function add_to_wishlist_on_list() {
    global $product;
    echo '<a href="javascript:void(0)" class="tinvwl_add_to_wishlist_button tinvwl-icon-heart wishlistBtn tinvwl-position-shortcode" data-tinv-wl-list="[{&quot;ID&quot;:151,&quot;title&quot;:&quot;Default wishlist&quot;,&quot;url&quot;:&quot;https:\/\/fireworkscrazy.co.uk\/wishlist\/A1A86E\/&quot;,&quot;in&quot;:false},{&quot;ID&quot;:288,&quot;title&quot;:&quot;Testing&quot;,&quot;url&quot;:&quot;https:\/\/fireworkscrazy.co.uk\/wishlist\/9F2839\/&quot;,&quot;in&quot;:false}]" data-tinv-wl-product="'.$product->get_id().'" data-tinv-wl-productvariation="0" data-tinv-wl-producttype="simple" data-tinv-wl-action="addto" rel="nofollow"><span class="tinvwl_add_to_wishlist-text">Add to Wishlist</span></a>';
}

add_action('astra_woo_shop_add_to_cart_after', 'add_to_wishlist_on_list');

/* More Info Button */
function more_information() {
global $product;
if ($product){
$url = esc_url($product->get_permalink() );
echo '<a rel="nofollow" href="' .$url .'" class="shopMoreInfoBtn">More Info</a>';
echo '<a rel="nofollow" href="' .$url .'" class="shopMoreInfoBtnGrid"><i class="fa fa-info-circle" aria-hidden="true"></i>
</a>';
}
}
add_action('astra_woo_shop_add_to_cart_after','more_information');

/* Watch Video Button */
function shop_watch_product_video() {
	global $product;
	/*$featured_info = $product->get_meta( '_ywcfav_featured_content', true );
	$url = esc_url($product->get_permalink() );
	if( !empty( $featured_info ) ){
   $video = YITH_Featured_Video_Manager()->find_featured_video( $product, $featured_info['id'] );
		if ( 'url' == $video['type'] ) {   
			$video_url = $video['content'];*/
    $video_url = get_post_meta( get_the_id(), 'video_url', true );
            if (!empty($video_url)) {
			echo '<a data-video-url="'.$video_url.'" class="shopProductVideoBtn button" onclick="videoModalJS(this);" >Watch Video</a>';
			echo '<a data-video-url="'.$video_url.'" class="shopProductVideoBtnGrid" onclick="videoModalJS(this);"><i class="fa fa-youtube-play" aria-hidden="true"></i>
</a>';}
			/*preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $video_url, $matches);
			$video_id = $matches[1];
			echo '<a href="#">'.$video_id.'</a>';

			echo '<div id="myModal" class="modal"><!-- Modal content --><div class="modal-content"><span class="close">&times;</span><iframe width="800px" height="450px" src="https://www.youtube.com/embed/'.$video_id.'"></iframe></div></div>';*/
    }

add_action('astra_woo_shop_add_to_cart_after','shop_watch_product_video');
add_action( 'uael_woo_products_add_to_cart_before', 'shop_watch_product_video', 10, 2 );

function single_product_video_url() {
    global $product;
    $single_video_url = get_post_meta( get_the_id(), 'video_url', true );
    echo '<a id="single_video_url" data-video-url="'.$single_video_url.'" onclick="videoModalJS(this);" ></a>
    <div id="shopVideoModal" class="mfp-hide embed-responsive embed-responsive-21by9">
        <iframe class="embed-responsive-item" width="854" height="480" src="" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
      </div>';
}

add_shortcode ('single_product_video_url', 'single_product_video_url');

/* Tiered Shipping depending on Checkout total price */
 
add_filter( 'woocommerce_package_rates', 'woocommerce_checkout_tiered_shipping', 10, 2 );
   
function woocommerce_checkout_tiered_shipping( $rates, $package ) {
   
    $threshold = 60.00;
	$threshold2 = 150.00;
	$threshold3 = 249.00;
    
    if ( WC()->cart->subtotal < $threshold ) {
		unset( $rates['flat_rate:38']);
		unset( $rates['flat_rate:47']);
		unset( $rates['flat_rate:48']);
		unset( $rates['flat_rate:50']);
		unset( $rates['flat_rate:51']);
		unset( $rates['flat_rate:54']);
		unset( $rates['flat_rate:43']);
		unset( $rates['flat_rate:53']);
        //highlands
        unset ( $rates['flat_rate:59']);
        unset ( $rates['flat_rate:62']);
        unset ( $rates['flat_rate:63']);
        unset ( $rates['flat_rate:65']);
        unset ( $rates['flat_rate:66']);
        unset ( $rates['flat_rate:68']);
        unset ( $rates['flat_rate:69']);
        unset ( $rates['flat_rate:71']);
    } 
	
	if ( (WC()->cart->subtotal > $threshold) and (WC()->cart->subtotal < $threshold3) ) {
		unset( $rates['flat_rate:37']);
		unset( $rates['flat_rate:46']);
		unset( $rates['flat_rate:52']);
		unset( $rates['flat_rate:49']);
		unset( $rates['flat_rate:48']);
		unset( $rates['flat_rate:51']);
		unset( $rates['flat_rate:54']);
		unset( $rates['flat_rate:42']);
        //highlands
        unset ( $rates['flat_rate:58']);
        unset ( $rates['flat_rate:61']);
        unset ( $rates['flat_rate:63']);
        unset ( $rates['flat_rate:64']);
        unset ( $rates['flat_rate:66']);
        unset ( $rates['flat_rate:67']);
        unset ( $rates['flat_rate:69']);
        unset ( $rates['flat_rate:70']);
	}
	/*
	if ((WC()->cart->subtotal > $threshold2) and (WC()->cart->subtotal < $threshold3) ) {
		unset( $rates['flat_rate:6']);
	}*/
	if (WC()->cart->subtotal > $threshold3) {		
		unset( $rates['flat_rate:37']);
		unset( $rates['flat_rate:46']);
		unset( $rates['flat_rate:38']);
		unset( $rates['flat_rate:47']);
		unset( $rates['flat_rate:49']);
		unset( $rates['flat_rate:50']);
		unset( $rates['flat_rate:52']);
		unset( $rates['flat_rate:53']);
		unset( $rates['flat_rate:42']);
		unset( $rates['flat_rate:43']);
        //highlands
        unset ( $rates['flat_rate:58']);
        unset ( $rates['flat_rate:59']);
        unset ( $rates['flat_rate:61']);
        unset ( $rates['flat_rate:62']);
        unset ( $rates['flat_rate:64']);
        unset ( $rates['flat_rate:65']);
        unset ( $rates['flat_rate:67']);
        unset ( $rates['flat_rate:68']);
        unset ( $rates['flat_rate:70']);
        unset ( $rates['flat_rate:71']);
	}
    return $rates;
   
}


/**
 * Hide shipping rates when free shipping is available, but keep "Local pickup" 
 * Updated to support WooCommerce 2.6 Shipping Zones 
 

function hide_shipping_when_free_is_available( $rates, $package ) {
	$new_rates = array();
	foreach ( $rates as $rate_id => $rate ) {
		// Only modify rates if free_shipping is present.
		if ( 'free_shipping' === $rate->method_id ) {
			$new_rates[ $rate_id ] = $rate;
			break;
		}
	}

	if ( ! empty( $new_rates ) ) {
		//Save local pickup if it's present.
		foreach ( $rates as $rate_id => $rate ) {
			if ('local_pickup' === $rate->method_id ) {
				$new_rates[ $rate_id ] = $rate;
				break;
			}
		}
		return $new_rates;
	}

	return $rates;
}

add_filter( 'woocommerce_package_rates', 'hide_shipping_when_free_is_available', 10, 2 );

 /* Add a standard value surcharge to Highland transactions in cart / checkout */

add_action( 'woocommerce_cart_calculate_fees','wc_add_surcharge' ); 
function wc_add_surcharge( $available_gateways ) {
global $woocommerce; 

if ( is_admin() && ! defined( 'DOING_AJAX' ) ) 
return;

$shipping_packages =  WC()->cart->get_shipping_packages();

// Get the WC_Shipping_Zones instance object for the first package
$shipping_zone = wc_get_shipping_zone( reset( $shipping_packages ) );

$zone_id   = $shipping_zone->get_id(); // Get the zone ID
$zone_name = $shipping_zone->get_zone_name(); // Get the zone name
$chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
$chosen_shipping = $chosen_methods[0];
    
//var_dump($zone_name);
    
if ($zone_name == "UK Post Scottish Highlands & Islands - Zone 2") {
    $woocommerce->cart->add_fee( 'Surcharge', 18.00, false, 'standard' );
}
    
if (($zone_name == "UK Post Scottish Highlands & Islands - Zone 2") and ('local_pickup' === $chosen_shipping )) {
    $woocommerce->cart->add_fee( 'Surcharge', 0.00, false, 'standard' );
}

}

function wcfad_script() {
 ?>
 <script>
 jQuery(document).ready(function($){
 $('body').on('change','.checkout #billing_address_1',function(){
 $('body').trigger('update_checkout');
 });
 });
 </script>
<?php
}
add_action( 'woocommerce_after_checkout_form', 'wcfad_script' );

/* Change button text for Backorders */
add_filter( 'woocommerce_product_single_add_to_cart_text', 'wc_ninja_change_backorder_button', 10, 2 );
function wc_ninja_change_backorder_button( $text, $product ){
	if ( $product->is_on_backorder( 1 ) ) {
		$text = __( 'Pre-Order', 'woocommerce' );
	}
	return $text;
}

function change_loop_text_if_product_is_backordered( $text ) {
	global $product;
	if ( $product->is_on_backorder( 1 ) ) {
		$text = __( 'Pre-Order', 'woocommerce' );
	}
	return $text;
}
add_filter( 'woocommerce_product_add_to_cart_text', 'change_loop_text_if_product_is_backordered' );

/* Shop Sidebar Filter */
add_shortcode('clear_shop_filters', 'add_clear_filters');
function add_clear_filters() {
    $filterreset = $_SERVER['REQUEST_URI'];
    $filterreset = strtok($filterreset, '?');
    echo'<a href="'.$filterreset.'" class="clearFiltersBtn button">Clear Filters</a>';
}

/* Single Prev/Next Buttons */
add_shortcode( 'single_product_navigation', 'single_product_navigation' );
function single_product_navigation(){
echo '<div class="prev_next_buttons">';
   // 'product_cat' will make sure to return next/prev from current category
        $previous = next_post_link('%link', '&larr; PREVIOUS', TRUE, ' ', 'product_cat');
   $next = previous_post_link('%link', 'NEXT &rarr;', TRUE, ' ', 'product_cat');
   echo $previous;
   echo $next;
echo '</div>';
}

/* Checkout Hooks */
add_action('woocommerce_before_order_notes','message_above_delivery_notes');
function message_above_delivery_notes() {
	echo '<p>Please enter the latest date you require your fireworks for and any other comments below. N.B. During October / November its not possible to specify exact delivery dates.</p>';
}

	
/* Checkout Hooks */
add_action('woocommerce_review_order_before_payment','deliveryinfo_link');
function deliveryinfo_link() {
	echo '<div class="delivery-box"><a href="#" class="delivery-info"><i class="fas fa-info-circle"></i> More details on delivery can be <u>found here</u></a></div>';
} 
	
add_filter( 'loop_shop_per_page', 'bbloomer_redefine_products_per_page', 9999 );
 
function bbloomer_redefine_products_per_page( $per_page ) {
  $per_page = 21;
  return $per_page;
}

// Optional product quantity on loop
add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );
add_action('woocommerce_before_shop_loop', 'new_loop_shop_per_page', 1);
add_action( 'woocommerce_product_query', 'mywoocommerce_products_per_page', 1, 50 );



    function new_loop_shop_per_page( $cols ) {

        session_start();
        $default = "24";
        $cols = "24";
        $submittedvalue = "24";
        $value0 = "24";
        $value1 = "36";
        $value2 = "54";
        $value3 = "60";

        if (isset($_POST["ProductsPerPage"])) {

         $_SESSION['ProductsPerPage'] = $_POST['ProductsPerPage'];
         $submittedvalue = $_SESSION['ProductsPerPage'];

        }


      global $submittedvalue;
      $cols = $submittedValue;
      return $cols;

      }


function mywoocommerce_products_per_page( $query ) {
    if ( $query->is_main_query() ) {
         session_start();
         global $submittedvalue;
         //$_SESSION['ProductsPerPage'] = $_POST['ProductsPerPage'];
         $submittedvalue = $_SESSION['ProductsPerPage'];
         $query->set( 'posts_per_page', $submittedvalue );

    }
}

add_filter( 'redirect_canonical', 'custom_disable_redirect_canonical' );
function custom_disable_redirect_canonical( $redirect_url ) {
    if ( is_paged() && is_singular() ) $redirect_url = false; 
    return $redirect_url; 
}


//add hook to redirect the user back to the elementor login page if the login failed
add_action( 'wp_login_failed', 'elementor_form_login_fail' );
function elementor_form_login_fail( $username ) {
    $referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?
    // if there's a valid referrer, and it's not the default log-in screen
    if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
        //redirect back to the referrer page, appending the login=failed parameter and removing any previous query strings
        //maybe could be smarter here and parse/rebuild the query strings from the referrer if they are important
        wp_redirect(preg_replace('/\?.*/', '', $referrer) . '/?login=failed' );
        exit;
    }
}

// icons for shop

function hmk_crazy_icons_func(){
    global $product;
    $attributes = $product->get_attributes();
    if ( ! $attributes ) {
        return;
    }

    $display_result = '';

    foreach ( $attributes as $attribute ) {


        if ( $attribute->get_variation() ) {
            continue;
        }
        $name = $attribute->get_name();
        if ( $attribute->is_taxonomy() ) {

            $terms = wp_get_post_terms( $product->get_id(), $name, 'all' );

            $cwtax = $terms[0]->taxonomy;

            $cw_object_taxonomy = get_taxonomy($cwtax);

            if ( isset ($cw_object_taxonomy->labels->singular_name) ) {
                $tax_label = $cw_object_taxonomy->labels->singular_name;
            } elseif ( isset( $cw_object_taxonomy->label ) ) {
                $tax_label = $cw_object_taxonomy->label;
                if ( 0 === strpos( $tax_label, 'Product ' ) ) {
                    $tax_label = substr( $tax_label, 8 );
                }
            }
            //$display_result .= $tax_label . ' ';
            $tax_terms = array();
            foreach ( $terms as $term ) {
                $single_term = esc_html( $term->name );
                array_push( $tax_terms, $single_term );
            }

          $hmk_val = implode(', ', $tax_terms);

          if($name == 'pa_noise-level') {
              $name .= '-'.$hmk_val;
          }

						if(1 === preg_match('~[0-9]~', $hmk_val)){
					  	$hmk_class = sanitize_title($hmk_val)." ".$name." value-inside";
						}else{
							$hmk_class = sanitize_title($hmk_val)." ".$name." no-value-inside";;
						}

            $display_result .= '<li class="'.$hmk_class.'"><div class="title">'.$tax_label.'</div><div class="icon"><span class="icon-value">'. implode(', ', $tax_terms) .  '</span></div></li>';

        } else {
            $display_result .= $name . ':: ';
            $display_result .= '<li class="'.$name.'">'.esc_html( implode( ', ', $attribute->get_options() ) ) . '</li>';
        }
    }
    echo '<ul class="hmk-crazy-icons">'.$display_result.'</ul>';
}

// Add Shortcode
add_shortcode( 'crazy-attribute-icons', 'hmk_crazy_icons_func' );

// postcode order
function wc_address_validation_move_postcode_lookup() {
	wc_enqueue_js( '
		( function() {
			var $billingLookup = $( "#wc_address_validation_postcode_lookup_billing" );
			var $shippingLookup = $( "#wc_address_validation_postcode_lookup_shipping" );
			$( "div.woocommerce-billing-fields").find( "h3" ).after( $billingLookup );
			$( "div.woocommerce-shipping-fields").find( "h3" ).after( $shippingLookup );
		} )();
	' );
}
add_action( 'wp', 'wc_address_validation_move_postcode_lookup', 1000 );


//Admin Theme

function edit_wp_menu(){

	//----------------------------------
	// Moving Admin Menu Items
	//---------------------------------
	function change_menu_order ($menu_order){
		return array(
		'index.php',
		'themes.php',
		'edit.php',
		'edit.php?post_type=page',
		'upload.php'
		);
	}
add_filter ('custom_menu_order','__return_true');
add_filter('menu_order','change_menu_order');	

	//----------------------------------
	// Renaming Admin Menu Items
	//---------------------------------
	global $menu;
	global $submenu;

	//print_r($submenu);
	
	$menu[5][0] = 'Blog Posts';
	$submenu['edit.php'][5][0] = 'All Blog Posts';
	$submenu['edit.php'][10][0] = 'Add A Blog Post';
	$submenu['edit.php'][15][0] = 'Blog Categories';
	$submenu['edit.php'][16][0] = 'Blog Tags';
	$menu[20][0] = 'Web Pages';	
}
function change_post_labels(){
	global $wp_post_types;
	//print_r($wp_post_types);
	//get the current post labels
	$articleLabels = $wp_post_types['post']->labels;
	$articleLabels->name ='Blog Posts';
	$articleLabels->singular_name ='Blog Post';
	$articleLabels->add_new ='Add Blog Post';
	$articleLabels->edit_item ='Edit Blog Post';
	$articleLabels->new_item ='New Blog Post';
	$articleLabels->view_item ='View Blog Post';
	$articleLabels->view_items ='View Blog Posts';
	$articleLabels->search_items ='Search Posts';
	$articleLabels->not_found ='No blog posts found';
	$articleLabels->not_found_in_trash ='No blog posts found in Trash';
	$articleLabels->featured_image ='Blog Post Image';
	$articleLabels->set_featured_image ='Set blog post image';
	$articleLabels->remove_featured_image ='Remove blog post image';
	$articleLabels->use_featured_image ='Use as featured post image';
	
}

add_action('admin_menu', 'edit_wp_menu');
add_action('init', 'change_post_labels');

	//----------------------------------
	// Dashboard   https://codex.wordpress.org/Function_Reference/remove_meta_box
	//---------------------------------
function customize_dashboard()
{
	remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' ); 
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );   // Right Now
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );  // Quick Press
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );  // Recent Drafts
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );   // WordPress blog
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );   // Other WordPress News
	// Remove Welcome Panel
	remove_action ('welcome_panel','wp_welcome_panel');
	
}
add_action('wp_dashboard_setup','Customize_dashboard');

//===============================================================
// Change Howdy Text
//===============================================================
add_action( 'admin_bar_menu', 'wp_admin_bar_my_custom_account_menu', 11 );

function wp_admin_bar_my_custom_account_menu( $wp_admin_bar ) {
$user_id = get_current_user_id();
$current_user = wp_get_current_user();
$profile_url = get_edit_profile_url( $user_id );

if ( 0 != $user_id ) {
/* Add the "My Account" menu */
$avatar = get_avatar( $user_id, 28 );
$howdy = sprintf( __('Welcome, %1$s'), $current_user->display_name );
$class = empty( $avatar ) ? '' : 'with-avatar';

$wp_admin_bar->add_menu( array(
'id' => 'my-account',
'parent' => 'top-secondary',
'title' => $howdy . $avatar,
'href' => $profile_url,
'meta' => array(
'class' => $class,
),
) );

}
}

//===============================================================
// THE TABLE COLUMNS
//===============================================================
function customize_posts_listing_cols( $columns ) {
	 //print_r($columns);
	
	unset( $columns[ 'tags' ] );
	unset( $columns[ 'comments' ] );
	unset( $columns[ 'categories' ] );	

	return $columns;
}

function customize_pages_listing_cols( $columns ) {
	unset( $columns[ 'comments' ] );
	return $columns;
}

add_action( 'manage_posts_columns', 'customize_posts_listing_cols' );
add_action( 'manage_pages_columns', 'customize_pages_listing_cols' );



//===============================================================
// SOME SMALLER CUSTOMIZATIONS
//===============================================================

//-----------------------------------------------
// Change the footer text
//-----------------------------------------------
function change_admin_footer() {
	echo 'Built with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://designboxmedia.co.uk">Design Box Media</a>';
}

add_filter( 'admin_footer_text', 'change_admin_footer' );

//-----------------------------------------------
// Remove the WP version from the footer
//-----------------------------------------------
function remove_footer_version() {
 remove_filter( 'update_footer', 'core_update_footer' );
}

add_action( 'admin_menu', 'remove_footer_version' );

//-----------------------------------------------
// Disable standard widgets
//-----------------------------------------------
function disable_wp_widgets() {
	unregister_widget( 'WP_Widget_Calendar' );
	unregister_widget( 'WP_Widget_Search' );
	unregister_widget( 'WP_Widget_Tag_Cloud' );
	unregister_widget( 'WP_Widget_RSS' );
	unregister_widget( 'WP_Widget_Meta' );
}

add_action( 'widgets_init', 'disable_wp_widgets' );

//-----------------------------------------------
// Customize the WYSIWYG Editor's CSS
//-----------------------------------------------
function add_editor_styles() {
	add_editor_style( 'editor-style.css' );
}

add_action( 'admin_init', 'add_editor_styles' );

//===============================================================
// THE LOGIN SCREEN
//===============================================================

//-----------------------------------------------
// Change the login form logo
//-----------------------------------------------
function change_login_logo() { ?>
	<style>
		.login h1 a {
			background-image: url('/wp-content/uploads/2018/07/logo-3-300x64.png') !important;
			padding-bottom: 10px ;
}
		
	</style>
<?php }

add_action( 'login_enqueue_scripts', 'change_login_logo' );

//-----------------------------------------------
// Change the login logo URL and title
//-----------------------------------------------
function change_login_logo_url() {
	return home_url();
}

function change_login_logo_url_title() {
	return "Design Box Media";
}

add_filter( 'login_headerurl', 'change_login_logo_url' );
add_filter( 'login_headertitle', 'change_login_logo_url_title' );

//-----------------------------------------------
// Style the login page
//-----------------------------------------------
function change_login_stylesheet() {
	wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/custom-login/custom-login.css' );
	wp_enqueue_script( 'custom-login', get_stylesheet_directory_uri() . '/custom-login/custom-login.js' );
}

add_action( 'login_enqueue_scripts', 'change_login_stylesheet' );

//-----------------------------------------------
// Disable the password reset feature
//-----------------------------------------------
//function disable_reset_pwd() {
//	return false;
//}
//
//add_filter( 'allow_password_reset', 'disable_reset_pwd' );

//-----------------------------------------------
// Remove error shake
//-----------------------------------------------
//function remove_shake() {
//	remove_action( 'login_head', 'wp_shake_js', 12 );
//}

//add_action( 'login_head', 'remove_shake' );



//===============================================================
// THE ADMIN BAR
//===============================================================

//-----------------------------------------------
// Remove links
//-----------------------------------------------
function remove_admin_bar_links() {
	global $wp_admin_bar;

	// print_r($wp_admin_bar);
	$wp_admin_bar->remove_menu( 'wp-logo' );
	$wp_admin_bar->remove_menu( 'new-content' );
	
}

add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

//-----------------------------------------------
// Customize the appearance
//-----------------------------------------------
function admin_bar_css() { ?>
	<style>
		/*#wpadminbar { background-color: #1E1E1E; }*/
	</style>
<?php }

add_action( 'admin_head', 'admin_bar_css' );



//===============================================================
// POSTS AND PAGES EDITING SCREENS
//===============================================================
function remove_meta_boxes() {
	remove_meta_box( 'commentsdiv', 'post', 'normal' );

	remove_meta_box( 'commentsdiv', 'page', 'normal' );
}

add_action( 'admin_init', 'remove_meta_boxes' );



//===============================================================
// CUSTOM ADMIN THEME
//===============================================================
function load_custom_admin_theme() {
	wp_enqueue_style( 'custom-admin-theme', get_stylesheet_directory_uri() . '/custom-admin-theme/custom-admin-theme.css' );
	wp_enqueue_script( 'custom-admin-theme', get_stylesheet_directory_uri() . '/custom-admin-theme/custom-admin-theme.js' );
}

add_action( 'admin_enqueue_scripts', 'load_custom_admin_theme' );

add_filter( 'ywfav_mute_video_on_autoplay', '__return_false' );

function change_backorder_message( $text, $product ){
    if ( $product->managing_stock() && $product->is_on_backorder( 1 ) ) {
        $text = __( "Pre-order for Oct'20 Delivery", 'pre-order-new-text' );
    }
    return $text;
}
add_filter( 'woocommerce_get_availability_text', 'change_backorder_message', 10, 2 );
?>
