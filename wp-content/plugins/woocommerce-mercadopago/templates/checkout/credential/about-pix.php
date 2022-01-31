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
?>

<div>
	<h3 class="mp_subtitle_bd"><?php echo esc_html( $title ); ?></h3>
	<h3 class="mp_small_text mp-mt--12 mp-mb-18"><?php echo esc_html( $subtitle ); ?></h3>

	<div class="mp-col-md-12 mp_tienda_link">
		<p class="">
			<a href=<?php echo esc_html( $url_link ); ?> target="_blank"><?php echo esc_html( $button_text ); ?></a>
		</p>
	</div>

</div>

