<?php
/**
 * sidebar content
 */


if ( ! defined( 'ABSPATH' ) ) exit;

$othersettings = get_option('ht_ctc_othersettings');

?>

<div class="sidebar-content">

    <div class="col s12 m8 l12 xl12">
        <div class="row">
            <ul class="collapsible popout ht_ctc_sidebar_contat">
                <li class="active">
                    <div class="collapsible-header"><?php _e( 'Contact Us', 'click-to-chat-for-whatsapp' ); ?></div>	
                    <div class="collapsible-body">
                        <p class="description"><a href="https://api.whatsapp.com/send?phone=919494429789&text=<?php echo get_bloginfo('url'); ?>%0AHi%20HoliThemes,%0AI%20have%20a%20Suggestion/Feedback:" target="_blank"><?php _e( 'WhatsApp', 'click-to-chat-for-whatsapp' ); ?></a></p>	
                        <p class="description"><a href="mailto: ctc@holithemes.com"> ctc@holithemes.com</a></p>
                        <p class="description"><a target="_blank" href="https://holithemes.com/plugins/click-to-chat/support/">Support Page</a></p>	
                    </div>	
                </li>
            </ul>
        </div>
    </div>

    <?php
    do_action('ht_ctc_ah_admin_sidebar_contact' );

    if ( ! defined( 'HT_CTC_PRO_VERSION' ) ) {
        ?>
        <div class="col s12 m8 l12 xl12">
            <div class="row">
                <ul class="collapsible popout ht_ctc_sidebar_contat">
                    <li class="active">
                        <div class="collapsible-header"><?php _e( 'PRO', 'click-to-chat-for-whatsapp' ); ?></div>	
                        <div class="collapsible-body">	
                            <p class="description">Random Numbers</p>
                            <p class="description">Fixed/Absolute Position types</p>
                            <p class="description">Webhooks - dynamic variables</p>
                            <p class="description">Google Ads Conversion</p>
                            <p class="description">Business Hours</p>
                            <p class="description">&emsp;Hide when offline</p>
                            <p class="description">&emsp;Change WhatsApp number when offline</p>
                            <p class="description">&emsp;Change Call to Action when offline</p>
                            <p class="description">Display after Time delay, scroll delay</p>
                            <p class="description">Display based on</p>
                            <p class="description">&emsp;selected days in a week</p>
                            <p class="description">&emsp;selected time range in a day</p>
                            <p class="description">&emsp;website visitor login status</p>
                            <p class="description">Page level settings: style, time, scroll dealy</p>
                            <p class="description">Add WhatsApp in WooCommerce Product pages</p>
                            <p class="description">More features</p>
                            <br>
                            <p class="description">Next: (coming soon)</p>
                            <p class="description">Greetings Dialog</p>
                            <p class="description">Form Filling</p>

                            <p class="description" style="text-align: center; position:sticky; bottom:2px; margin-top:20px;"><a target="_blank" href="https://holithemes.com/plugins/click-to-chat/pricing/" class="waves-effect waves-light btn" style="width: 100%;">PRO Version</a></p>

                        </div>	
                    </li>
                </ul>
            </div>
        </div>
        <?php
    }

    ?>


</div>