<?php
/**
 * Part of Woo Mercado Pago Module
 * Author - Mercado Pago
 * Developer
 * Copyright - Copyright(c) MercadoPago [https://www.mercadopago.com]
 * License - https://www.gnu.org/licenses/gpl.html GPL version 2 or higher
 *
 * @package MercadoPago
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WC_WooMercadoPago_Custom_Gateway
 */
class WC_WooMercadoPago_Custom_Gateway extends WC_WooMercadoPago_Payment_Abstract {

	const ID = 'woo-mercado-pago-custom';

	/**
	 * Is enable Wallet Button?
	 *
	 * @var string
	 */
	protected $wallet_button;

	/**
	 * WC_WooMercadoPago_CustomGateway constructor.
	 *
	 * @throws WC_WooMercadoPago_Exception Exception load payment.
	 */
	public function __construct() {
		$this->id          = self::ID;
		$this->description = __( 'Accept card payments on your website with the best possible financing and maximize the conversion of your business. With personalized checkout your customers pay without leaving your store!', 'woocommerce-mercadopago' );
		$this->title       = __( 'Pay with debit and credit cards', 'woocommerce-mercadopago' );

		if ( ! $this->validate_section() ) {
			return;
		}

		$this->form_fields        = array();
		$this->method_title       = __( 'Mercado Pago - Custom Checkout', 'woocommerce-mercadopago' );
		$this->title              = $this->get_option_mp( 'title', __( 'Pay with debit and credit cards', 'woocommerce-mercadopago' ) );
		$this->method_description = $this->description;
		$this->coupon_mode        = $this->get_option_mp( 'coupon_mode', 'no' );
		$this->wallet_button      = $this->get_option_mp( 'wallet_button', 'yes' );
		$this->field_forms_order  = $this->get_fields_sequence();
		parent::__construct();
		$this->form_fields         = $this->get_form_mp_fields( 'Custom' );
		$this->hook                = new WC_WooMercadoPago_Hook_Custom( $this );
		$this->notification        = new WC_WooMercadoPago_Notification_Webhook( $this );
		$this->currency_convertion = true;
	}

	/**
	 * Get Form Mercado Pago fields
	 *
	 * @param string $label Label.
	 * @return array
	 */
	public function get_form_mp_fields( $label ) {
		if ( is_admin() && $this->is_manage_section() ) {
			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
			wp_enqueue_script(
				'woocommerce-mercadopago-custom-config-script',
				plugins_url( '../assets/js/custom_config_mercadopago' . $suffix . '.js', plugin_dir_path( __FILE__ ) ),
				array(),
				WC_WooMercadoPago_Constants::VERSION,
				false
			);
			wp_enqueue_script(
				'woocommerce-mercadopago-credentials',
				plugins_url( '../assets/js/validate-credentials' . $suffix . '.js', plugin_dir_path( __FILE__ ) ),
				array(),
				WC_WooMercadoPago_Constants::VERSION,
				true
			);
		}

		if ( empty( $this->checkout_country ) ) {
			$this->field_forms_order = array_slice( $this->field_forms_order, 0, 7 );
		}

		if ( ! empty( $this->checkout_country ) && empty( $this->get_access_token() ) && empty( $this->get_public_key() ) ) {
			$this->field_forms_order = array_slice( $this->field_forms_order, 0, 22 );
		}

		$form_fields                           = array();
		$form_fields['checkout_custom_header'] = $this->field_checkout_custom_header();
		if ( ! empty( $this->checkout_country ) && ! empty( $this->get_access_token() ) && ! empty( $this->get_public_key() ) ) {
			$form_fields['checkout_custom_options_title']           = $this->field_checkout_custom_options_title();
			$form_fields['checkout_custom_payments_title']          = $this->field_checkout_custom_payments_title();
			$form_fields['checkout_payments_subtitle']              = $this->field_checkout_payments_subtitle();
			$form_fields['binary_mode']                             = $this->field_binary_mode();
			$form_fields['checkout_custom_payments_advanced_title'] = $this->field_checkout_custom_payments_advanced_title();
			$form_fields['coupon_mode']                             = $this->field_coupon_mode();
			$form_fields['wallet_button']                           = $this->field_checkout_custom_wallet_button();
			$form_fields['mp_psj_title']                            = $this->field_mp_psj_title( $this->checkout_country );
			$form_fields['mp_psj_description']                      = $this->field_mp_psj_description( $this->checkout_country );
			$form_fields['mp_psj_description_link']                 = $this->field_mp_psj_description_link( $this->checkout_country );
		}
		$form_fields_abs = parent::get_form_mp_fields( $label );
		if ( 1 === count( $form_fields_abs ) ) {
			return $form_fields_abs;
		}
		$form_fields_merge = array_merge( $form_fields_abs, $form_fields );
		$fields            = $this->sort_form_fields( $form_fields_merge, $this->field_forms_order );

		return $fields;
	}

	/**
	 * Get fields sequence
	 *
	 * @return array
	 */
	public function get_fields_sequence() {
		return array(
			// Necessary to run.
			'description',
			// Checkout de pagos con tarjetas de débito y crédito<br> Aceptá pagos al instante y maximizá la conversión de tu negocio.
			'checkout_custom_header',
			'checkout_steps',
			// ¿En qué país vas a activar tu tienda?
			'checkout_country_title',
			'checkout_country',
			'checkout_btn_save',
			// Carga tus credenciales.
			'checkout_credential_title',
			'checkout_credential_link',
			'checkout_credential_title_prod',
			'checkout_credential_description_prod',
			'_mp_public_key_prod',
			'_mp_access_token_prod',
			'checkout_credential_title_test',
			'checkout_credential_description_test',
			'_mp_public_key_test',
			'_mp_access_token_test',
			'checkout_mode_title',
			'checkout_subtitle_checkout_mode',
			'checkbox_checkout_test_mode',
			'checkbox_checkout_production_mode',
			'checkout_mode_alert',
			// Everything ready for the takeoff of your sales?
			'checkout_ready_title',
			'checkout_ready_description',
			'checkout_ready_description_link',
			// No olvides de homologar tu cuenta.
			'checkout_homolog_title',
			'checkout_homolog_subtitle',
			'checkout_homolog_link',
			// Set up the payment experience in your store.
			'checkout_custom_options_title',
			'mp_statement_descriptor',
			'_mp_category_id',
			'_mp_store_identificator',
			'_mp_integrator_id',
			// Advanced settings.
			'checkout_advanced_settings',
			'_mp_debug_mode',
			'_mp_custom_domain',
			// Configure the personalized payment experience in your store.
			'checkout_custom_payments_title',
			'checkout_payments_subtitle',
			'enabled',
			'title',
			WC_WooMercadoPago_Helpers_CurrencyConverter::CONFIG_KEY,
			'wallet_button',
			'mp_psj_title',
			'mp_psj_description',
			'mp_psj_description_link',
			// Advanced configuration of the personalized payment experience.
			'checkout_custom_payments_advanced_title',
			'checkout_payments_advanced_description',
			'coupon_mode',
			'binary_mode',
			'gateway_discount',
			'commission',
			// Support session.
			'checkout_support_title',
			'checkout_support_description',
			'checkout_support_description_link',
			'checkout_support_problem',
		);
	}

	/**
	 * Field checkout custom header
	 *
	 * @return array
	 */
	public function field_checkout_custom_header() {
		$checkout_custom_header = array(
			'title' => sprintf(
				/* translators: %s card */
				__( 'Checkout of payments with debit and credit cards %s', 'woocommerce-mercadopago' ),
				'<div class="mp-row">
                <div class="mp-col-md-12 mp_subtitle_header">
                ' . __( 'Accept payments instantly and maximize the conversion of your business', 'woocommerce-mercadopago' ) . '
                 </div>
              <div class="mp-col-md-12">
                <p class="mp-text-checkout-body mp-mb-0">
                  ' . __( 'Turn your online store into a secure and easy-to-use payment gateway for your customers. With personalized checkout your customers pay without leaving your store!', 'woocommerce-mercadopago' ) . '
                </p>
              </div>
            </div>'
			),
			'type'  => 'title',
			'class' => 'mp_title_header',
		);
		return $checkout_custom_header;
	}

	/**
	 * Filed checkout custom options title
	 *
	 * @return array
	 */
	public function field_checkout_custom_options_title() {
		$checkout_custom_options_title = array(
			'title' => __( 'Set up the payment experience in your store', 'woocommerce-mercadopago' ),
			'type'  => 'title',
			'class' => 'mp_title_bd',
		);
		return $checkout_custom_options_title;
	}

	/**
	 * Field checkout custom payments title
	 *
	 * @return array
	 */
	public function field_checkout_custom_payments_title() {
		$checkout_custom_payments_title = array(
			'title' => __( 'Configure the personalized payment experience in your store', 'woocommerce-mercadopago' ),
			'type'  => 'title',
			'class' => 'mp_title_bd',
		);
		return $checkout_custom_payments_title;
	}

	/**
	 * Field checkout custom payment advanced title
	 *
	 * @return array
	 */
	public function field_checkout_custom_payments_advanced_title() {
		$checkout_custom_payments_advanced_title = array(
			'title' => __( 'Advanced configuration of the personalized payment experience"', 'woocommerce-mercadopago' ),
			'type'  => 'title',
			'class' => 'mp_subtitle_bd',
		);
		return $checkout_custom_payments_advanced_title;
	}

	/**
	 * Field Gateway Discount
	 *
	 * @return array
	 */
	public function field_checkout_custom_wallet_button() {
		return array(
			'title'       => __( 'Payment with card stored in Mercado Pago', 'woocommerce-mercadopago' ),
			'type'        => 'select',
			'default'     => 'yes',
			'description' => __( 'Activate this function so that your customers already using Mercado Pago can buy without having to fill in their card details at the store checkout.', 'woocommerce-mercadopago' ),
			'options'     => array(
				'no'  => __( 'No', 'woocommerce-mercadopago' ),
				'yes' => __( 'Yes', 'woocommerce-mercadopago' ),
			),
		);
	}

	/**
	 * Get Order Status
	 *
	 * @param string $status_detail Status.
	 * @return string|void
	 */
	public function get_order_status( $status_detail ) {
		switch ( $status_detail ) {
			case 'accredited':
				return __( 'That’s it, payment accepted!', 'woocommerce-mercadopago' );
			case 'pending_contingency':
				return __( 'We are processing your payment. In less than an hour we will send you the result by email.', 'woocommerce-mercadopago' );
			case 'pending_review_manual':
				return __( 'We are processing your payment. In less than 2 days we will send you by email if the payment has been approved or if additional information is needed.', 'woocommerce-mercadopago' );
			case 'cc_rejected_bad_filled_card_number':
				return __( 'Check the card number.', 'woocommerce-mercadopago' );
			case 'cc_rejected_bad_filled_date':
				return __( 'Check the expiration date.', 'woocommerce-mercadopago' );
			case 'cc_rejected_bad_filled_other':
				return __( 'Check the information provided.', 'woocommerce-mercadopago' );
			case 'cc_rejected_bad_filled_security_code':
				return __( 'Check the informed security code.', 'woocommerce-mercadopago' );
			case 'cc_rejected_blacklist':
				return __( 'Your payment cannot be processed.', 'woocommerce-mercadopago' );
			case 'cc_rejected_call_for_authorize':
				return __( 'You must authorize payments for your orders.', 'woocommerce-mercadopago' );
			case 'cc_rejected_card_disabled':
				return __( 'Contact your card issuer to activate it. The phone is on the back of your card.', 'woocommerce-mercadopago' );
			case 'cc_rejected_card_error':
				return __( 'Your payment cannot be processed.', 'woocommerce-mercadopago' );
			case 'cc_rejected_duplicated_payment':
				return __( 'You have already made a payment of this amount. If you have to pay again, use another card or other method of payment.', 'woocommerce-mercadopago' );
			case 'cc_rejected_high_risk':
				return __( 'Your payment was declined. Please select another payment method. It is recommended in cash.', 'woocommerce-mercadopago' );
			case 'cc_rejected_insufficient_amount':
				return __( 'Your payment does not have sufficient funds.', 'woocommerce-mercadopago' );
			case 'cc_rejected_invalid_installments':
				return __( 'Payment cannot process the selected fee.', 'woocommerce-mercadopago' );
			case 'cc_rejected_max_attempts':
				return __( 'You have reached the limit of allowed attempts. Choose another card or other payment method.', 'woocommerce-mercadopago' );
			case 'cc_rejected_other_reason':
				return __( 'This payment method cannot process your payment.', 'woocommerce-mercadopago' );
			default:
				return __( 'This payment method cannot process your payment.', 'woocommerce-mercadopago' );
		}
	}

	/**
	 * Payment Fields
	 */
	public function payment_fields() {
		// add css.
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_style(
			'woocommerce-mercadopago-basic-checkout-styles',
			plugins_url( '../assets/css/basic_checkout_mercadopago' . $suffix . '.css', plugin_dir_path( __FILE__ ) ),
			array(),
			WC_WooMercadoPago_Constants::VERSION
		);

		$amount     = $this->get_order_total();
		$discount   = $amount * ( $this->gateway_discount / 100 );
		$comission  = $amount * ( $this->commission / 100 );
		$amount     = $amount - $discount + $comission;
		$banner_url = $this->get_option_mp( '_mp_custom_banner' );
		if ( ! isset( $banner_url ) || empty( $banner_url ) ) {
			$banner_url = $this->site_data['checkout_banner_custom'];
		}

		// credit or debit card.
		$debit_card  = array();
		$credit_card = array();
		$tarjetas    = get_option( '_checkout_payments_methods', '' );

		foreach ( $tarjetas as $tarjeta ) {
			if ( 'credit_card' === $tarjeta['type'] ) {
				$credit_card[] = $tarjeta['image'];
			} elseif ( 'debit_card' === $tarjeta['type'] || 'prepaid_card' === $tarjeta['type'] ) {
				$debit_card[] = $tarjeta['image'];
			}
		}

		try {
			$currency_ratio = WC_WooMercadoPago_Helpers_CurrencyConverter::get_instance()->ratio( $this );
		} catch ( Exception $e ) {
			$currency_ratio = WC_WooMercadoPago_Helpers_CurrencyConverter::DEFAULT_RATIO;
		}

		$test_mode_rules_link = $this->get_mp_devsite_link($this->checkout_country);
		$parameters           = array(
			'checkout_alert_test_mode' => $this->is_production_mode()
			? ''
			: $this->checkout_alert_test_mode_template(
				__( 'Cards in Test Mode', 'woocommerce-mercadopago' ),
				__( 'Use the test-specific cards that are in the', 'woocommerce-mercadopago' )
				. "<a style='color: #74AFFC; text-decoration: none; outline: none;' target='_blank' href='$test_mode_rules_link'> "
				. __( 'test mode rules', 'woocommerce-mercadopago' ) . '</a>.</p>'
			),
			'amount'               => $amount,
			'site_id'              => $this->get_option_mp( '_site_id_v1' ),
			'public_key'           => $this->get_public_key(),
			'coupon_mode'          => isset( $this->logged_user_email ) ? $this->coupon_mode : 'no',
			'discount_action_url'  => $this->discount_action_url,
			'payer_email'          => esc_js( $this->logged_user_email ),
			'images_path'          => plugins_url( '../assets/images/', plugin_dir_path( __FILE__ ) ),
			'currency_ratio'       => $currency_ratio,
			'woocommerce_currency' => get_woocommerce_currency(),
			'account_currency'     => $this->site_data['currency'],
			'debit_card'           => $debit_card,
			'credit_card'          => $credit_card,
			'wallet_button'        => $this->wallet_button,
		);

		$parameters = array_merge($parameters, WC_WooMercadoPago_Payment_Abstract::mp_define_terms_and_conditions());
		wc_get_template( 'checkout/custom-checkout.php', $parameters, 'woo/mercado/pago/module/', WC_WooMercadoPago_Module::get_templates_path() );
	}

	/**
	 * Process payment
	 *
	 * @param int $order_id Order Id.
	 * @return array|void
	 */
	public function process_payment( $order_id ) {
		// @todo need fix Processing form data without nonce verification
		// @codingStandardsIgnoreLine
		$custom_checkout = $_POST['mercadopago_custom'];

		// @todo need fix Processing form data without nonce verification
		// @codingStandardsIgnoreLine
		if ( ! isset( $_POST['mercadopago_custom'] ) ) {
			return $this->process_result_fail(
				__FUNCTION__,
				__( 'A problem was occurred when processing your payment. Please, try again.', 'woocommerce-mercadopago' ),
				__( 'A problem was occurred when processing your payment. Please, try again.', 'woocommerce-mercadopago' )
			);
		}

		$this->log->write_log( __FUNCTION__, 'POST Custom: ' . wp_json_encode( $custom_checkout, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE ) );

		$order = wc_get_order( $order_id );

		$this->process_discount_and_commission( $order_id, $order );

		if ( 'wallet_button' === $custom_checkout['checkout_type'] ) {
			$this->log->write_log( __FUNCTION__, 'preparing to render wallet button checkout.' );
			$response = $this->process_custom_checkout_wallet_button_flow( $order );
		} else {
			$this->log->write_log( __FUNCTION__, 'preparing to get response of custom checkout.' );
			$response = $this->process_custom_checkout_flow( $custom_checkout, $order );
		}

		if ( $response ) {
			return $response;
		}

		return $this->process_result_fail(
			__FUNCTION__,
			__( 'A problem was occurred when processing your payment. Please, try again.', 'woocommerce-mercadopago' ),
			__( 'A problem was occurred when processing your payment. Please, try again.', 'woocommerce-mercadopago' )
		);
	}

	/**
	 * Process Custom Wallet Button Flow
	 *
	 * @param WC_Order $order
	 *
	 * @return array
	 */
	protected function process_custom_checkout_wallet_button_flow( $order ) {
		return array(
			'result'   => 'success',
			'redirect' => add_query_arg(
				array(
					'wallet_button' => 'open'
				),
				$order->get_checkout_payment_url( true )
			),
		);
	}

	/**
	 * Process Custom Payment Flow
	 *
	 * @param array $custom_checkout
	 * @param WC_Order $order
	 *
	 * @return array|string[]
	 */
	protected function process_custom_checkout_flow( $custom_checkout, $order ) {
		if (
			isset( $custom_checkout['amount'] ) && ! empty( $custom_checkout['amount'] ) &&
			isset( $custom_checkout['token'] ) && ! empty( $custom_checkout['token'] ) &&
			isset( $custom_checkout['paymentMethodId'] ) && ! empty( $custom_checkout['paymentMethodId'] ) &&
			isset( $custom_checkout['installments'] ) && ! empty( $custom_checkout['installments'] ) &&
			-1 !== $custom_checkout['installments']
		) {
			$response = $this->create_preference( $order, $custom_checkout );

			if ( ! is_array( $response ) ) {
				return array(
					'result'   => 'fail',
					'redirect' => '',
				);
			}
			// Switch on response.
			if ( array_key_exists( 'status', $response ) ) {
				switch ( $response['status'] ) {
					case 'approved':
						WC()->cart->empty_cart();
						wc_add_notice( '<p>' . $this->get_order_status( 'accredited' ) . '</p>', 'notice' );
						$this->set_order_to_pending_on_retry( $order );
						return array(
							'result'   => 'success',
							'redirect' => $order->get_checkout_order_received_url(),
						);
					case 'pending':
						// Order approved/pending, we just redirect to the thankyou page.
						return array(
							'result'   => 'success',
							'redirect' => $order->get_checkout_order_received_url(),
						);
					case 'in_process':
						// For pending, we don't know if the purchase will be made, so we must inform this status.
						WC()->cart->empty_cart();
						wc_add_notice(
							'<p>' . $this->get_order_status( $response['status_detail'] ) . '</p>' .
							'<p><a class="button" href="' . esc_url( $order->get_checkout_order_received_url() ) . '">' .
							__( 'See your order form', 'woocommerce-mercadopago' ) .
							'</a></p>',
							'notice'
						);
						return array(
							'result'   => 'success',
							'redirect' => $order->get_checkout_payment_url( true ),
						);
					case 'rejected':
						// If rejected is received, the order will not proceed until another payment try, so we must inform this status.
						wc_add_notice(
							'<p>' . __(
								'Your payment was declined. You can try again.',
								'woocommerce-mercadopago'
							) . '<br>' .
							$this->get_order_status( $response['status_detail'] ) .
							'</p>' .
							'<p><a class="button" href="' . esc_url( $order->get_checkout_payment_url() ) . '">' .
							__( 'Click to try again', 'woocommerce-mercadopago' ) .
							'</a></p>',
							'error'
						);
						return array(
							'result'   => 'success',
							'redirect' => $order->get_checkout_payment_url( true ),
						);
					case 'cancelled':
					case 'in_mediation':
					case 'charged_back':
						// If we enter here (an order generating a direct [cancelled, in_mediation, or charged_back] status),
						// them there must be something very wrong!
						break;
					default:
						break;
				}
			}

			// Process when fields are imcomplete.
			return $this->process_result_fail(
				__FUNCTION__,
				__( 'A problem was occurred when processing your payment. Are you sure you have correctly filled all information in the checkout form?', 'woocommerce-mercadopago' ),
				__( 'A problem was occurred when processing your payment. Are you sure you have correctly filled all information in the checkout form?', 'woocommerce-mercadopago' ) . ' MERCADO PAGO: ' .
				WC_WooMercadoPago_Module::get_common_error_messages( $response )
			);
		}
	}

	/**
	 * Fill a commission and discount information
	 *
	 * @param $order_id
	 * @param $order
	 */
	protected function process_discount_and_commission( $order_id, $order ) {
		$amount = $this->get_order_total();
		if ( method_exists( $order, 'update_meta_data' ) ) {
			$order->update_meta_data( 'is_production_mode', $this->get_option_mp( 'checkbox_checkout_production_mode' ) );
			$order->update_meta_data( '_used_gateway', get_class( $this ) );

			if ( ! empty( $this->gateway_discount ) ) {
				$discount = $amount * ( $this->gateway_discount / 100 );
				$order->update_meta_data( 'Mercado Pago: discount', __( 'discount of', 'woocommerce-mercadopago' ) . ' ' . $this->gateway_discount . '% / ' . __( 'discount of', 'woocommerce-mercadopago' ) . ' = ' . $discount );
			}

			if ( ! empty( $this->commission ) ) {
				$comission = $amount * ( $this->commission / 100 );
				$order->update_meta_data( 'Mercado Pago: commission', __( 'fee of', 'woocommerce-mercadopago' ) . ' ' . $this->commission . '% / ' . __( 'fee of', 'woocommerce-mercadopago' ) . ' = ' . $comission );
			}
			$order->save();
		} else {
			update_post_meta( $order_id, '_used_gateway', get_class( $this ) );
			if ( ! empty( $this->gateway_discount ) ) {
				$discount = $amount * ( $this->gateway_discount / 100 );
				update_post_meta( $order_id, 'Mercado Pago: discount', __( 'discount of', 'woocommerce-mercadopago' ) . ' ' . $this->gateway_discount . '% / ' . __( 'discount of', 'woocommerce-mercadopago' ) . ' = ' . $discount );
			}

			if ( ! empty( $this->commission ) ) {
				$comission = $amount * ( $this->commission / 100 );
				update_post_meta( $order_id, 'Mercado Pago: commission', __( 'fee of', 'woocommerce-mercadopago' ) . ' ' . $this->commission . '% / ' . __( 'fee of', 'woocommerce-mercadopago' ) . ' = ' . $comission );
			}
		}
	}

	/**
	 * Process if result is fail
	 *
	 * @param $function
	 * @param $log_message
	 * @param $notice_message
	 *
	 * @return string[]
	 */
	protected function process_result_fail( $function, $log_message, $notice_message ) {
		$this->log->write_log( $function, $log_message );

		wc_add_notice(
			'<p>' . $notice_message . '</p>',
			'error'
		);

		return array(
			'result'   => 'fail',
			'redirect' => '',
		);
	}

	/**
	 * Create Preference
	 *
	 * @param object $order Order.
	 * @param mixed  $custom_checkout Checkout info.
	 * @return string|array
	 */
	protected function create_preference( $order, $custom_checkout ) {
		$preferences_custom = new WC_WooMercadoPago_Preference_Custom( $this, $order, $custom_checkout );
		$preferences        = $preferences_custom->get_preference();
		try {
			$checkout_info = $this->mp->post( '/v1/payments', wp_json_encode( $preferences ) );
			$this->log->write_log( __FUNCTION__, 'Preference created: ' . wp_json_encode( $checkout_info, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE ) );
			if ( $checkout_info['status'] < 200 || $checkout_info['status'] >= 300 ) {
				$this->log->write_log( __FUNCTION__, 'mercado pago gave error, payment creation failed with error: ' . $checkout_info['response']['message'] );
				return $checkout_info['response']['message'];
			} elseif ( is_wp_error( $checkout_info ) ) {
				$this->log->write_log( __FUNCTION__, 'WordPress gave error, payment creation failed with error: ' . $checkout_info['response']['message'] );
				return $checkout_info['response']['message'];
			} else {
				$this->log->write_log( __FUNCTION__, 'payment link generated with success from mercado pago, with structure as follow: ' . wp_json_encode( $checkout_info, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE ) );
				return $checkout_info['response'];
			}
		} catch ( WC_WooMercadoPago_Exception $ex ) {
			$this->log->write_log( __FUNCTION__, 'payment creation failed with exception: ' . wp_json_encode( $ex, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE ) );
			return $ex->getMessage();
		}
	}

	/**
	 * Create Wallet Button Preference
	 *
	 * @param $order
	 *
	 * @return false|mixed
	 */
	public function create_preference_wallet_button( $order ) {
		$this->installments       = 12;
		$preference_wallet_button = new WC_WooMercadoPago_Preference_Custom_Wallet_Button( $this, $order );
		$preference               = $preference_wallet_button->get_preference();
		try {
			$checkout_info = $this->mp->create_preference( wp_json_encode( $preference ) );
			$this->log->write_log( __FUNCTION__, 'Created Preference: ' . wp_json_encode( $checkout_info, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE ) );
			if ( $checkout_info['status'] < 200 || $checkout_info['status'] >= 300 ) {
				$this->log->write_log( __FUNCTION__, 'mercado pago gave error, payment creation failed with error: ' . $checkout_info['response']['message'] );
				return false;
			} elseif ( is_wp_error( $checkout_info ) ) {
				$this->log->write_log( __FUNCTION__, 'WordPress gave error, payment creation failed with error: ' . $checkout_info['response']['message'] );
				return false;
			} else {
				$this->log->write_log( __FUNCTION__, 'payment link generated with success from mercado pago, with structure as follow: ' . wp_json_encode( $checkout_info, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE ) );
				return $checkout_info['response'];
			}
		} catch ( WC_WooMercadoPago_Exception $ex ) {
			$this->log->write_log( __FUNCTION__, 'payment creation failed with exception: ' . wp_json_encode( $ex, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE ) );
			return false;
		}
	}

	/**
	 * Is available?
	 *
	 * @return bool
	 */
	public function is_available() {
		if ( ! parent::is_available() ) {
			return false;
		}

		$_mp_access_token    = get_option( '_mp_access_token_prod' );
		$is_prod_credentials = false === WC_WooMercadoPago_Credentials::validate_credentials_test( $this->mp, $_mp_access_token, null );

		if ( ( empty( $_SERVER['HTTPS'] ) || 'off' === $_SERVER['HTTPS'] ) && $is_prod_credentials ) {
			$this->log->write_log( __FUNCTION__, 'NO HTTPS, Custom unavailable.' );
			return false;
		}

		return true;
	}

	/**
	 * Get Id
	 *
	 * @return string
	 */
	public static function get_id() {
		return self::ID;
	}
}
