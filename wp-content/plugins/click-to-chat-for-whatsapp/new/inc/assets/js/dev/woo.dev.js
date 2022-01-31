/**
 * Click to Chat - woo
 * 
 * currenlty only loads  - if cart layout option is checked and only in woo single product pages only.
 * 
 * @since 3.8
 * 
 * cart layout
 */
(function ($) {

// ready
$(function () {
    
    console.log('woo dev js');
    
    // cart layout
    try {
        if (document.querySelector('.single_add_to_cart_button') || document.querySelector('.add_to_cart_button')) {
            cart_layout();
        } else if (document.querySelector('.ctc_woo_place')) {
            // in shop page - cart button might not exists, dispay (might be added display none)
            $('.ctc_woo_place').show();
        }
    } catch (e) {
        console.log('error: cart_layout');
    }

    function cart_layout() {

        console.log('inside cart layout');

        let single_cart = document.querySelector('.single_add_to_cart_button');
        let shop_cart = document.querySelector('.add_to_cart_button');
        

        // s1 - single product
        if (document.querySelector('.ctc_woo_single_cart_layout .s1_btn')) {

            console.log('single product - s1 btn exits. ');

            let single_s1 = document.querySelector('.ctc_woo_single_cart_layout .s1_btn');

            var s1_color = $(single_s1).css('color');
            var s1_bg_color = $(single_s1).css('background-color');

            if (single_cart) {
                copyNodeStyle(single_cart, single_s1);

                $(single_s1).css({
                    "display": 'inline-flex',
                    "width": 'fit-content',
                    "align-items": 'center',
                    "color": s1_color,
                    "background-color": s1_bg_color,
                });
            }
            
            $('.ctc_woo_place').show();

        }

        // s1 - shop, archive products
        if (document.querySelector('.ctc_woo_shop_cart_layout .s1_btn')) {

            console.log('shop page - s1 btn exits. ');
            
            let shop_s1 = document.querySelectorAll('.ctc_woo_shop_cart_layout .s1_btn');

            if (shop_cart && shop_s1.length) {

                console.log('cart available');

                var s1_color = $(shop_s1).css('color');
                var s1_bg_color = $(shop_s1).css('background-color');

                shop_s1.forEach(e => {
                    copyNodeStyle(shop_cart, e);
                });

                $(shop_s1).css({
                    "display": 'inline-flex',
                    "width": 'fit-content',
                    "align-items": 'center',
                    "color": s1_color,
                    "background-color": s1_bg_color,
                });
                
            }
            $('.ctc_woo_place').show();
        }

        // s8 - shop, archive products
        if (document.querySelector('.ctc_woo_shop_cart_layout .s_8')) {
            let single_s8 = document.querySelector('.ctc_woo_shop_cart_layout .s_8');
            s8(single_s8);
        }

        // s8 - single product
        if (document.querySelector('.ctc_woo_single_cart_layout .s_8')) {
            let single_s8 = document.querySelector('.ctc_woo_single_cart_layout .s_8');
            s8(single_s8);
        }

        function s8(style) {

            $(style).css({
                // "display": 'inline-flex',
                "min-height": $(single_cart).css('min-height'),
                "font-size": $(single_cart).css('font-size'),
                "font-weight": $(single_cart).css('font-weight'),
                "letter-spacing": $(single_cart).css('letter-spacing'),
                "border-radius": $(single_cart).css('border-radius'),
                "width": 'fit-content',
            });
            $('.ctc_woo_place').show();

        }

        function copyNodeStyle(sourceNode, targetNode) {
            const computedStyle = window.getComputedStyle(sourceNode);
            Array.from(computedStyle).forEach(key => targetNode.style.setProperty(key, computedStyle.getPropertyValue(key), computedStyle.getPropertyPriority(key)))
        }

    }

    


});

}) (jQuery);