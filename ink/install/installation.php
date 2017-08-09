<?php 
 if ( ! defined( 'ABSPATH' ) ) exit;
add_action('plugins_loaded', 'wpsm_servicebox_tr');
function wpsm_servicebox_tr() {
	load_plugin_textdomain( wpshopmart_service_box_text_domain, FALSE, dirname( plugin_basename(__FILE__)).'/languages/' );
}

function wpsm_servicebox_front_script() {
	//font awesome css
	wp_enqueue_style('wpsm_servicebox-font-awesome-front', wpshopmart_service_box_directory_url.'assets/css/font-awesome/css/font-awesome.min.css');
	wp_enqueue_style('wpsm_servicebox_bootstrap-front', wpshopmart_service_box_directory_url.'assets/css/bootstrap-front.css');
}

add_action( 'wp_enqueue_scripts', 'wpsm_servicebox_front_script' );
add_filter( 'widget_text', 'do_shortcode');

add_action( 'admin_notices', 'wpsm_service_b_review' );
function wpsm_service_b_review() {

	// Verify that we can do a check for reviews.
	$review = get_option( 'wpsm_service_b_review' );
	$time	= time();
	$load	= false;
	if ( ! $review ) {
		$review = array(
			'time' 		=> $time,
			'dismissed' => false
		);
		add_option('wpsm_service_b_review', $review);
		//$load = true;
	} else {
		// Check if it has been dismissed or not.
		if ( (isset( $review['dismissed'] ) && ! $review['dismissed']) && (isset( $review['time'] ) && (($review['time'] + (DAY_IN_SECONDS * 2)) <= $time)) ) {
			$load = true;
		}
	}
	// If we cannot load, return early.
	if ( ! $load ) {
		return;
	}

	// We have a candidate! Output a review message.
	?>
	<div class="notice notice-info is-dismissible wpsm-service-b-review-notice">
		<div style="float:left;margin-right:10px;margin-bottom:5px;">
			<img style="width:100%;width: 150px;height: auto;" src="<?php echo wpshopmart_service_box_directory_url.'assets/images/icon-show.png'; ?>" />
		</div>
		<p style="font-size:18px;">'Hi! We saw you have been using <strong>Service Box Plugin</strong> for a few days and wanted to ask for your help to <strong>make the plugin better</strong>.We just need a minute of your time to rate the plugin. Thank you!</p>
		<p style="font-size:18px;"><strong><?php _e( '~ wpshopmart', '' ); ?></strong></p>
		<p style="font-size:19px;"> 
			<a style="color: #fff;background: #040404;padding: 5px 7px 4px 6px;border-radius: 4px;" href="https://wordpress.org/support/plugin/service-box/reviews/?filter=5#new-post" class="wpsm-service-b-dismiss-review-notice wpsm-service-b-review-out" target="_blank" rel="noopener">Rate the plugin</a>&nbsp; &nbsp;
			<a style="color: #fff;background: #27d63c;padding: 5px 7px 4px 6px;border-radius: 4px;" href="#"  class="wpsm-service-b-dismiss-review-notice wpsm-rate-later" target="_self" rel="noopener"><?php _e( 'Nope, maybe later', '' ); ?></a>&nbsp; &nbsp;
			<a style="color: #fff;background: #31a3dd;padding: 5px 7px 4px 6px;border-radius: 4px;" href="#" class="wpsm-service-b-dismiss-review-notice wpsm-rated" target="_self" rel="noopener"><?php _e( 'I already did', '' ); ?></a>
		</p>
	</div>
	<script type="text/javascript">
		jQuery(document).ready( function($) {
			$(document).on('click', '.wpsm-service-b-dismiss-review-notice, .wpsm-service-b-dismiss-notice .notice-dismiss', function( event ) {
				if ( $(this).hasClass('wpsm-service-b-review-out') ) {
					var wpsm_rate_data_val = "1";
				}
				if ( $(this).hasClass('wpsm-rate-later') ) {
					var wpsm_rate_data_val =  "2";
					event.preventDefault();
				}
				if ( $(this).hasClass('wpsm-rated') ) {
					var wpsm_rate_data_val =  "3";
					event.preventDefault();
				}

				$.post( ajaxurl, {
					action: 'wpsm_service_b_dismiss_review',
					wpsm_rate_data_service_b : wpsm_rate_data_val
				});
				
				$('.wpsm-service-b-review-notice').hide();
				//location.reload();
			});
		});
	</script>
	<?php
}

add_action( 'wp_ajax_wpsm_service_b_dismiss_review', 'wpsm_service_b_dismiss_review' );
function wpsm_service_b_dismiss_review() {
	if ( ! $review ) {
		$review = array();
	}
	
	if($_POST['wpsm_rate_data_service_b']=="1"){
		
		
	}
	if($_POST['wpsm_rate_data_service_b']=="2"){
		$review['time'] 	 = time();
		$review['dismissed'] = false;
		update_option( 'wpsm_service_b_review', $review );
		
	}
	if($_POST['wpsm_rate_data_service_b']=="3"){
		$review['time'] 	 = time();
		$review['dismissed'] = true;
		update_option( 'wpsm_service_b_review', $review );
		
	}
	
	die;
}

 
function wpsm_service_r_header_info() {
 	if(get_post_type()=="wpsm_servicebox_r") {
		?>
		<style>
		.wpsm_ac_h_i{
			background:url('<?php echo wpshopmart_service_box_directory_url.'assets/images/slideshow-01.jpg'; ?>') 50% 0 repeat fixed;
			margin-left: -20px;
			font-family: Myriad Pro ;
			cursor: pointer;
			text-align: center;
		}
		.wpsm_ac_h_i .wpsm_ac_h_b{
			color: white;
			font-size: 30px;
			font-weight: bolder;
			padding: 0 0 15px 0;
		}
		.wpsm_ac_h_i .wpsm_ac_h_b .dashicons{
			font-size: 40px;
			position: absolute;
			margin-left: -45px;
			margin-top: -10px;
		}
		 .wpsm_ac_h_small{
			font-weight: bolder;
			color: white;
			font-size: 18px;
			padding: 0 0 15px 15px;
		}

		.wpsm_ac_h_i a{
		text-decoration: none;
		}
		@media screen and ( max-width: 600px ) {
			.wpsm_ac_h_i{ padding-top: 60px; margin-bottom: -50px; }
			.wpsm_ac_h_i .WlTSmall { display: none; }
		}
		.texture-layer {
			background: rgba(0,0,53,0.27);
			padding-top: 0px;
			padding: 27px 0 23px 0;
		}
		.wpsm_ac_h_i  li {
			color:#fff;
			font-size: 17px;
			line-height: 1.3;
			font-weight: 600;
		}
		 .wpsm_ac_h_i .btn-danger{
			  font-size: 29px;
			  background-color: #E74B42;
			  border-radius:1px;
			  margin-right:10px;
				 
		  }
		  .wpsm_ac_h_i .btn-success{
			      font-size: 29px;
				  border-radius:1px;
		  }

		</style>
		<div class="wpsm_ac_h_i ">
			<div class="texture-layer">
				<a href="https://wpshopmart.com/plugins/service-showcase-pro-plugin-wordpress/" target="_blank">
					<div class="wpsm_ac_h_b"><a class="btn btn-danger btn-lg " href="hhttps://wpshopmart.com/plugins/service-showcase-pro-plugin-wordpress/" target="_blank">Buy Pro Version</a><a class="btn btn-success btn-lg " href="http://dazzlersoftware.com/wpshopmart-demo/service-showcase-pro-plugin-demo/" target="_blank">View Demo</a></div>
					<div style="overflow:hidden;display:block;width:100%">
						<div class="col-md-3">
							<ul>
								<li> 55+ Design Templates </li>
								<li> Carousel/Slider Layout  </li>
								<li> Individual Color Scheme </li>
								<li> Section Background image  </li>
								<li> 500+ Google Fonts </li>
							</ul>
						</div>
						<div class="col-md-3">
							<ul>
								<li>10+ Column Layout </li>
								<li> Custom Image icon </li>
								<li> Hover Animation  </li>
								<li> Widget Option </li>
								<li> 500+ Glyphicon Icons Support </li>
							</ul>
						</div>
						<div class="col-md-3">
							<ul>
								<li> 500+ Dashicons Icon Support </li>
								<li> 1000+ Font Awesome Icon Support </li>
								<li> Set Auto Height </li>
								<li> Unlimited Shortcode </li>
								<li> Drag And Drop Builder </li>
								
							</ul>
						</div>
						<div class="col-md-3">
							<ul>
								<li> Transparent Animation </li>
								<li> Border Color Customization </li>
								<li> Unlimited Color Scheme </li>
								<li> High Priority Support </li>
								<li> All Browser Compatible </li>
							</ul>
						</div>
						
					</div>
				</a>
			</div>
		</div>
		<?php  
	}
}
add_action('in_admin_header','wpsm_service_r_header_info'); 

?>