<?php
/**
 * 
 * Animation styles - regular, Entry effects
 * @since 2.8
 * @since 3.3.5 added entry effects
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CTC_Animations' ) ) :

class HT_CTC_Animations {


    // public function __construct() {
        // $this->base();
    // }

    
    
    /**
     * Animations
     * 
     * Based of animations - with dealy, iteration
     * and then calls the necessary animation function.
     * 
     * @param string $a             animation type (bounce, .. )
     * @param string $ad            animation duration (1s)
     * @param string $d             time delay (1s)
     * @param int|[string] $i       interation count 1
     * 
     * $a($a) - it like calling bounce('bounce')
     */
    function animations( $a, $ad, $d, $i ) {
        ?>
        <style id="ht-ctc-animations">.ht_ctc_animation{animation-duration:<?= $ad ?>;animation-fill-mode:both;animation-delay:<?= $d ?>;animation-iteration-count:<?= $i ?>;}</style>
        <?php $this->$a("ht_ctc_an_$a"); ?>
        <?php
    }

    /**
     * Entry Animations
     */
    function entry( $a, $ad, $d, $i ) {
        ?>
        <style id="ht-ctc-entry-animations">.ht_ctc_entry_animation{animation-duration:<?= $ad ?>;animation-fill-mode:both;animation-delay:<?= $d ?>;animation-iteration-count:<?= $i ?>;}</style>
        <?php $this->$a("ht_ctc_an_entry_$a"); ?>
        <?php
    }
    

    // Animations types css for main, entry

    function bounce($a) {
        ?>
        <style id="<?= $a ?>">@keyframes bounce{from,20%,53%,to{animation-timing-function:cubic-bezier(0.215,0.61,0.355,1);transform:translate3d(0,0,0)}40%,43%{animation-timing-function:cubic-bezier(0.755,0.05,0.855,0.06);transform:translate3d(0,-30px,0) scaleY(1.1)}70%{animation-timing-function:cubic-bezier(0.755,0.05,0.855,0.06);transform:translate3d(0,-15px,0) scaleY(1.05)}80%{transition-timing-function:cubic-bezier(0.215,0.61,0.355,1);transform:translate3d(0,0,0) scaleY(0.95)}90%{transform:translate3d(0,-4px,0) scaleY(1.02)}}<?= '.'.$a ?>{animation-name:bounce;transform-origin:center bottom}</style>
        <?php
    }

    function flash($a) {
        ?>
        <style id="<?= $a ?>">@keyframes flash{from,50%,to{opacity:1}25%,75%{opacity:0}}<?= '.'.$a ?>{animation-name:flash}</style>
        <?php
    }

    function pulse($a) {
        ?>
        <style id="<?= $a ?>">@keyframes pulse{from{transform:scale3d(1,1,1)}50%{transform:scale3d(1.05,1.05,1.05)}to{transform:scale3d(1,1,1)}}<?= '.'.$a ?>{animation-name:pulse;animation-timing-function:ease-in-out}</style>
        <?php
    }

    function heartbeat($a) {
        ?>
        <style id="<?= $a ?>">@keyframes heartBeat{0%{transform:scale(1)}14%{transform:scale(1.3)}28%{transform:scale(1)}42%{transform:scale(1.3)}70%{transform:scale(1)}}<?= '.'.$a ?>{animation-name:heartBeat;animation-duration:calc(1s * 1.3);animation-duration:calc(var(1) * 1.3);animation-timing-function:ease-in-out}</style>
        <?php
    }

    function flip($a) {
        ?>
        <style id="<?= $a ?>">@keyframes flip{from{transform:perspective(400px) scale3d(1,1,1) translate3d(0,0,0) rotate3d(0,1,0,-360deg);animation-timing-function:ease-out}40%{transform:perspective(400px) scale3d(1,1,1) translate3d(0,0,150px) rotate3d(0,1,0,-190deg);animation-timing-function:ease-out}50%{transform:perspective(400px) scale3d(1,1,1) translate3d(0,0,150px) rotate3d(0,1,0,-170deg);animation-timing-function:ease-in}80%{transform:perspective(400px) scale3d(.95,.95,.95) translate3d(0,0,0) rotate3d(0,1,0,0deg);animation-timing-function:ease-in}to{transform:perspective(400px) scale3d(1,1,1) translate3d(0,0,0) rotate3d(0,1,0,0deg);animation-timing-function:ease-in}}<?= '.'.$a ?>{backface-visibility:visible;animation-name:flip}</style>
        <?php
    }

    function bounceInLeft($a) {
        ?>
        <style id="<?= $a ?>">@keyframes bounceInLeft{from,60%,75%,90%,to{animation-timing-function:cubic-bezier(0.215,0.61,0.355,1)}0%{opacity:0;transform:translate3d(-3000px,0,0) scaleX(3)}60%{opacity:1;transform:translate3d(25px,0,0) scaleX(1)}75%{transform:translate3d(-10px,0,0) scaleX(0.98)}90%{transform:translate3d(5px,0,0) scaleX(0.995)}to{transform:translate3d(0,0,0)}}<?= '.'.$a ?>{animation-name:bounceInLeft}</style>
        <?php
    }


    function bounceInRight($a) {
        ?>
        <style id="<?= $a ?>">@keyframes bounceInRight{from,60%,75%,90%,to{animation-timing-function:cubic-bezier(0.215,0.61,0.355,1)}from{opacity:0;transform:translate3d(3000px,0,0) scaleX(3)}60%{opacity:1;transform:translate3d(-25px,0,0) scaleX(1)}75%{transform:translate3d(10px,0,0) scaleX(0.98)}90%{transform:translate3d(-5px,0,0) scaleX(0.995)}to{transform:translate3d(0,0,0)}}<?= '.'.$a ?>{animation-name:bounceInRight}</style>
        </style>
        <?php
    }

    function bounceIn($a) {
        ?>
        <style id="<?= $a ?>">@keyframes bounceIn{from,20%,40%,60%,80%,to{animation-timing-function:cubic-bezier(0.215,0.61,0.355,1)}0%{opacity:0;transform:scale3d(0.3,0.3,0.3)}20%{transform:scale3d(1.1,1.1,1.1)}40%{transform:scale3d(0.9,0.9,0.9)}60%{opacity:1;transform:scale3d(1.03,1.03,1.03)}80%{transform:scale3d(0.97,0.97,0.97)}to{opacity:1;transform:scale3d(1,1,1)}}<?= '.'.$a ?>{animation-duration:calc(1s * 0.75);animation-duration:calc(var(1) * 0.75);animation-name:bounceIn}</style>
        <?php
    }

    function bounceInDown($a) {
        ?>
        <style id="<?= $a ?>">@keyframes bounceInDown{from,60%,75%,90%,to{animation-timing-function:cubic-bezier(0.215,0.61,0.355,1)}0%{opacity:0;transform:translate3d(0,-3000px,0) scaleY(3)}60%{opacity:1;transform:translate3d(0,25px,0) scaleY(0.9)}75%{transform:translate3d(0,-10px,0) scaleY(0.95)}90%{transform:translate3d(0,5px,0) scaleY(0.985)}to{transform:translate3d(0,0,0)}}<?= '.'.$a ?>{animation-name:bounceInDown}</style>
        <?php
    }

    function bounceInUp($a) {
        ?>
        <style id="<?= $a ?>">@keyframes bounceInUp{from,60%,75%,90%,to{animation-timing-function:cubic-bezier(0.215,0.61,0.355,1)}from{opacity:0;transform:translate3d(0,3000px,0) scaleY(5)}60%{opacity:1;transform:translate3d(0,-20px,0) scaleY(0.9)}75%{transform:translate3d(0,10px,0) scaleY(0.95)}90%{transform:translate3d(0,-5px,0) scaleY(0.985)}to{transform:translate3d(0,0,0)}}<?= '.'.$a ?>{animation-name:bounceInUp}</style>
        <?php
    }


    // local
    function center($a) {
        ?>
        <style id="<?= $a ?>">@keyframes center{from{transform:scale(0);}to{transform: scale(1);}}<?= '.'.$a ?>{animation: center .25s;}</style>
        <?php
    }

    // local
    // this function is not calling. js handle the corner effect... 
    function corner($a) {
        ?>
        <style id="<?= $a ?>">@keyframes corner{to{transform:scale(1)}}<?= '.'.$a ?>{animation:corner .9s}</style>
        <?php
    }

    
    // zoomin not using ( using center() )
    function zoomIn($a) {
        ?>
        <style id="<?= $a ?>">
        @keyframes zoomIn {
        from {
            opacity: 0;
            transform: scale3d(0.3, 0.3, 0.3);
        }

        50% {
            opacity: 1;
        }
        }
        <?= '.'.$a ?> {
        animation: zoomIn .25s;
        /* animation-name: zoomIn; */
        }
        </style>
        <?php
    }


    // local
    // have to improve, add bounce effect..
    function bottomRight($a) {
        ?>
        <style id="<?= $a ?>">

            @keyframes bounceInBR {
            0% {
                transform: translateY(1000px) translateX(1000px);
                opacity: 0;
            }
            100% {
                transform: translateY(0) translateX(0);
                opacity: 1;
            }
            }
            <?= '.'.$a ?> {
                animation: bounceInBR 0.5s linear both;
            }
        </style>
        <?php
    }


}

// new HT_CTC_Animations();

endif; // END class_exists check