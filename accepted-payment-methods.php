<?php
/*
Plugin Name: WooCommerce Accepted Payment Methods
Plugin URI: http://jameskoster.co.uk/tag/accepted-payment-methods/
Version: 0.7.1
Description: Allows you display which payment methods your online store accepts.
Author: jameskoster
Tested up to: 4.0
Author URI: http://jameskoster.co.uk
Text Domain: woocommerce-accepted-payment-methods
Domain Path: /languages/

	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

/**
 * Localisation
 */
load_plugin_textdomain( 'woocommerce-accepted-payment-methods', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	/**
	 * Accepted Payment Methods class
	 **/
	if ( ! class_exists( 'WC_apm' ) ) {

		class WC_apm {

			public function __construct() {

				// Init settings
				$this->settings = array(
					array(
						'name' => __( 'Accepted Payment Methods', 'woocommerce-accepted-payment-methods' ),
						'type' => 'title',
						'desc' => sprintf( __( 'To display the selected payment methods you can use the built in widget, the %s shortcode or the %s template tag.', 'woocommerce-accepted-payment-methods' ), '<code>[woocommerce_accepted_payment_methods]</code>', '<code>&lt;?php wc_accepted_payment_methods(); ?&gt;</code>' ),
						'id' => 'wc_apm_options'
					),
					array(
						'name' 		=> __( 'American Express', 'woocommerce-accepted-payment-methods' ),
						'desc' 		=> __( 'Display the American Express logo', 'woocommerce-accepted-payment-methods' ),
						'id' 		=> 'wc_apm_american_express',
						'type' 		=> 'checkbox'
					),
					// array(
					// 	'name' 		=> __( 'Bitcoin', 'woocommerce-accepted-payment-methods' ),
					// 	'desc' 		=> __( 'Display the Bitcoin logo', 'woocommerce-accepted-payment-methods' ),
					// 	'id' 		=> 'wc_apm_bitcoin',
					// 	'type' 		=> 'checkbox'
					// ),
					// array(
					// 	'name' 		=> __( 'Cash on Delivery', 'woocommerce-accepted-payment-methods' ),
					// 	'desc' 		=> __( 'Display Cash on Delivery symbol', 'woocommerce-accepted-payment-methods' ),
					// 	'id' 		=> 'wc_apm_cash_on_delivery',
					// 	'type' 		=> 'checkbox'
					// ),
					// array(
					// 	'name' 		=> __( 'Dankort', 'woocommerce-accepted-payment-methods' ),
					// 	'desc' 		=> __( 'Display the Dankort logo', 'woocommerce-accepted-payment-methods' ),
					// 	'id' 		=> 'wc_apm_dankort',
					// 	'type' 		=> 'checkbox'
					// ),
					array(
						'name' 		=> __( 'Discover', 'woocommerce-accepted-payment-methods' ),
						'desc' 		=> __( 'Display the Discover logo', 'woocommerce-accepted-payment-methods' ),
						'id' 		=> 'wc_apm_discover',
						'type' 		=> 'checkbox'
					),
					// array(
					// 	'name' 		=> __( 'Google', 'woocommerce-accepted-payment-methods' ),
					// 	'desc' 		=> __( 'Display the Google logo', 'woocommerce-accepted-payment-methods' ),
					// 	'id' 		=> 'wc_apm_google',
					// 	'type' 		=> 'checkbox'
					// ),
					array(
						'name' 		=> __( 'Maestro', 'woocommerce-accepted-payment-methods' ),
						'desc' 		=> __( 'Display the Maestro logo', 'woocommerce-accepted-payment-methods' ),
						'id' 		=> 'wc_apm_maestro',
						'type' 		=> 'checkbox'
					),
					array(
						'name' 		=> __( 'MasterCard', 'woocommerce-accepted-payment-methods' ),
						'desc' 		=> __( 'Display the MasterCard logo', 'woocommerce-accepted-payment-methods' ),
						'id' 		=> 'wc_apm_mastercard',
						'type' 		=> 'checkbox'
					),
					array(
						'name' 		=> __( 'PayPal', 'woocommerce-accepted-payment-methods' ),
						'desc' 		=> __( 'Display the PayPal logo', 'woocommerce-accepted-payment-methods' ),
						'id' 		=> 'wc_apm_paypal',
						'type' 		=> 'checkbox'
					),
					array(
						'name' 		=> __( 'Visa', 'woocommerce-accepted-payment-methods' ),
						'desc' 		=> __( 'Display the Visa logo', 'woocommerce-accepted-payment-methods' ),
						'id' 		=> 'wc_apm_visa',
						'type' 		=> 'checkbox'
					),
					array(
						'name' 		=> __( 'Twint', 'woocommerce-accepted-payment-methods' ),
						'desc' 		=> __( 'Display the Twint logo', 'woocommerce-accepted-payment-methods' ),
						'id' 		=> 'wc_apm_twint',
						'type' 		=> 'checkbox'
					),
					array(
						'name' 		=> __( 'PostFinance', 'woocommerce-accepted-payment-methods' ),
						'desc' 		=> __( 'Display the PostFinance logo', 'woocommerce-accepted-payment-methods' ),
						'id' 		=> 'wc_apm_postfinance',
						'type' 		=> 'checkbox'
					),
					array( 'type' => 'sectionend', 'id' => 'wc_apm_options' ),
				);

				// Default options
				add_option( 'wc_apm_label', 			'' );
				add_option( 'wc_apm_american_express', 	'no' );
				add_option( 'wc_apm_mastercard', 		'no' );
				add_option( 'wc_apm_paypal', 			'no' );
				add_option( 'wc_apm_visa', 				'no' );
				add_option( 'wc_apm_discover', 			'no' );
				add_option( 'wc_apm_maestro', 			'no' );
				add_option( 'wc_apm_twint', 	        'no' );
				add_option( 'wc_apm_postfinance',    	'no' );
				// add_option( 'wc_apm_google', 			'no' );
				// add_option( 'wc_apm_bitcoin', 			'no' );
				// add_option( 'wc_apm_cash_on_delivery', 	'no' );
				// add_option( 'wc_apm_dankort', 	'no' );

				// Admin
				add_action( 'woocommerce_settings_checkout', array( $this, 'admin_settings' ), 20 );
				add_action( 'woocommerce_update_options_checkout', array( $this, 'save_admin_settings' ) );
				add_action( 'wp_enqueue_scripts', array( $this, 'setup_styles' ) );


			}

	        /*-----------------------------------------------------------------------------------*/
			/* Class Functions */
			/*-----------------------------------------------------------------------------------*/

			function admin_settings() {
				woocommerce_admin_fields( $this->settings );
			}

			function save_admin_settings() {
				woocommerce_update_options( $this->settings );
			}

			// Setup styles
			function setup_styles() {
				wp_enqueue_style( 'apm-styles', plugins_url( '/assets/css/style.css', __FILE__ ) );
			}

		}
		$WC_apm = new WC_apm();
	}

	/**
	 * Frontend functions
	 */
	// Template tag
	if ( ! function_exists( 'wc_accepted_payment_methods' ) ) {
		function wc_accepted_payment_methods() {
			$amex 		= get_option( 'wc_apm_american_express' );
			$mastercard = get_option( 'wc_apm_mastercard' );
			$paypal 	= get_option( 'wc_apm_paypal' );
			$visa 		= get_option( 'wc_apm_visa' );
			$discover 	= get_option( 'wc_apm_discover' );
			$maestro 	= get_option( 'wc_apm_maestro' );
			$twint 	    = get_option( 'wc_apm_twint');
			$postfinance = get_option( 'wc_apm_postfinance');
			// $google 	= get_option( 'wc_apm_google' );
			// $bitcoin 	= get_option( 'wc_apm_bitcoin' );
			// $cod		= get_option( 'wc_apm_cash_on_delivery');
			// $dankort 	= get_option( 'wc_apm_dankort');

			$img_folder = plugin_dir_url( __FILE__ ) . 'assets/images/';

			// Display
			echo '<div class="accepted-payment-methods">';
				if ( $mastercard == "yes" ) { echo '<div class="card mastercard"><img  alt="MasterCard" src="'.$img_folder.'mastercard.png" /></div>'; }
				if ( $visa == "yes" ) { echo '<div class="card visa"><img  alt="Visa" src="'.$img_folder.'visa.png" /></div>'; }
				if ( $paypal == "yes" ) { echo '<div class="card paypal"><img alt="PayPal" src="'.$img_folder.'paypal.png" /></div>'; }
				if ( $twint == "yes" ) { echo '<div class="card twint"><img alt="Twint" src="'.$img_folder.'twint.png" /></div>'; }
				if ( $postfinance == "yes" ) { echo '<div class="card postfinance"><img alt="PostFinance" src="'.$img_folder.'postfinance.png" /></div>'; }			
				if ( $maestro == "yes" ) { echo '<div class="card"><img class="maestro" alt="Maestro" src="'.$img_folder.'maestro.png" /></div>'; }
				if ( $amex == "yes" ) { echo '<div class="card"><img class="american-express" alt="American Express" src="'.$img_folder.'amex.png" /></div>'; }
				if ( $discover == "yes" ) { echo '<div class="card"><img class="discover" alt="Discover" src="'.$img_folder.'discover.png" /></div>'; }
				// if ( $bitcoin == "yes" ) { echo '<div class="card"><img class="bitcoin" alt="Bitcoin" src="'.$img_folder.'bitcoin.png" /></div>'; }
				// if ( $cod == "yes" ) { echo '<div class="card"><img class="cash-on-deimgvery" alt="Cash on Delivery" src="'.$img_folder.'cod.png" /></div>'; }
				// if ( $dankort == "yes" ) { echo '<div class="card"><img class="dankort" alt="Dankort" src="'.$img_folder.'dankort.png" /></div>'; }
				// if ( $google == "yes" ) { echo '<div class="card"><img class="google" alt="Google" src="'.$img_folder.'google.png" /></div>'; }
			echo '</div>';
		}
	}

	// The shortcode
	add_shortcode( 'woocommerce_accepted_payment_methods', 'wc_accepted_payment_methods' );

	// The widget
	class Accepted_Payment_Methods extends WP_Widget {

		function Accepted_Payment_Methods() {
			// Instantiate the parent object
			parent::__construct( false, 'WooCommerce Accepted Payment Methods' );
		}

		function widget( $args, $instance ) {
			// Widget output
			extract( $args );

			$title = apply_filters( 'widget_title', $instance['title'] );

			echo $before_widget;
			if ( ! empty( $title ) )
				echo $before_title . $title . $after_title;
				wc_accepted_payment_methods();
			echo $after_widget;
		}
		/**
		 * Sanitize widget form values as they are saved.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = strip_tags( $new_instance['title'] );

			return $instance;
		}

		/**
		 * Back-end widget form.
		 */
		public function form( $instance ) {
			if ( isset( $instance[ 'title' ] ) ) {
				$title = $instance[ 'title' ];
			}
			else {
				$title = __( 'Accepted Payment Methods', 'woocommerce-accepted-payment-methods' );
			}
			?>
			<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'woocommerce-accepted-payment-methods' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
			<?php _e( 'Configure which payment methods your store accepts in the', 'woocommerce-accepted-payment-methods' ); ?> <a href="<?php echo admin_url( 'admin.php?page=wc-settings&tab=checkout' ); ?>"><?php _e( 'WooCommerce settings', 'woocommerce-accepted-payment-methods' ); ?></a>.
			</p>
			<?php
		}

	}

	function apm_register_widgets() {
		register_widget( 'Accepted_Payment_Methods' );
	}

	add_action( 'widgets_init', 'apm_register_widgets' );

}
