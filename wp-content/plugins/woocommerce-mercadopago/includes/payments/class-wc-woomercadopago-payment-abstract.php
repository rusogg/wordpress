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
 * Class WC_WooMercadoPago_Payment_Abstract
 */
class WC_WooMercadoPago_Payment_Abstract extends WC_Payment_Gateway {

	const COMMON_CONFIGS = array(
		'_mp_public_key_test',
		'_mp_access_token_test',
		'_mp_public_key_prod',
		'_mp_access_token_prod',
		'checkout_country',
		'mp_statement_descriptor',
		'_mp_category_id',
		'_mp_store_identificator',
		'_mp_integrator_id',
		'_mp_custom_domain',
		'installments',
		'auto_return',
	);

	const CREDENTIAL_FIELDS = array(
		'_mp_public_key_test',
		'_mp_access_token_test',
		'_mp_public_key_prod',
		'_mp_access_token_prod',
	);

	const ALLOWED_CLASSES = array(
		'WC_WooMercadoPago_Basic_Gateway',
		'WC_WooMercadoPago_Custom_Gateway',
		'WC_WooMercadoPago_Ticket_Gateway',
	);

	/**
	 * Field forms order
	 *
	 * @var array
	 */
	public $field_forms_order;

	/**
	 * Id
	 *
	 * @var string
	 */
	public $id;

	/**
	 * Method Title
	 *
	 * @var string
	 */
	public $method_title;

	/**
	 * Title
	 *
	 * @var string
	 */
	public $title;

	/**
	 * Description
	 *
	 * @var string
	 */
	public $description;

	/**
	 * Payments
	 *
	 * @var array
	 */
	public $ex_payments = array();

	/**
	 * Method
	 *
	 * @var string
	 */
	public $method;

	/**
	 * Method description
	 *
	 * @var string
	 */
	public $method_description;

	/**
	 * Auto return
	 *
	 * @var string
	 */
	public $auto_return;

	/**
	 * Success url
	 *
	 * @var string
	 */
	public $success_url;

	/**
	 * Failure url
	 *
	 * @var string
	 */
	public $failure_url;

	/**
	 * Pending url
	 *
	 * @var string
	 */
	public $pending_url;

	/**
	 * Installments
	 *
	 * @var string
	 */
	public $installments = 1;

	/**
	 * Form fields
	 *
	 * @var array
	 */
	public $form_fields;

	/**
	 * Coupon Mode
	 *
	 * @var string
	 */
	public $coupon_mode;

	/**
	 * Payment Type
	 *
	 * @var string
	 */
	public $payment_type;

	/**
	 * Checkout type
	 *
	 * @var string
	 */
	public $checkout_type;

	/**
	 * Stock reduce mode
	 *
	 * @var string
	 */
	public $stock_reduce_mode;

	/**
	 * Expiration date
	 *
	 * @var int
	 */
	public $date_expiration;

	/**
	 * Hook
	 *
	 * @var WC_WooMercadoPago_Hook_Abstract
	 */
	public $hook;

	/**
	 * Supports
	 *
	 * @var string[]
	 */
	public $supports;

	/**
	 * Icon
	 *
	 * @var mixed
	 */
	public $icon;

	/**
	 * Category Id
	 *
	 * @var mixed|string
	 */
	public $mp_category_id;

	/**
	 * Store Identificator
	 *
	 * @var mixed|string
	 */
	public $store_identificator;

	/**
	 * Integrator Id
	 *
	 * @var mixed|string
	 */
	public $integrator_id;

	/**
	 * Is debug mode
	 *
	 * @var mixed|string
	 */
	public $debug_mode;

	/**
	 * Custom domain
	 *
	 * @var mixed|string
	 */
	public $custom_domain;

	/**
	 * Is binary mode
	 *
	 * @var mixed|string
	 */
	public $binary_mode;

	/**
	 * Gateway discount
	 *
	 * @var mixed|string
	 */
	public $gateway_discount;

	/**
	 * Site data
	 *
	 * @var string|null
	 */
	public $site_data;

	/**
	 * Logs
	 *
	 * @var WC_WooMercadoPago_Log
	 */
	public $log;

	/**
	 * Is sandbox?
	 *
	 * @var bool
	 */
	public $sandbox;

	/**
	 * Mercado Pago
	 *
	 * @var MP|null
	 */
	public $mp;

	/**
	 * Public key test
	 *
	 * @var mixed|string
	 */
	public $mp_public_key_test;

	/**
	 * Access token test
	 *
	 * @var mixed|string
	 */
	public $mp_access_token_test;

	/**
	 * Public key prod
	 *
	 * @var mixed|string
	 */
	public $mp_public_key_prod;

	/**
	 * Access token prod
	 *
	 * @var mixed|string
	 */
	public $mp_access_token_prod;

	/**
	 * Notification
	 *
	 * @var WC_WooMercadoPago_Notification_Abstract
	 */
	public $notification;

	/**
	 * Checkout country
	 *
	 * @var string
	 */
	public $checkout_country;

	/**
	 * Country
	 *
	 * @var string
	 */
	public $wc_country;

	/**
	 * Comission
	 *
	 * @var mixed|string
	 */
	public $commission;

	/**
	 * Application Id
	 *
	 * @var string
	 */
	public $application_id;

	/**
	 * Type payments
	 *
	 * @var string
	 */
	public $type_payments;

	/**
	 * Actived payments
	 *
	 * @var array
	 */
	public $activated_payment;

	/**
	 * Is validate homolog
	 *
	 * @var int|mixed
	 */
	public $homolog_validate;

	/**
	 * Client Id old version
	 *
	 * @var string
	 */
	public $clientid_old_version;

	/**
	 * Customer
	 *
	 * @var array|mixed|null
	 */
	public $customer;

	/**
	 * Logged user
	 *
	 * @var string|null
	 */
	public $logged_user_email;

	/**
	 * Currency convertion?
	 *
	 * @var boolean
	 */
	public $currency_convertion;

	/**
	 * WC_WooMercadoPago_PaymentAbstract constructor.
	 *
	 * @throws WC_WooMercadoPago_Exception Load payment exception.
	 */
	public function __construct() {
		$this->mp_public_key_test   = $this->get_option_mp( '_mp_public_key_test' );
		$this->mp_access_token_test = $this->get_option_mp( '_mp_access_token_test' );
		$this->mp_public_key_prod   = $this->get_option_mp( '_mp_public_key_prod' );
		$this->mp_access_token_prod = $this->get_option_mp( '_mp_access_token_prod' );
		$this->checkout_country     = get_option( 'checkout_country', '' );
		$this->wc_country           = get_option( 'woocommerce_default_country', '' );
		$this->mp_category_id       = $this->get_option_mp( '_mp_category_id', 0 );
		$this->store_identificator  = $this->get_option_mp( '_mp_store_identificator', 'WC-' );
		$this->integrator_id        = $this->get_option_mp( '_mp_integrator_id', '' );
		$this->debug_mode           = $this->get_option_mp( '_mp_debug_mode', 'no' );
		$this->custom_domain        = $this->get_option_mp( '_mp_custom_domain', '' );
		$this->binary_mode          = $this->get_option_mp( 'binary_mode', 'no' );
		$this->gateway_discount     = $this->get_option_mp( 'gateway_discount', 0 );
		$this->commission           = $this->get_option_mp( 'commission', 0 );
		$this->sandbox              = $this->is_test_user();
		$this->supports             = array( 'products', 'refunds' );
		$this->icon                 = $this->get_mp_icon();
		$this->site_data            = WC_WooMercadoPago_Module::get_site_data();
		$this->log                  = new WC_WooMercadoPago_Log( $this );
		$this->mp                   = $this->get_mp_instance();
		$this->homolog_validate     = $this->get_homolog_validate();
		$this->application_id       = $this->get_application_id( $this->mp_access_token_prod );
		$this->logged_user_email    = ( 0 !== wp_get_current_user()->ID ) ? wp_get_current_user()->user_email : null;
		$this->discount_action_url  = get_site_url() . '/index.php/woocommerce-mercadopago/?wc-api=' . get_class( $this );
	}

	/**
	 * Get Homolog Validate
	 *
	 * @return mixed
	 * @throws WC_WooMercadoPago_Exception Homolog validate exception.
	 */
	public function get_homolog_validate() {
		$homolog_validate = (int) get_option( 'homolog_validate', 0 );
		if ( ( $this->is_production_mode() && ! empty( $this->mp_access_token_prod ) ) && 0 === $homolog_validate ) {
			if ( $this->mp instanceof MP ) {
				$homolog_validate = $this->mp->get_credentials_wrapper( $this->mp_access_token_prod );
				$homolog_validate = isset( $homolog_validate['homologated'] ) && true === $homolog_validate['homologated'] ? 1 : 0;
				update_option( 'homolog_validate', $homolog_validate, true );
				return $homolog_validate;
			}
			return 0;
		}
		return 1;
	}

	/**
	 * Get Access token
	 *
	 * @return mixed|string
	 */
	public function get_access_token() {
		if ( ! $this->is_production_mode() ) {
			return $this->mp_access_token_test;
		}
		return $this->mp_access_token_prod;
	}

	/**
	 * Public key
	 *
	 * @return mixed|string
	 */
	public function get_public_key() {
		if ( ! $this->is_production_mode() ) {
			return $this->mp_public_key_test;
		}
		return $this->mp_public_key_prod;
	}

	/**
	 * Get options Mercado Pago
	 *
	 * @param string $key key.
	 * @param string $default default.
	 * @return mixed|string
	 */
	public function get_option_mp( $key, $default = '' ) {
		$wordpress_configs = self::COMMON_CONFIGS;
		if ( in_array( $key, $wordpress_configs, true ) ) {
			return get_option( $key, $default );
		}

		$option = $this->get_option( $key, $default );
		if ( ! empty( $option ) ) {
			return $option;
		}

		return get_option( $key, $default );
	}

	/**
	 * Normalize fields in admin
	 */
	public function normalize_common_admin_fields() {
		if ( empty( $this->mp_access_token_test ) && empty( $this->mp_access_token_prod ) ) {
			if ( isset( $this->settings['enabled'] ) && 'yes' === $this->settings['enabled'] ) {
				$this->settings['enabled'] = 'no';
				$this->disable_all_payments_methods_mp();
			}
		}

		$changed = false;
		foreach ( self::COMMON_CONFIGS as $config ) {
			$common_option = get_option( $config );
			if ( isset( $this->settings[ $config ] ) && $this->settings[ $config ] !== $common_option ) {
				$changed                   = true;
				$this->settings[ $config ] = $common_option;
			}
		}

		if ( $changed ) {
			update_option( $this->get_option_key(), apply_filters( 'woocommerce_settings_api_sanitized_fields_' . $this->id, $this->settings ) );
		}
	}

	/**
	 * Validate section
	 *
	 * @return bool
	 */
	public function validate_section() {
		if (
				// @todo needs processing form data without nonce verification.
				// @codingStandardsIgnoreLine
				isset( $_GET['section'] ) && ! empty( $_GET['section']
				)
			&& (
				// @todo needs processing form data without nonce verification.
				// @codingStandardsIgnoreLine
				$this->id !== $_GET['section'] ) && ! in_array( $_GET['section'], self::ALLOWED_CLASSES )
			) {
			return false;
		}

		return true;
	}

	/**
	 * Is manage section?
	 *
	 * @return bool
	 */
	public function is_manage_section() {
		// @todo needs processing form data without nonce verification.
		// @codingStandardsIgnoreLine
		if ( ! isset( $_GET['section'] ) || ( $this->id !== $_GET['section'] ) && ! in_array( $_GET['section'], self::ALLOWED_CLASSES )
		) {
			return false;
		}

		return true;
	}

	/**
	 * Get Mercado Pago Logo
	 *
	 * @return string
	 */
	public function get_mp_logo() {
		return '<img width="200" height="52" src="' . plugins_url( '../assets/images/mplogo.png', plugin_dir_path( __FILE__ ) ) . '"><br><br>';
	}

	/**
	 * Get Mercado Pago Icon
	 *
	 * @return mixed
	 */
	public function get_mp_icon() {
		return apply_filters( 'woocommerce_mercadopago_icon', plugins_url( '../assets/images/mercadopago.png', plugin_dir_path( __FILE__ ) ) );
	}

	/**
	 * Update Option
	 *
	 * @param string $key key.
	 * @param string $value value.
	 * @return bool
	 */
	public function update_option( $key, $value = '' ) {
		if ( 'enabled' === $key && 'yes' === $value ) {
			if ( empty( $this->mp->get_access_token() ) ) {
				$message = __( 'Configure your credentials to enable Mercado Pago payment methods.', 'woocommerce-mercadopago' );
				$this->log->write_log( __FUNCTION__, $message );
				echo wp_json_encode(
					array(
						'success' => false,
						'data'    => $message,
					)
				);
				die();
			}
		}
		return parent::update_option( $key, $value );
	}

	/**
	 *  ADMIN NOTICE HOMOLOG
	 */
	public function notice_homolog_validate() {
		$type = 'notice-warning';
		/* translators: %s url */
		$message = sprintf( __( '%s, it only takes a few minutes', 'woocommerce-mercadopago' ), '<a class="mp-mouse_pointer" href="https://www.mercadopago.com/' . $this->checkout_country . '/account/credentials/appliance?application_id=' . $this->application_id . '" target="_blank"><b><u>' . __( 'Approve your account', 'woocommerce-mercadopago' ) . '</u></b></a>' );
		WC_WooMercadoPago_Notices::get_alert_frame( $message, $type );
	}

	/**
	 * Get Mercado Pago form fields
	 *
	 * @param string $label label.
	 * @return array
	 */
	public function get_form_mp_fields( $label ) {
		$this->init_form_fields();
		$this->init_settings();
		$form_fields                           = array();
		$form_fields['checkout_steps']         = $this->field_checkout_steps();
		$form_fields['checkout_country_title'] = $this->field_checkout_country_title();
		$form_fields['checkout_country']       = $this->field_checkout_country( $this->wc_country, $this->checkout_country );
		$form_fields['checkout_btn_save']      = $this->field_checkout_btn_save();

		if ( ! empty( $this->checkout_country ) ) {
			$this->load_custom_js_for_checkbox();

			$form_fields['checkout_credential_title']            = $this->field_checkout_credential_title();
			$form_fields['checkout_mode_title']                  = $this->field_checkout_mode_title();
			$form_fields['checkout_subtitle_checkout_mode']      = $this->field_subtitle_checkout_mode();
			$form_fields['checkbox_checkout_test_mode']          = $this->field_checkbox_checkout_test_mode();
			$form_fields['checkbox_checkout_production_mode']    = $this->field_checkbox_checkout_production_mode();
			$form_fields['checkout_mode_alert']                  = $this->field_admin_checkout_mode_alert();
			$form_fields['checkout_credential_link']             = $this->field_checkout_credential_link( $this->checkout_country );
			$form_fields['checkout_credential_title_test']       = $this->field_checkout_credential_title_test();
			$form_fields['checkout_credential_description_test'] = $this->field_checkout_credential_description_test();
			$form_fields['_mp_public_key_test']                  = $this->field_checkout_credential_publickey_test();
			$form_fields['_mp_access_token_test']                = $this->field_checkout_credential_accesstoken_test();
			$form_fields['checkout_credential_title_prod']       = $this->field_checkout_credential_title_prod();
			$form_fields['checkout_credential_description_prod'] = $this->field_checkout_credential_description_prod();
			$form_fields['_mp_public_key_prod']                  = $this->field_checkout_credential_publickey_prod();
			$form_fields['_mp_access_token_prod']                = $this->field_checkout_credential_accesstoken_prod();
			if ( ! empty( $this->get_access_token() ) && ! empty( $this->get_public_key() ) ) {
				if ( 0 === $this->homolog_validate ) {
					// @todo needs processing form data without nonce verification.
					// @codingStandardsIgnoreLine
					if ( isset( $_GET['section'] ) && $_GET['section'] == $this->id && ! has_action( 'woocommerce_update_options_payment_gateways_' . $this->id ) ) {
						add_action( 'admin_notices', array( $this, 'notice_homolog_validate' ) );
					}
					$form_fields['checkout_steps_link_homolog'] = $this->field_checkout_steps_link_homolog( $this->checkout_country, $this->application_id );
					$form_fields['checkout_homolog_title']      = $this->field_checkout_homolog_title();
					$form_fields['checkout_homolog_subtitle']   = $this->field_checkout_homolog_subtitle();
					$form_fields['checkout_homolog_link']       = $this->field_checkout_homolog_link( $this->checkout_country, $this->application_id );
				}
				$form_fields['_mp_category_id']                        = $this->field_category_store();
				$form_fields['mp_statement_descriptor']                = $this->field_mp_statement_descriptor();
				$form_fields['_mp_store_identificator']                = $this->field_mp_store_identificator();
				$form_fields['_mp_integrator_id']                      = $this->field_mp_integrator_id();
				$form_fields['checkout_advanced_settings']             = $this->field_checkout_advanced_settings();
				$form_fields['_mp_debug_mode']                         = $this->field_debug_mode();
				$form_fields['enabled']                                = $this->field_enabled( $label );
				$form_fields['title']                                  = $this->field_title();
				$form_fields['description']                            = $this->field_description();
				$form_fields['_mp_custom_domain']                      = $this->field_custom_url_ipn();
				$form_fields['gateway_discount']                       = $this->field_gateway_discount();
				$form_fields['commission']                             = $this->field_commission();
				$form_fields['checkout_payments_advanced_description'] = $this->field_checkout_payments_advanced_description();
				$form_fields['checkout_support_title']                 = $this->field_checkout_support_title();
				$form_fields['checkout_support_description']           = $this->field_checkout_support_description();
				$form_fields['checkout_support_description_link']      = $this->field_checkout_support_description_link();
				$form_fields['checkout_support_problem']               = $this->field_checkout_support_problem();
				if ( ! $this->is_production_mode() && isset( $this->settings['enabled'] ) && 'yes' === $this->settings['enabled'] ) {
				$form_fields['checkout_ready_title']            = $this->field_checkout_ready_title();
				$form_fields['checkout_ready_description']      = $this->field_checkout_ready_description();
				$form_fields['checkout_ready_description_link'] = $this->field_checkout_ready_description_link();
				}
				$form_fields[ WC_WooMercadoPago_Helpers_CurrencyConverter::CONFIG_KEY ] = $this->field_currency_conversion( $this );
			}
		}

		if ( is_admin() ) {
			$this->normalize_common_admin_fields();
		}

		return $form_fields;
	}

	/**
	 * Field title
	 *
	 * @return array
	 */
	public function field_title() {
		$field_title = array(
			'title'       => __( 'Title', 'woocommerce-mercadopago' ),
			'type'        => 'text',
			'description' => __('Change the display text in Checkout, maximum characters: 85', 'woocommerce-mercadopago'),
			'maxlength'   => 100,
			'desc_tip'    => __( 'If you change the display text, no translatation will be available', 'woocommerce-mercadopago' ),
			'class'       => 'limit-title-max-length',
			'default'     => $this->title,
		);
		return $field_title;
	}

	/**
	 * Field description
	 *
	 * @return array
	 */
	public function field_description() {
		$field_description = array(
			'title'       => __( 'Description', 'woocommerce-mercadopago' ),
			'type'        => 'text',
			'class'       => 'hidden-field-mp-desc',
			'description' => '',
			'default'     => $this->method_description,
		);
		return $field_description;
	}

	/**
	 * Sort form fields
	 *
	 * @param array $form_fields fields.
	 * @param array $ordination ordination.
	 *
	 * @return array
	 */
	public function sort_form_fields( $form_fields, $ordination ) {
		$array = array();
		foreach ( $ordination as $order => $key ) {
			if ( ! isset( $form_fields[ $key ] ) ) {
				continue;
			}
			$array[ $key ] = $form_fields[ $key ];
			unset( $form_fields[ $key ] );
		}
		return array_merge_recursive( $array, $form_fields );
	}

	/**
	 * Field checkout steps
	 *
	 * @return array
	 */
	public function field_checkout_steps() {
		$steps_content = wc_get_template_html(
			'checkout/credential/steps.php',
			array(
				'title'                        => __( 'Follow these steps to activate Mercado Pago in your store:', 'woocommerce-mercadopago' ),
				'upload_credentials_highlight' => __( 'Upload your credentials', 'woocommerce-mercadopago' ),
				'upload_credentials'           => __( 'depending on the country in which you are registered.', 'woocommerce-mercadopago' ),
				'approve_account_highlight'    => __( 'Approve your account', 'woocommerce-mercadopago' ),
				'approve_account'              => __( 'to be able to charge.', 'woocommerce-mercadopago' ),
				'basic_information_highlight'  => __( 'Add the basic information of your business', 'woocommerce-mercadopago' ),
				'basic_information'            => __( 'in the plugin configuration.', 'woocommerce-mercadopago' ),
				'payment_preference_highlight' => __( 'Configure the payment preferences', 'woocommerce-mercadopago' ),
				'payment_preference'           => __( 'for your customers.', 'woocommerce-mercadopago' ),
				'advanced_settings_highlight'  => __( 'Go to advanced settings', 'woocommerce-mercadopago' ),
				'advanced_settings'            => __( 'only when you want to change the presets.', 'woocommerce-mercadopago' ),
			),
			'woo/mercado/pago/steps/',
			WC_WooMercadoPago_Module::get_templates_path()
		);

		return array(
			'title' => $steps_content,
			'type'  => 'title',
			'class' => 'mp_title_checkout',
		);
	}

	/**
	 * Field checkout steps link homolog
	 *
	 * @param string $country_link country link.
	 * @param string $appliocation_id application id.
	 *
	 * @return array
	 */
	public function field_checkout_steps_link_homolog( $country_link, $appliocation_id ) {
		$checkout_steps_link_homolog = array(
			'title' => sprintf(
				/* translators: %s link  */
				__( 'Credentials are the keys we provide you to integrate quickly <br>and securely. You must have a %s in Mercado Pago to obtain and collect them <br>on your website. You do not need to know how to design or program to do it', 'woocommerce-mercadopago' ),
				'<a href="https://www.mercadopago.com/' . $country_link . '/account/credentials/appliance?application_id=' . $appliocation_id . '" target="_blank">' . __( 'approved account', 'woocommerce-mercadopago' ) . '</a>'
			),
			'type'  => 'title',
			'class' => 'mp_homolog_text',
		);

		array_splice( $this->field_forms_order, 4, 0, 'checkout_steps_link_homolog' );
		return $checkout_steps_link_homolog;
	}

	/**
	 * Field Checkout Country Title
	 *
	 * @return array
	 */
	public function field_checkout_country_title() {
		return array(
			'title' => __( 'In which country does your Mercado Pago account operate?', 'woocommerce-mercadopago' ),
			'type'  => 'title',
			'class' => 'mp_subtitle_bd',
		);
	}

	/**
	 * Field checkout country
	 *
	 * @param string $wc_country country.
	 * @param string $checkout_country checkout country.
	 *
	 * @return array
	 */
	public function field_checkout_country( $wc_country, $checkout_country ) {
		$country = array(
			'AR' => 'mla', // Argentinian.
			'BR' => 'mlb', // Brazil.
			'CL' => 'mlc', // Chile.
			'CO' => 'mco', // Colombia.
			'MX' => 'mlm', // Mexico.
			'PE' => 'mpe', // Peru.
			'UY' => 'mlu', // Uruguay.
		);

		$country_default = '';
		if ( ! empty( $wc_country ) && empty( $checkout_country ) ) {
			$country_default = strlen( $wc_country ) > 2 ? substr( $wc_country, 0, 2 ) : $wc_country;
			$country_default = array_key_exists( $country_default, $country ) ? $country[ $country_default ] : 'mla';
		}

		$checkout_country = array(
			'title'       => __( 'Select your country', 'woocommerce-mercadopago' ),
			'type'        => 'select',
			'description' => __( 'Select the country in which you operate with Mercado Pago', 'woocommerce-mercadopago' ),
			'default'     => empty( $checkout_country ) ? $country_default : $checkout_country,
			'options'     => array(
				'mla' => __( 'Argentina', 'woocommerce-mercadopago' ),
				'mlb' => __( 'Brazil', 'woocommerce-mercadopago' ),
				'mlc' => __( 'Chile', 'woocommerce-mercadopago' ),
				'mco' => __( 'Colombia', 'woocommerce-mercadopago' ),
				'mlm' => __( 'Mexico', 'woocommerce-mercadopago' ),
				'mpe' => __( 'Peru', 'woocommerce-mercadopago' ),
				'mlu' => __( 'Uruguay', 'woocommerce-mercadopago' ),
			),
		);
		return $checkout_country;
	}

	/**
	 * Get Application Id
	 *
	 * @param string $mp_access_token_prod access token.
	 *
	 * @return mixed|string
	 * @throws WC_WooMercadoPago_Exception Application Id not found exception.
	 */
	public function get_application_id( $mp_access_token_prod ) {
		if ( empty( $mp_access_token_prod ) ) {
			return '';
		} else {
			$application_id = get_option('mp_application_id', '');
			if ( $application_id && '' !== $application_id ) {
				return $application_id;
			}
			$application_id = $this->mp->get_credentials_wrapper( $this->mp_access_token_prod );
			if ( is_array( $application_id ) && isset( $application_id['client_id'] ) ) {
				update_option('mp_application_id', $application_id['client_id']);
				return $application_id['client_id'];
			}
			return '';
		}
	}

	/**
	 * Field Checkout Button Save
	 *
	 * @return array
	 */
	public function field_checkout_btn_save() {
		$btn_save = '<button name="save" class="button button-primary" type="submit" value="Save changes">' . __( 'Save Changes', 'woocommerce-mercadopago' ) . '</button>';

		$wc = WC_WooMercadoPago_Module::woocommerce_instance();
		if ( version_compare( $wc->version, '4.4' ) >= 0 ) {
			$btn_save = '<div name="save" class="button-primary mp-save-button" type="submit" value="Save changes">' . __( 'Save Changes', 'woocommerce-mercadopago' ) . '</div>';
		}

		return array(
			'title' => sprintf( '%s', $btn_save ),
			'type'  => 'title',
			'class' => '',
		);
	}

	/**
	 * Field enabled
	 *
	 * @param string $label label.
	 * @return array
	 */
	public function field_enabled( $label ) {
		$title_enable = __( 'Activate checkout', 'woocommerce-mercadopago' );
		if ( 'Pix' === $label ) {
			$title_enable = __( 'Activate Pix in the checkout', 'woocommerce-mercadopago' );
		}

		return array(
			'title'       => $title_enable,
			'type'        => 'select',
			'default'     => 'no',
			'description' => __( 'Activate the Mercado Pago experience at the checkout of your store.', 'woocommerce-mercadopago' ),
			'options'     => array(
				'no'  => __( 'No', 'woocommerce-mercadopago' ),
				'yes' => __( 'Yes', 'woocommerce-mercadopago' ),
			),
		);
	}

	/**
	 * Field checkout credential title
	 *
	 * @return array
	 */
	public function field_checkout_credential_title() {
		return array(
			'title' => __( 'Add credentials to &quot;Test Mode&quot; or &quot;Production Mode&quot;', 'woocommerce-mercadopago' ),
			'type'  => 'title',
			'class' => 'mp_subtitle_bd',
		);
	}

	/**
	 * Field checkout mode title
	 *
	 * @return array
	 */
	public function field_checkout_mode_title() {
		return array(
			'title' => __( 'Set up store payments for Test or Production Mode', 'woocommerce-mercadopago' ),
			'type'  => 'title',
			'class' => 'mp_subtitle_bd',
		);
	}

	/**
	 * Get sufix to static files
	 *
	 * @return String
	 */
	private function get_suffix() {
		return defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	}

	/**
	 * Load Custom JS For Checkbox
	 *
	 * @return void
	 */
	private function load_custom_js_for_checkbox() {
		wp_enqueue_script(
			'custom_checkbox_checkout_mode',
			plugins_url( '../assets/js/custom_checkbox_checkout_mode' . $this->get_suffix() . '.js', plugin_dir_path( __FILE__ ) ),
			array(),
			WC_WooMercadoPago_Constants::VERSION,
			true
		);
	}

	/**
	 * Field subtitle checkout mode
	 *
	 * @return Array
	 */
	public function field_subtitle_checkout_mode() {
		return array(
			'title' => __( 'How would you like to handle your store checkouts?', 'woocommerce-mercadopago' ),
			'type'  => 'title'
		);
	}

	/**
	 * Field checkout mode production
	 *
	 * @return Array
	 */
	public function field_checkbox_checkout_production_mode() {
		$previously_configured_plugin = 'woo-mercado-pago-basic' === $this->id && $this->clientid_old_version;
		$mode                         = $this->is_production_mode() || $previously_configured_plugin ? 'production' : 'test';
		$isCheckedCSSClass            = 'production' === $mode ? 'checked' : '';

		return array(
			'label' => "<b id='checkout-mode-checkbox-production' class='{$isCheckedCSSClass}'>"
				. __( 'Activate Production Mode for Mercado Pago checkouts', 'woocommerce-mercadopago' )
				. '</b>',
			'description' => '<span>'
				. __(
					'Mercado Pago checkouts are active for real payments.',
					'woocommerce-mercadopago'
				)
				. '</span>',
			'type' => 'checkbox',
			'css' => 'border-radius: 50%; outline: none;',
		);
	}

	/**
	 * Field checkout mode test
	 *
	 * @return Array
	 */
	public function field_checkbox_checkout_test_mode() {
		$previously_configured_plugin = 'woo-mercado-pago-basic' === $this->id && $this->clientid_old_version;
		$mode                         = $this->is_production_mode() || $previously_configured_plugin ? 'production' : 'test';
		$isCheckedCSSClass            = 'test' === $mode ? 'checked' : '';
		$testGuideLines               = '<a style="text-decoration: none; outline: none;" target="_blank" href="'
			. $this->get_mp_devsite_link($this->checkout_country) . '" >'
			. __('test mode guidelines.', 'woocommerce-mercadopago')
			. '</a>';

		return array(
			'label' => "<b id='checkout-mode-checkbox-test' class='{$isCheckedCSSClass}'>"
				. __( 'Activate Test Mode for Mercado Pago checkouts', 'woocommerce-mercadopago' )
				. '</b>',
			'description' => '<span>'
				. __(
					'Mercado Pago checkouts are inactive for real payments in the Test Mode. Please check the',
					'woocommerce-mercadopago'
				) . ' ' . $testGuideLines
				. '</span>',
			'type' => 'checkbox',
			'css' => 'border-radius: 50%; outline: none;',
		);
	}

	/**
	 * Field checkout credential link
	 *
	 * @param string $country country.
	 *
	 * @return array
	 */
	public function field_checkout_credential_link( $country ) {
		$link_content = wc_get_template_html(
			'checkout/credential/link.php',
			array(
				'label'   => __( 'Load credentials', 'woocommerce-mercadopago' ),
				'country' => $country,
				'text'    => __( 'Search my credentials', 'woocommerce-mercadopago' ),
			),
			'woo/mercado/pago/link/',
			WC_WooMercadoPago_Module::get_templates_path()
		);

		return array(
			'title' => $link_content,
			'type'  => 'title',
		);
	}

	/**
	 * Field checkout credential title test
	 *
	 * @return array
	 */
	public function field_checkout_credential_title_test() {
		return array(
			'title' => __( 'Test credentials', 'woocommerce-mercadopago' ),
			'type'  => 'title',
		);
	}

	/**
	 * Field checkout credential description test
	 *
	 * @return array
	 */
	public function field_checkout_credential_description_test() {
		return array(
			'title' => __( 'With these credentials, you enable payment simulations in your Mercado Pago checkouts.', 'woocommerce-mercadopago' ),
			'type'  => 'title',
			'class' => 'mp_small_text mp-mt--12',
		);
	}

	/**
	 * Field checkout credential public key test
	 *
	 * @return array
	 */
	public function field_checkout_credential_publickey_test() {
		return array(
			'title'       => __( 'Public key', 'woocommerce-mercadopago' ),
			'type'        => 'text',
			'description' => '',
			'default'     => $this->get_option_mp( '_mp_public_key_test', '' ),
			'placeholder' => 'TEST-00000000-0000-0000-0000-000000000000',
			'class'       => 'mp_credential_test_input',
		);
	}

	/**
	 * Field checkout credential access token test
	 *
	 * @return array
	 */
	public function field_checkout_credential_accesstoken_test() {
		return array(
			'title'       => __( 'Access token', 'woocommerce-mercadopago' ),
			'type'        => 'text',
			'description' => '',
			'default'     => $this->get_option_mp( '_mp_access_token_test', '' ),
			'placeholder' => 'TEST-000000000000000000000000000000000-000000-00000000000000000000000000000000-000000000',
			'class'       => 'mp_credential_test_input',
		);
	}

	/**
	 * Field checkout credential title prod
	 *
	 * @return array
	 */
	public function field_checkout_credential_title_prod() {
		return array(
			'title' => __( 'Production Credentials', 'woocommerce-mercadopago' ),
			'type'  => 'title',
		);
	}

	/**
	 * Field checkout credential description prod
	 *
	 * @return array
	 */
	public function field_checkout_credential_description_prod() {
		return array(
			'title' => __( 'With these credentials, you enable your Mercado Pago checkouts to receive real payments.', 'woocommerce-mercadopago' ),
			'type'  => 'title',
			'class' => 'mp_small_text mp-mt--12',
		);
	}

	/**
	 * Field checkout credential public key prod
	 *
	 * @return array
	 */
	public function field_checkout_credential_publickey_prod() {
		return array(
			'title'       => __( 'Public key', 'woocommerce-mercadopago' ),
			'type'        => 'text',
			'description' => '',
			'default'     => $this->get_option_mp( '_mp_public_key_prod', '' ),
			'placeholder' => 'APP-USR-00000000-0000-0000-0000-000000000000',
			'class'       => 'mp_credential_prod_input',
		);
	}

	/**
	 * Field checkout credential access token prod
	 *
	 * @return array
	 */
	public function field_checkout_credential_accesstoken_prod() {
		return array(
			'title'       => __( 'Access token', 'woocommerce-mercadopago' ),
			'type'        => 'text',
			'description' => '',
			'default'     => $this->get_option_mp( '_mp_access_token_prod', '' ),
			'placeholder' => 'APP-USR-000000000000000000000000000000000-000000-00000000000000000000000000000000-000000000',
			'class'       => 'mp_credential_prod_input',
		);
	}

	/**
	 * Field Checkout Homolog Title
	 *
	 * @return array
	 */
	public function field_checkout_homolog_title() {
		return array(
			'title' => __( 'Approve your account, it will only take a few minutes', 'woocommerce-mercadopago' ),
			'type'  => 'title',
			'class' => 'mp_subtitle_bd',
		);
	}

	/**
	 * Field Checkout Homolog Subtitle
	 *
	 * @return array
	 */
	public function field_checkout_homolog_subtitle() {
		return array(
			'title' => __( 'Complete this process to secure your customers data and comply with the regulations<br> and legal provisions of each country.', 'woocommerce-mercadopago' ),
			'type'  => 'title',
			'class' => 'mp_text mp-mt--12',
		);
	}

	/**
	 * Field Checkout Homolog Link
	 *
	 * @param string $country_link Country Link.
	 * @param string $appliocation_id Application Id.
	 * @return array
	 */
	public function field_checkout_homolog_link( $country_link, $appliocation_id ) {
		return array(
			'title' => sprintf(
				'%s',
				'<a href="https://www.mercadopago.com/' . $country_link . '/account/credentials/appliance?application_id=' . $appliocation_id . '" target="_blank">' . __( 'Homologate account in Mercado Pago', 'woocommerce-mercadopago' ) . '</a>'
			),
			'type'  => 'title',
			'class' => 'mp_tienda_link',
		);
	}

	/**
	 * Field MP Statement Descriptor
	 *
	 * @return array
	 */
	public function field_mp_statement_descriptor() {
		return array(
			'title'       => __( 'Store name', 'woocommerce-mercadopago' ),
			'type'        => 'text',
			'description' => __( 'This name will appear on your customers invoice.', 'woocommerce-mercadopago' ),
			'default'     => $this->get_option_mp( 'mp_statement_descriptor', __( 'Mercado Pago', 'woocommerce-mercadopago' ) ),
		);
	}

	/**
	 * Field Category Store
	 *
	 * @return array
	 */
	public function field_category_store() {
		$category_store       = WC_WooMercadoPago_Module::$categories;
		$category_description = array_map( array( $this, 'translate_categories' ), $category_store['store_categories_description'] );
		$option_category      = array_combine( $category_store['store_categories_id'], $category_description );

		return array(
			'title'       => __( 'Store Category', 'woocommerce-mercadopago' ),
			'type'        => 'select',
			'description' => __( 'What category do your products belong to? Choose the one that best characterizes them (choose "other" if your product is too specific).', 'woocommerce-mercadopago' ),
			'default'     => $this->get_option_mp( '_mp_category_id', __( 'Categories', 'woocommerce-mercadopago' ) ),
			'options'     => $option_category,
		);
	}

	/**
	 * Translate categories
	 *
	 * @param string $category Category name.
	 * @return mixed
	 */
	public function translate_categories( $category ) {
		// @todo need fix The $text arg must be a single string literal, not $category
		// @codingStandardsIgnoreLine
		return __( $category );
	}

	/**
	 * Field MP Store Identificator
	 *
	 * @return array
	 */
	public function field_mp_store_identificator() {
		return array(
			'title'       => __( 'Store ID', 'woocommerce-mercadopago' ),
			'type'        => 'text',
			'description' => __( 'Use a number or prefix to identify orders and payments from this store.', 'woocommerce-mercadopago' ),
			'default'     => $this->get_option_mp( '_mp_store_identificator', 'WC-' ),
		);
	}

	/**
	 * Field MP Integrator Id
	 *
	 * @return array
	 */
	public function field_mp_integrator_id() {
		$links_mp = WC_WooMercadoPago_Module::define_link_country();

		return array(
			'title'       => __( 'Integrator ID', 'woocommerce-mercadopago' ),
			'type'        => 'text',
			'description' => sprintf(
				/* translators: %s developers guide */
				__( 'Do not forget to enter your integrator_id as a certified Mercado Pago Partner. If you don`t have it, you can %s', 'woocommerce-mercadopago' ),
				'<a target="_blank" href="https://www.mercadopago.' . $links_mp['sufix_url'] . 'developers/' . $links_mp['translate'] . '/guides/plugins/woocommerce/preferences/#bookmark_informações_do_negócio">' . __( 'request it now.', 'woocommerce-mercadopago' ) .
					'</a>'
			),
			'default'     => $this->get_option_mp( '_mp_integrator_id', '' ),
		);
	}

	/**
	 * Field Checkout Advanced Settings
	 *
	 * @return array
	 */
	public function field_checkout_advanced_settings() {
		return array(
			'title' => __( 'Advanced adjustment', 'woocommerce-mercadopago' ),
			'type'  => 'title',
			'class' => 'mp_subtitle_bd',
		);
	}

	/**
	 * Field Debug Mode
	 *
	 * @return array
	 */
	public function field_debug_mode() {
		return array(
			'title'       => __( 'Debug and Log mode', 'woocommerce-mercadopago' ),
			'type'        => 'select',
			'default'     => 'no',
			'description' => __( 'Record your store actions in our changes file to have more support information.', 'woocommerce-mercadopago' ),
			'desc_tip'    => __( 'We debug the information in our change file.', 'woocommerce-mercadopago' ),
			'options'     => array(
				'no'  => __( 'No', 'woocommerce-mercadopago' ),
				'yes' => __( 'Yes', 'woocommerce-mercadopago' ),
			),
		);
	}

	/**
	 * Field Checkout Payments Subtitle
	 *
	 * @return array
	 */
	public function field_checkout_payments_subtitle() {
		return array(
			'title' => __( 'Basic Configuration', 'woocommerce-mercadopago' ),
			'type'  => 'title',
			'class' => 'mp_subtitle mp-mt-5 mp-mb-0',
		);
	}

	/**
	 * Field Installments
	 *
	 * @return array
	 */
	public function field_installments() {
		return array(
			'title'       => __( 'Max of installments', 'woocommerce-mercadopago' ),
			'type'        => 'select',
			'description' => __( 'What is the maximum quota with which a customer can buy?', 'woocommerce-mercadopago' ),
			'default'     => '24',
			'options'     => array(
				'1'  => __( '1x installment', 'woocommerce-mercadopago' ),
				'2'  => __( '2x installments', 'woocommerce-mercadopago' ),
				'3'  => __( '3x installments', 'woocommerce-mercadopago' ),
				'4'  => __( '4x installments', 'woocommerce-mercadopago' ),
				'5'  => __( '5x installments', 'woocommerce-mercadopago' ),
				'6'  => __( '6x installments', 'woocommerce-mercadopago' ),
				'10' => __( '10x installments', 'woocommerce-mercadopago' ),
				'12' => __( '12x installments', 'woocommerce-mercadopago' ),
				'15' => __( '15x installments', 'woocommerce-mercadopago' ),
				'18' => __( '18x installments', 'woocommerce-mercadopago' ),
				'24' => __( '24x installments', 'woocommerce-mercadopago' ),
			),
		);
	}

	/**
	 * Get Country Link Guide
	 *
	 * @param string $checkout Checkout by country.
	 * @return string
	 */
	public function get_country_link_guide( $checkout ) {
		$country_link = array(
			'mla' => 'https://www.mercadopago.com.ar/developers/es/',   // Argentinian.
			'mlb' => 'https://www.mercadopago.com.br/developers/pt/',   // Brazil.
			'mlc' => 'https://www.mercadopago.cl/developers/es/',       // Chile.
			'mco' => 'https://www.mercadopago.com.co/developers/es/',   // Colombia.
			'mlm' => 'https://www.mercadopago.com.mx/developers/es/',   // Mexico.
			'mpe' => 'https://www.mercadopago.com.pe/developers/es/',   // Peru.
			'mlu' => 'https://www.mercadopago.com.uy/developers/es/',   // Uruguay.
		);
		return $country_link[ $checkout ];
	}

	/**
	 * Get Country Link to Mercado Pago
	 *
	 * @param string $checkout Checkout by country.
	 * @return string
	 */
	public function get_country_link_mp( $checkout ) {
		$country_link = array(
			'mla' => 'https://www.mercadopago.com.ar/',   // Argentinian.
			'mlb' => 'https://www.mercadopago.com.br/',   // Brazil.
			'mlc' => 'https://www.mercadopago.cl/',       // Chile.
			'mco' => 'https://www.mercadopago.com.co/',   // Colombia.
			'mlm' => 'https://www.mercadopago.com.mx/',   // Mexico.
			'mpe' => 'https://www.mercadopago.com.pe/',   // Peru.
			'mlu' => 'https://www.mercadopago.com.uy/',   // Uruguay.
		);
		return $country_link[ $checkout ];
	}

	/**
	 * Field Custom URL IPN
	 *
	 * @return array
	 */
	public function field_custom_url_ipn() {
		return array(
			'title'       => __( 'URL for IPN', 'woocommerce-mercadopago' ),
			'type'        => 'text',
			'description' => sprintf(
				/* translators: %s link */
				__( 'Enter a URL to receive payment notifications. In %s you can check more information.', 'woocommerce-mercadopago' ),
				'<a href="' . $this->get_country_link_guide( $this->checkout_country ) . 'guides/notifications/ipn/">' . __( 'our guides', 'woocommerce-mercadopago' ) .
				'</a>'
			),
			'default'     => '',
			'desc_tip'    => __( 'IPN (Instant Payment Notification) is a notification of events that take place on your platform and that is sent from one server to another through an HTTP POST call. See more information in our guides.', 'woocommerce-mercadopago' ),
		);
	}

	/**
	 * Field Checkout Payments Advanced Description
	 *
	 * @return array
	 */
	public function field_checkout_payments_advanced_description() {
		return array(
			'title' => __( 'Edit these advanced fields only when you want to modify the preset values.', 'woocommerce-mercadopago' ),
			'type'  => 'title',
			'class' => 'mp_small_text mp-mt--12 mp-mb-18',
		);
	}

	/**
	 * Field Coupon Mode
	 *
	 * @return array
	 */
	public function field_coupon_mode() {
		return array(
			'title'       => __( 'Discount coupons', 'woocommerce-mercadopago' ),
			'type'        => 'select',
			'default'     => 'no',
			'description' => __( 'Will you offer discount coupons to customers who buy with Mercado Pago?', 'woocommerce-mercadopago' ),
			'options'     => array(
				'no'  => __( 'No', 'woocommerce-mercadopago' ),
				'yes' => __( 'Yes', 'woocommerce-mercadopago' ),
			),
		);
	}

	/**
	 * Field No Credentials
	 *
	 * @return array
	 */
	public function field_no_credentials() {
		return array(
			'title' => sprintf(
				/* translators: %s link */
				__( 'It appears that your credentials are not properly configured.<br/>Please, go to %s and configure it.', 'woocommerce-mercadopago' ),
				'<a href="' . esc_url( admin_url( 'admin.php?page=mercado-pago-settings' ) ) . '">' . __( 'Market Payment Configuration', 'woocommerce-mercadopago' ) .
					'</a>'
			),
			'type'  => 'title',
		);
	}

	/**
	 * Field Binary Mode
	 *
	 * @return array
	 */
	public function field_binary_mode() {
		return array(
			'title'       => __( 'Binary mode', 'woocommerce-mercadopago' ),
			'type'        => 'select',
			'default'     => 'no',
			'description' => __( 'Accept and reject payments automatically. Do you want us to activate it?', 'woocommerce-mercadopago' ),
			'desc_tip'    => __( 'If you activate binary mode you will not be able to leave pending payments. This can affect fraud prevention. Leave it idle to be backed by our own tool.', 'woocommerce-mercadopago' ),
			'options'     => array(
				'yes' => __( 'Yes', 'woocommerce-mercadopago' ),
				'no'  => __( 'No', 'woocommerce-mercadopago' ),
			),
		);
	}

	/**
	 * Field Gateway Discount
	 *
	 * @return array
	 */
	public function field_gateway_discount() {
		return array(
			'title'             => __( 'Discounts per purchase with Mercado Pago', 'woocommerce-mercadopago' ),
			'type'              => 'number',
			'description'       => __( 'Choose a percentage value that you want to discount your customers for paying with Mercado Pago.', 'woocommerce-mercadopago' ),
			'default'           => '0',
			'custom_attributes' => array(
				'step' => '0.01',
				'min'  => '0',
				'max'  => '99',
			),
		);
	}

	/**
	 * Field Commission
	 *
	 * @return array
	 */
	public function field_commission() {
		return array(
			'title'             => __( 'Commission for purchase with Mercado Pago', 'woocommerce-mercadopago' ),
			'type'              => 'number',
			'description'       => __( 'Choose an additional percentage value that you want to charge as commission to your customers for paying with Mercado Pago.', 'woocommerce-mercadopago' ),
			'default'           => '0',
			'custom_attributes' => array(
				'step' => '0.01',
				'min'  => '0',
				'max'  => '99',
			),
		);
	}

	/**
	 * Field Currency Conversion
	 *
	 * @param WC_WooMercadoPago_Payment_Abstract $method Payment abstract.
	 * @return array
	 */
	public function field_currency_conversion( WC_WooMercadoPago_Payment_Abstract $method ) {
		return WC_WooMercadoPago_Helpers_CurrencyConverter::get_instance()->get_field( $method );
	}

	/**
	 * Field Checkout Support Title
	 *
	 * @return array
	 */
	public function field_checkout_support_title() {
		$message_support_title = __( 'Questions?', 'woocommerce-mercadopago' );

		return array(
			'title' => $message_support_title,
			'type'  => 'title',
			'class' => 'mp_subtitle_bd_mb mp-mg-0',
		);
	}

	/**
	 * Field Checkout Support Description
	 *
	 * @return array
	 */
	public function field_checkout_support_description() {
		$message_support_description = __( 'Check out the step-by-step of how to integrate the Mercado Pago Plugin for WooCommerce in our developer website.', 'woocommerce-mercadopago' );

		return array(
			'title' => $message_support_description,
			'type'  => 'title',
			'class' => 'mp_small_text',
		);
	}

	/**
	 * Field Checkout Support Description Link
	 *
	 * @return array
	 */
	public function field_checkout_support_description_link() {
		$message_link = __( 'Review documentation', 'woocommerce-mercadopago' );

		return array(
			'title' => sprintf(
				'%s',
				'<a href="' . $this->get_country_link_guide( $this->checkout_country ) . 'guides/plugins/woocommerce/integration" target="_blank">' . $message_link . '</a>'
			),
			'type'  => 'title',
			'class' => 'mp_tienda_link',
		);
	}

	/**
	 * Field Checkout Support Problem
	 *
	 * @return array
	 */
	public function field_checkout_support_problem() {
		$message_support_problem = sprintf(
			/* translators: %s link */
			__( 'Still having problems? Contact our support team through their %s', 'woocommerce-mercadopago' ),
			'<a href="' . $this->get_country_link_guide( $this->checkout_country ) . 'support/" target="_blank">' . __( 'contact form.', 'woocommerce-mercadopago' ) . '</a>'
		);

		return array(
			'title' => $message_support_problem,
			'type'  => 'title',
			'class' => 'mp-text-support',
		);
	}

	/**
	 * Field Installments and Interest Configuration Title
	 *
	 * @return array
	 */
	public function field_mp_psj_title( $checkout ) {

		if ( 'mco' !== $checkout ) {
			$message_support_title = __( 'Set up your installment and interest payments', 'woocommerce-mercadopago' );
		} else {
			$message_support_title = __( 'Set up your interest payments', 'woocommerce-mercadopago' );
		}
		return array(
			'title' => $message_support_title,
			'type'  => 'title',
			'class' => 'mp_subtitle_bd_mb mp-mg-0',
		);
	}

	/**
	 * Field Installments and Interest Configuration Description
	 *
	 * @return array
	 */
	public function field_mp_psj_description( $checkout ) {

		if ( 'mco' !== $checkout ) {
			$message_support_description = __( 'At Mercado Pago you can choose the fee you pay for each purchase and also offer interest-free installments to your customer.', 'woocommerce-mercadopago' );
		} else {
			$message_support_description = __( 'At Mercado Pago you can choose the fee you pay for each purchase', 'woocommerce-mercadopago' );
		}

		return array(
			'title' => $message_support_description,
			'type'  => 'title',
			'class' => 'mp_small_text',
		);
	}

	/**
	 * Field Installments and Interest Configuration Description Link
	 *
	 * @return array
	 */
	public function field_mp_psj_description_link( $checkout ) {

		if ( 'mco' !== $checkout ) {
			$message_link = __( 'Set up installment and interest', 'woocommerce-mercadopago' );
		} else {
			$message_link = __( 'Set up interest payments', 'woocommerce-mercadopago' );
		}

		return array(
			'title' => '<a href="' . $this->get_country_link_mp( $this->checkout_country ) . 'costs-section#from-section=menu" target="_blank">' . $message_link . '</a>',
			'type'  => 'title',
			'class' => 'mp_tienda_link',
		);
	}

	/**
	 * Field checkout ready title
	 *
	 * @return array
	 */
	public function field_checkout_ready_title() {

		if ( $this->is_production_mode() ) {
			$message_ready_title = __( 'Everything ready for the takeoff of your sales?', 'woocommerce-mercadopago' );
		} else {
			$message_ready_title = __( 'Test Mode Activated? Now visit your store and test the Mercado Pago checkouts', 'woocommerce-mercadopago' );
		}

		return array(
			'title' => $message_ready_title,
			'type'  => 'title',
			'class' => 'mp_subtitle_bd_mb mp-mg-0',
		);
	}

	/**
	 * Field checkout ready description
	 *
	 * @return array
	 */
	public function field_checkout_ready_description() {
		if ( $this->is_production_mode() ) {
			$message_ready_description = __( 'Visit your store as if you were one of your customers and check that everything is fine. If you already went to Production,<br> bring your customers and increase your sales with the best online shopping experience.', 'woocommerce-mercadopago' );
		} else {
			$message_ready_description = __( 'Visit your store as usual and simulate a payment in our checkouts to make sure everything is working correctly.', 'woocommerce-mercadopago' );
		}

		return array(
			'title' => $message_ready_description,
			'type'  => 'title',
			'class' => 'mp_small_text',
		);
	}

	/**
	 * Field checkout ready description link
	 *
	 * @return array
	 */
	public function field_checkout_ready_description_link() {
		if ( $this->is_production_mode() ) {
			$message_link = __( 'Visit my store', 'woocommerce-mercadopago' );
		} else {
			$message_link = __( 'Test payment via Mercado Pago', 'woocommerce-mercadopago' );
		}

		return array(
			'title' => sprintf(
			// @codingStandardsIgnoreLine
			__( '%s', 'woocommerce-mercadopago' ),
				'<a href="' . get_site_url() . '" target="_blank">' . $message_link . '</a>'
			),
			'type'  => 'title',
			'class' => 'mp_tienda_link',
		);
	}

	/**
	 * Is available?
	 *
	 * @return bool
	 */
	public function is_available() {
		if ( ! did_action( 'wp_loaded' ) ) {
			return false;
		}
		global $woocommerce;
		$w_cart = $woocommerce->cart;
		// Check for recurrent product checkout.
		if ( isset( $w_cart ) ) {
			if ( WC_WooMercadoPago_Module::is_subscription( $w_cart->get_cart() ) ) {
				return false;
			}
		}

		$_mp_public_key   = $this->get_public_key();
		$_mp_access_token = $this->get_access_token();
		$_site_id_v1      = $this->get_option_mp( '_site_id_v1' );

		if ( ! isset( $this->settings['enabled'] ) ) {
			return false;
		}

		return ( 'yes' === $this->settings['enabled'] ) && ! empty( $_mp_public_key ) && ! empty( $_mp_access_token ) && ! empty( $_site_id_v1 );
	}

	/**
	 * Get Admin Url
	 *
	 * @return mixed
	 */
	public function admin_url() {
		if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.1', '>=' ) ) {
			return admin_url( 'admin.php?page=wc-settings&tab=checkout&section=' . $this->id );
		}
		return admin_url( 'admin.php?page=woocommerce_settings&tab=payment_gateways&section=' . get_class( $this ) );
	}

	/**
	 * Get common configs
	 *
	 * @return array
	 */
	public function get_common_configs() {
		return self::COMMON_CONFIGS;
	}

	/**
	 * Is test user?
	 *
	 * @return bool
	 */
	public function is_test_user() {
		if ( $this->is_production_mode() ) {
			return false;
		}
		return true;
	}

	/**
	 * Get Mercado Pago Instance
	 *
	 * @return false|MP|null
	 * @throws WC_WooMercadoPago_Exception Get mercado pago instance error.
	 */
	public function get_mp_instance() {
		$mp = WC_WooMercadoPago_Module::get_mp_instance_singleton( $this );
		if ( ! empty( $mp ) ) {
			$mp->sandbox_mode( $this->sandbox );
		}
		return $mp;
	}

	/**
	 * Disable Payments MP
	 */
	public function disable_all_payments_methods_mp() {
		foreach ( WC_WooMercadoPago_Constants::PAYMENT_GATEWAYS as $gateway ) {
			$key     = 'woocommerce_' . $gateway::get_id() . '_settings';
			$options = get_option( $key );
			if ( ! empty( $options ) ) {
				if ( isset( $options['checkbox_checkout_test_mode'] ) && 'no' === $options['checkbox_checkout_test_mode'] && ! empty( $this->mp_access_token_prod ) ) {
					continue;
				}

				if ( isset( $options['checkbox_checkout_test_mode'] ) && 'yes' === $options['checkbox_checkout_test_mode'] && ! empty( $this->mp_access_token_test ) ) {
					continue;
				}

				$options['enabled'] = 'no';
				update_option( $key, apply_filters( 'woocommerce_settings_api_sanitized_fields_' . $gateway::get_id(), $options ) );
			}
		}
	}

	/**
	 * Is currency convertable?
	 *
	 * @return bool
	 */
	public function is_currency_convertable() {
		return $this->currency_convertion;
	}

	/**
	 * Is production mode?
	 *
	 * @return bool
	 */
	public function is_production_mode() {
		$this->update_credential_production();
		return $this->get_option_mp( 'checkbox_checkout_test_mode', get_option( 'checkbox_checkout_test_mode', 'yes' ) ) === 'no';
	}

	/**
	 * Update Credentials for production
	 */
	public function update_credential_production() {
		if ( ! empty( $this->get_option_mp( 'checkbox_checkout_test_mode', null ) ) ) {
			return;
		}

		foreach ( WC_WooMercadoPago_Constants::PAYMENT_GATEWAYS as $gateway ) {
			$key     = 'woocommerce_' . $gateway::get_id() . '_settings';
			$options = get_option( $key );
			if ( ! empty( $options ) ) {
				$old_credential_is_prod                 = array_key_exists('checkout_credential_prod', $options) && isset($options['checkout_credential_prod']) ? $options['checkout_credential_prod'] : 'no';
				$has_new_key                            = array_key_exists('checkbox_checkout_test_mode', $options) && isset($options['checkbox_checkout_test_mode']);
				$options['checkbox_checkout_test_mode'] = $has_new_key && 'deprecated' === $old_credential_is_prod
					? $options['checkbox_checkout_test_mode']
					: ( 'yes' === $old_credential_is_prod ? 'no' : 'yes' );
				$options['checkout_credential_prod']    = 'deprecated';

				update_option( $key, apply_filters( 'woocommerce_settings_api_sanitized_fields_' . $gateway::get_id(), $options ) );
			}
		}
	}

	/**
	 * Field admin checkout mode alert
	 *
	 * @return array
	 */
	private function field_admin_checkout_mode_alert() {
		$is_prod     = $this->is_production_mode();
		$title       = $is_prod
			? __( 'All Mercado Pago payment methods are in Production Mode', 'woocommerce-mercadopago' )
			: __( 'All Mercado Pago payment methods are in Test Mode', 'woocommerce-mercadopago' );
		$description = $is_prod
			? __( 'Your store is ready to receive payments from customers.', 'woocommerce-mercadopago' )
			: __( 'Your customers will not be able to make purchases while in Test Mode.', 'woocommerce-mercadopago' );
		$icon        = $is_prod ? 'circle-green-check' : 'circle-alert';
		$max_width   = $is_prod ? '580px' : '537px';
		$border_left = $is_prod ? '5px solid #05A54F' : '5px solid #f73';
		$alert       = "<div class='mp-alert-checkout-test-mode' style='background-color: #E7E7E8; max-width: $max_width; border-left: $border_left; min-height: 70px; font-weight: 400;'>
			<div class='mp-alert-icon-checkout-test-mode' style='width: 0 !important; padding: 0 10px;'>
				<img
					src='" . esc_url( plugins_url( "../assets/images/generics/$icon.png", plugin_dir_path( __FILE__ ) ) ) . "'
					alt='alert'
					class='mp-alert-circle-img'
				>
			</div>
			<div class='mp-alert-texts-checkout-test-mode'>
				<h2 class='mp-alert-title-checkout-test-mode'>$title</h2>
				<p class='mp-alert-description-checkout-test-mode'>$description</p>
			</div>
		</div>";

		return array(
			'title' => $alert,
			'type'  => 'title',
		);
	}

	/**
	 * Checkout Alert Test Mode Template
	 *
	 * @param String $alertTitle Title
	 * @param String $alertDescription Description
	 *
	 * @return String
	 */
	public function checkout_alert_test_mode_template( $alertTitle, $alertDescription ) {
		return "<div class='mp-alert-checkout-test-mode'>
			<div class='mp-alert-icon-checkout-test-mode'>
				<img
					src='" . esc_url( plugins_url( '../assets/images/generics/circle-alert.png', plugin_dir_path( __FILE__ ) ) ) . "'
					alt='alert'
					class='mp-alert-circle-img'
				>
			</div>
			<div class='mp-alert-texts-checkout-test-mode'>
				<h2 class='mp-alert-title-checkout-test-mode'>$alertTitle</h2>
				<p class='mp-alert-description-checkout-test-mode'>$alertDescription</p>
			</div>
		</div>";
	}

	/**
	 * Get Country Domain By MELI Acronym
	 *
	 * @return String
	 */
	public function get_country_domain_by_meli_acronym( $meliAcronym ) {
		$countries = array(
			'mla' => 'ar',
			'mlb' => 'br',
			'mlc' => 'cl',
			'mco' => 'co',
			'mlm' => 'mx',
			'mpe' => 'pe',
			'mlu' => 'uy',
		);

		return $countries[$meliAcronym];
	}

	/**
	 * Get Mercado Pago Devsite Page Link
	 *
	 * @param String $country Country Acronym
	 *
	 * @return String
	 */
	public function get_mp_devsite_link( $country ) {
		$country_links = [
			'mla' => 'https://www.mercadopago.com.ar/developers/es/guides/plugins/woocommerce/testing',
			'mlb' => 'https://www.mercadopago.com.br/developers/pt/guides/plugins/woocommerce/testing',
			'mlc' => 'https://www.mercadopago.cl/developers/es/guides/plugins/woocommerce/testing',
			'mco' => 'https://www.mercadopago.com.co/developers/es/guides/plugins/woocommerce/testing',
			'mlm' => 'https://www.mercadopago.com.mx/developers/es/guides/plugins/woocommerce/testing',
			'mpe' => 'https://www.mercadopago.com.pe/developers/es/guides/plugins/woocommerce/testing',
			'mlu' => 'https://www.mercadopago.com.uy/developers/es/guides/plugins/woocommerce/testing',
		];
		$link          = array_key_exists($country, $country_links) ? $country_links[$country] : $country_links['mla'];

		return $link;
	}

	/**
	 * Set Order to Status Pending when is a new attempt
	 *
	 * @param $order
	 */
	public function set_order_to_pending_on_retry( $order ) {
		if ( $order->get_status() === 'failed' ) {
			$order->set_status('pending');
			$order->save();
		}
	}

	/**
	 * Get Country Link to Mercado Pago
	 *
	 * @param string $checkout Checkout by country.
	 * @return string
	 */
	public static function get_country_link_mp_terms() {

		$country_link = [
			'mla' => [
				'help'      => 'ayuda',
				'sufix_url' => 'com.ar/',
				'translate' => 'es',
				'term_conditition' => '/terminos-y-politicas_194',  // Argentinian.
			],
			'mlb' => [
				'help'      => 'ajuda',
				'sufix_url' => 'com.br/',
				'translate' => 'pt',
				'term_conditition' => '/termos-e-politicas_194',   //Brasil
			],
			'mlc' => [
				'help'      => 'ayuda',
				'sufix_url' => 'cl/',
				'translate' => 'es',
				'term_conditition' => '/terminos-y-politicas_194',   // Chile.
			],
			'mco' => [
				'help'      => 'ayuda',
				'sufix_url' => 'com.co/',
				'translate' => 'es',
				'term_conditition' => '/terminos-y-politicas_194',   // Colombia.
			],
			'mlm' => [
				'help'      => 'ayuda',
				'sufix_url' => 'com.mx/',
				'translate' => 'es',
				'term_conditition' => '/terminos-y-politicas_194',   // Mexico.
			],
			'mpe' => [
				'help'      => 'ayuda',
				'sufix_url' => 'com.pe/',
				'translate' => 'es',
				'term_conditition' => '/terminos-y-politicas_194',   // Peru.
			],
			'mlu' => [
				'help'      => 'ayuda',
				'sufix_url' => 'com.uy/',
				'translate' => 'es',
				'term_conditition' => '/terminos-y-politicas_194',   // Uruguay.
			],
		];

	$checkout_country = strtolower(get_option( 'checkout_country', '' ));
		return $country_link[ $checkout_country ];
	}

	/**
	 *
	 * Define terms and conditions link
	 *
	 * @return array
	 */
	public static function mp_define_terms_and_conditions() {

		$links_mp       = self::get_country_link_mp_terms();
		$link_prefix_mp = 'https://www.mercadopago.';
	return array (
		'text_prefix'                           => __( 'By continuing, you agree to our ', 'woocommerce-mercadopago' ),
		'link_terms_and_conditions' => $link_prefix_mp . $links_mp['sufix_url'] . $links_mp['help'] . $links_mp['term_conditition'],
		'text_suffix'                               => __( 'Terms and Conditions', 'woocommerce-mercadopago' ),
	);

	}
}
