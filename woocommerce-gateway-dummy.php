<?php
/**
 * Plugin Name: WooCommerce Dummy Payments Gateway
 * Plugin URI: https://somewherewarm.com/
 * Description: Adds the Dummy Payments gateway to your WooCommerce website.
 * Version: 1.0.5
 *
 * Author: SomewhereWarm
 * Author URI: https://somewherewarm.com/
 *
 * Text Domain: woocommerce-gateway-dummy
 * Domain Path: /i18n/languages/
 *
 * Requires at least: 4.2
 * Tested up to: 4.9
 *
 * Copyright: © 2009-2017 Emmanouil Psychogyiopoulos.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WC Dummy Payment gateway plugin class.
 *
 * @class WC_Dummy_Payments
 */
class WC_Dummy_Payments {

	/**
	 * Plugin bootstrapping.
	 */
	public static function init() {

		// Dummy Payments gateway class.
		add_action( 'plugins_loaded', array( __CLASS__, 'includes' ), 0 );

		// Make the Dummy Payments gateway available to WC.
		add_filter( 'woocommerce_payment_gateways', array( __CLASS__, 'add_gateway' ) );

		// Registers WooCommerce Blocks integration.
		add_action( 'woocommerce_blocks_loaded', array( __CLASS__, 'woocommerce_gateway_dummy_woocommerce_block_support' ) );

	}

	/**
	 * Add the Dummy Payment gateway to the list of available gateways.
	 *
	 * @param array
	 */
	public static function add_gateway( $gateways ) {
		$gateways[] = 'WC_Gateway_Dummy';
		return $gateways;
	}

	/**
	 * Plugin includes.
	 */
	public static function includes() {

		// Make the WC_Gateway_Dummy class available.
		if ( class_exists( 'WC_Payment_Gateway' ) ) {
			require_once 'includes/class-wc-gateway-dummy.php';
		}
	}

	/**
	 * Plugin url.
	 *
	 * @return string
	 */
	public static function plugin_url() {
		return untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	/**
	 * Plugin url.
	 *
	 * @return string
	 */
	public static function plugin_abspath() {
		return trailingslashit( plugin_dir_path( __FILE__ ) );
	}

	/**
	 * Registers WooCommerce Blocks integration.
	 *
	 */
	public static function woocommerce_gateway_dummy_woocommerce_block_support() {
		if ( class_exists( 'Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType' ) ) {
			require_once 'includes/blocks/class-wc-dummy-payments-blocks.php';
			add_action(
				'woocommerce_blocks_payment_method_type_registration',
				function( Automattic\WooCommerce\Blocks\Payments\PaymentMethodRegistry $payment_method_registry ) {
					$payment_method_registry->register( new WC_Gateway_Dummy_Blocks_Support );
				}
			);
		}
		woocommerce_store_api_register_update_callback(
			[
			  'namespace' => 'extension-unique-namespace',
			  'callback'  => function ($data){
					ob_start();
					var_dump($data);
					error_log(ob_get_clean());
			  }
			]
		  );
	}
}

WC_Dummy_Payments::init();