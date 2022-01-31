<?php
/**
 * position to place
 * @included from - class-ht-ctc-chat/group/share.php
 */

// position hooks
$position_type = apply_filters( 'ht_ctc_fh_position_type', 'fixed', $options );
$position_type_mobile = apply_filters( 'ht_ctc_fh_position_type_mobile', 'fixed', $options );

// desktop position
$side_1 = esc_attr( $options['side_1'] );
$side_1_value = esc_attr( $options['side_1_value'] );
$side_2 = esc_attr( $options['side_2'] );
// @uses position, call to action ..   (cta - desktop value only uses for both devices. )
$side_2 = apply_filters( 'ht_ctc_fh_side_2', $side_2 );
$side_2_value = esc_attr( $options['side_2_value'] );

$position = "position: $position_type; $side_1: $side_1_value; $side_2: $side_2_value;";



if ( isset($options['same_settings']) ) {
    $position_mobile = $position;
} else {
    // Mobile position
    $mobile_side_1 = ( isset( $options['mobile_side_1']) ) ? esc_attr( $options['mobile_side_1'] ) : '';
    $mobile_side_1_value = ( isset( $options['mobile_side_1_value'])) ? esc_attr( $options['mobile_side_1_value'] ) : '';
    $mobile_side_2 = ( isset( $options['mobile_side_2']) ) ? esc_attr( $options['mobile_side_2'] ) : '';
    $mobile_side_2 = apply_filters( 'ht_ctc_fh_mobile_side_2', $mobile_side_2 );
    $mobile_side_2_value = ( isset( $options['mobile_side_2_value'])) ? esc_attr( $options['mobile_side_2_value'] ) : '';

    $position_mobile = "position: $position_type_mobile; $mobile_side_1: $mobile_side_1_value; $mobile_side_2: $mobile_side_2_value;";

    // incase mobile position is null; - safeside can remove this later as db is handling the version updates
    if ( '' == $mobile_side_1_value && '' == $mobile_side_2_value ) {
        $position_mobile = $position;
    }
}

// wp_is_mobile way of position (amp may need this)
// js will override this based on screen size
$default_position = $position;
if ( 'yes' == $is_mobile ) {
    $default_position = $position_mobile;
}