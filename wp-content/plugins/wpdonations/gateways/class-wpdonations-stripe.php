<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;
/**
 * WPdonations_Stripe
 */
class WPdonations_Stripe extends WPdonations_Gateway {
	private $api_endpoint = 'https://api.stripe.com/';
	/**
	 * __construct function.
	 */
	public function __construct() {
		$this->gateway_id   = 'stripe';
		$this->gateway_name = __( 'Stripe Checkout', 'donation_manager' );
		$this->settings     = array(
			array(
				'name' 		=> 'wpdonations_stripe_testmode',
				'std' 		=> 'no',
				'label' 	=> __( 'Test Mode', 'donation_manager' ),
				'desc'		=> __( 'Enable Test Mode', 'donation_manager' ),
				'options'   => array(
					'yes' => __( 'Yes', 'donation_manager' ),
					'no' => __( 'No', 'donation_manager' ),
				),
				'type'      => 'select',
				'class'     => 'gateway-settings gateway-settings-stripe'
			),
			array(
				'name' 		=> 'wpdonations_stripe_secret_key',
				'std' 		=> '',
				'label' 	=> __( 'Secret Key', 'donation_manager' ),
				'desc'		=> __( 'Get your API keys from your stripe account.', 'donation_manager' ),
				'type'      => 'input',
				'class'     => 'gateway-settings gateway-settings-stripe'
			),
			array(
				'name' 		=> 'wpdonations_stripe_publishable_key',
				'std' 		=> '',
				'label' 	=> __( 'Publishable Key', 'donation_manager' ),
				'desc'		=> __( 'Get your API keys from your stripe account.', 'donation_manager' ),
				'type'      => 'input',
				'class'     => 'gateway-settings gateway-settings-stripe'
			)
		);
		parent::__construct();
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );
	}
	/**
	 * frontend_scripts function.
	 *
	 * @access public
	 * @return void
	 */
	public function frontend_scripts( $donation_id ) {
		wp_enqueue_script( 'stripe', 'https://checkout.stripe.com/v2/checkout.js', '', '2.0', true );
		wp_enqueue_script( 'wpdonations-stripe', WPDONATIONS_PLUGIN_URL . '/assets/js/stripe-checkout.js', array( 'jquery', 'stripe' ), '1.0', true );
		wp_localize_script( 'wpdonations-stripe', 'stripe_checkout_params', array(
			'key'         => get_option( 'wpdonations_stripe_publishable_key' ),
			'label'       => __( 'Donate', 'wpdonations' ),
			'amount'      => number_format( get_the_donation_amount( $donation_id ), 2, '.', '' ) * 100,
			'currency'    => strtolower( get_option( 'wpdonations_currency' ) ),
			'name'        => get_bloginfo( 'name' )
		) );
	}
	/**
	 * Pay for a donation action
	 */
	public function pay_for_donation( $donation_id ) {
		try {
			$stripe_token = isset( $_POST['stripe_token'] ) ? sanitize_text_field( $_POST['stripe_token'] ) : '';
			if ( empty( $stripe_token ) )
				throw new Exception( __( 'Please make sure your card details have been entered correctly and that your browser supports JavaScript.', 'wpdonations' ) );
			$response = wp_remote_post( $this->api_endpoint . 'v1/charges', array(
					'method'		=> 'POST',
					'headers' => array(
					'Authorization' => 'Basic ' . base64_encode( get_option( 'wpdonations_stripe_secret_key' ) . ':' )
				),
				'body' 			=> array(
					'amount'      => number_format( get_the_donation_amount( $donation_id ), 2, '.', '' ) * 100,
					'currency'    => strtolower( get_option( 'wpdonations_currency' ) ),
					'description' => __( 'New Donation', 'wpdonations' ) . ' &quot;' . get_the_title( $donation_id ) . '&quot;',
					'capture'     => 'true',
					'card'        => $stripe_token
				),
				'timeout' 		=> 60,
				'sslverify' 	=> false,
				'user-agent' 	=> 'WPdonations'
			));
			if ( is_wp_error($response) )
				throw new Exception( __( 'There was a problem connecting to the gateway.', 'wpdonations' ) );
			if( empty( $response['body'] ) )
				throw new Exception( __( 'Empty response.', 'wpdonations' ) );
			$parsed_response = json_decode( $response['body'] );
			// Handle response
			if ( ! empty( $parsed_response->error ) ) {
				throw new Exception( $parsed_response->error->message );
			} elseif ( empty( $parsed_response->id ) ) {
				throw new Exception( __( 'Invalid response.', 'wpdonations' ) );
			} else {
				// Store charge ID
				update_post_meta( $donation_id, 'Charge ID', $parsed_response->id );
				update_post_meta( $donation_id, 'Payment ID', $parsed_response->id );
				update_post_meta( $donation_id, 'Stripe Fee', number_format( $parsed_response->fee / 100, 2, '.', '' ) );
				// Notify admin
				if ( get_option( 'wpdonations_submission_requires_approval' ) )
                	$this->send_admin_email( $donation_id, sprintf( __( "Payment has been received in full for donation #%d - this donation is ready for admin approval.", 'wpdonations' ), $donation_id ) );
               	else
               		$this->send_admin_email( $donation_id, sprintf( __( "Payment has been received in full for donation #%d - this donation has been automatically approved.", 'wpdonations' ), $donation_id ) );
				$this->payment_complete( $donation_id );
				return true;
			}
		} catch( Exception $e ) {
			WPdonations_Form_Submit_donation::add_error( $e->getMessage() );
			return false;
		}
	}
}
return new WPdonations_Stripe();