// Click to Chat
document.addEventListener('DOMContentLoaded', function () {

    // M.AutoInit();

    var elems = document.querySelectorAll('select');
    M.FormSelect.init(elems, {});

    var elems = document.querySelectorAll('.collapsible');
    M.Collapsible.init(elems, {});

    var elems = document.querySelectorAll('.modal');
    M.Modal.init(elems, {});

    var elems = document.querySelectorAll('.tooltipped');
    M.Tooltip.init(elems, {});

});

(function ($) {

    // ready
    $(function () {

        $('select').formSelect();
        $('.collapsible').collapsible();
        $('.modal').modal();
        $('.tooltipped').tooltip();
        $('.ht-ctc-color').wpColorPicker();


        // functions
        show_hide_options();
        styles();
        call_to_action();
        ht_ctc_admin_animations();
        desktop_mobile();
        wn();
        hook();
        ss();
        other();

        try {
            woo_page();
            collapsible();
        } catch (e) { }



        // show/hide settings
        function show_hide_options() {

            // default display
            var val = $('.global_display:checked').val();

            if (val == 'show') {
                $('.global_show_or_hide_icon').addClass('dashicons dashicons-visibility');
                $(".hide_settings").show();
                $(".show_hide_types .show_btn").attr('disabled', 'disabled');
                $(".show_hide_types .show_box").hide();
            } else if (val == 'hide') {
                $('.global_show_or_hide_icon').addClass('dashicons dashicons-hidden');
                $(".show_settings").show();
                $(".show_hide_types .hide_btn").attr('disabled', 'disabled');
                $(".show_hide_types .hide_box").hide();
            }
            $('.global_show_or_hide_label').html('(' + val + ')');

            // on change
            $(".global_display").on("change", function (e) {

                var change_val = e.target.value;
                var add_class = '';
                var remove_class = '';

                $(".hide_settings").hide();
                $(".show_settings").hide();
                $(".show_hide_types .show_btn").removeAttr('disabled');
                $(".show_hide_types .hide_btn").removeAttr('disabled');
                $(".show_hide_types .show_box").hide();
                $(".show_hide_types .hide_box").hide();

                if (change_val == 'show') {
                    add_class = 'dashicons dashicons-visibility';
                    remove_class = 'dashicons-hidden';
                    $(".hide_settings").show(500);
                    $(".show_hide_types .show_btn").attr('disabled', 'disabled');
                    $(".show_hide_types .hide_box").show();
                } else if (change_val == 'hide') {
                    add_class = 'dashicons dashicons-hidden';
                    remove_class = 'dashicons-visibility';
                    $(".show_settings").show(500);
                    $(".show_hide_types .hide_btn").attr('disabled', 'disabled');
                    $(".show_hide_types .show_box").show();
                }
                $('.global_show_or_hide_label').html('(' + change_val + ')');
                $('.global_show_or_hide_icon').removeClass(remove_class);
                $('.global_show_or_hide_icon').addClass(add_class);

            });

        }


        // styles
        function styles() {

            // on change - styles
            $(".chat_select_style").on("change", function (e) {
                $(".customize_styles_link").animate({ fontSize: '1.2em' }, "slow");
            });

            // style-1 - add icon
            if ($('.s1_add_icon').is(':checked')) {
                $(".s1_icon_settings").show();
            } else {
                $(".s1_icon_settings").hide();
            }

            $(".s1_add_icon").on("change", function (e) {
                console.log('change');

                if ($('.s1_add_icon').is(':checked')) {
                    $(".s1_icon_settings").show(200);
                } else {
                    $(".s1_icon_settings").hide(200);
                }

            });

        }



        // call to actions
        function call_to_action() {
            var cta_styles = ['.ht_ctc_s2', '.ht_ctc_s3', '.ht_ctc_s3_1', '.ht_ctc_s7'];
            cta_styles.forEach(ht_ctc_admin_cta);

            function ht_ctc_admin_cta(style) {
                // default display
                var val = $(style + ' .select_cta_type').find(":selected").val();
                if (val == 'hide') {
                    $(style + " .cta_stick").hide();
                }

                // on change
                $(style + " .select_cta_type").on("change", function (e) {
                    var change_val = e.target.value;
                    if (change_val == 'hide') {
                        $(style + " .cta_stick").hide(100);
                    } else {
                        $(style + " .cta_stick").show(200);
                    }
                });
            }

        }



        function ht_ctc_admin_animations() {
            // default display
            var val = $('.select_an_type').find(":selected").val();
            if (val == 'no-animation') {
                $(".an_delay").hide();
                $(".an_itr").hide();
            }

            // on change
            $(".select_an_type").on("change", function (e) {

                var change_val = e.target.value;

                if (change_val == 'no-animation') {
                    $(".an_delay").hide();
                    $(".an_itr").hide();
                } else {
                    $(".an_delay").show(500);
                    $(".an_itr").show(500);
                }
            });
        }


        // Deskop, Mobile - same settings
        function desktop_mobile() {

            // same setting
            if ($('.same_settings').is(':checked')) {
                $(".not_samesettings").hide();
            } else {
                $(".not_samesettings").show();
            }

            $(".same_settings").on("change", function (e) {

                if ($('.same_settings').is(':checked')) {
                    $(".not_samesettings").hide(900);
                    $(".select_styles_issue_checkbox").hide();
                } else {
                    $(".not_samesettings").show(900);
                }

            });

        }


        // WhatsApp number  
        function wn() {

            var cc = $("#whatsapp_cc").val();
            var num = $("#whatsapp_number").val();

            $("#whatsapp_cc").on("change paste keyup", function (e) {
                cc = $("#whatsapp_cc").val();
                call();
            });

            $("#whatsapp_number").on("change paste keyup", function (e) {
                num = $("#whatsapp_number").val();
                call();

                if (num && 0 == num.charAt(0)) {
                    $('.ctc_wn_initial_zero').show(500);
                } else {
                    $('.ctc_wn_initial_zero').hide(500);
                }
            });

            function call() {
                $(".ht_ctc_wn").html(cc + '' + num);
                $("#ctc_whatsapp_number").val(cc + '' + num);
            }

        }

        // woo page..
        function woo_page() {

            //  Woo single product page - woo position
            var position_val = $('.woo_single_position_select').find(":selected").val();
            // woo add to cart layout
            var style_val = $('.woo_single_style_select').find(":selected").val();

            if (position_val && '' !== position_val && 'select' !== position_val) {
                $('.woo_single_position_settings').show();
            }
            if (position_val && 'select' == position_val) {
                hide_cart_layout();
            } else if (style_val && style_val == '1' || style_val == '8') {
                // if position_val is not 'select'
                show_cart_layout();
            }

            // on change - select position
            $('.woo_single_position_select').on("change", function (e) {
                var position_change_val = e.target.value;
                var style_val = $('.woo_single_style_select').find(":selected").val();

                if (position_change_val == 'select') {
                    $('.woo_single_position_settings').hide(200);
                    hide_cart_layout();
                } else {
                    $('.woo_single_position_settings').show(200);
                    if (style_val == '1' || style_val == '8') {
                        show_cart_layout();
                    }
                }
            });

            // on change - style - for cart layout
            $('.woo_single_style_select').on("change", function (e) {
                var style_change_val = e.target.value;

                if (style_change_val == '1' || style_change_val == '8') {
                    show_cart_layout();
                } else {
                    hide_cart_layout();
                }
            });

            // position center is checked
            if ($('#woo_single_position_center').is(':checked')) {
                $(".woo_single_position_center_checked_content").show();
            }

            $("#woo_single_position_center").on("change", function (e) {
                if ($('#woo_single_position_center').is(':checked')) {
                    $(".woo_single_position_center_checked_content").show(200);
                } else {
                    $(".woo_single_position_center_checked_content").hide(100);
                }
            });



            // woo shop page .. 
            if ($('#woo_shop_add_whatsapp').is(':checked')) {
                $(".woo_shop_add_whatsapp_settings").show();

                var shop_style_val = $('.woo_shop_style').find(":selected").val();
                if (shop_style_val == '1' || shop_style_val == '8') {
                    shop_show_cart_layout();
                }
            }




            $("#woo_shop_add_whatsapp").on("change", function (e) {
                if ($('#woo_shop_add_whatsapp').is(':checked')) {
                    $(".woo_shop_add_whatsapp_settings").show(200);

                    var shop_style_val = $('.woo_shop_style').find(":selected").val();

                    if (shop_style_val == '1' || shop_style_val == '8') {
                        shop_show_cart_layout();
                    }

                } else {
                    $(".woo_shop_add_whatsapp_settings").hide(100);
                    shop_hide_cart_layout(100);
                }
            });


            // on change - style - for cart layout
            $('.woo_shop_style').on("change", function (e) {
                var shop_style_change_val = e.target.value;

                if (shop_style_change_val == '1' || shop_style_change_val == '8') {
                    shop_show_cart_layout();
                } else {
                    shop_hide_cart_layout();
                }
            });


            function show_cart_layout() {
                $(".woo_single_position_settings_cart_layout").show(200);
            }
            function hide_cart_layout() {
                $(".woo_single_position_settings_cart_layout").hide(200);
            }

            function shop_show_cart_layout() {
                $(".woo_shop_cart_layout").show(200);
            }
            function shop_hide_cart_layout() {
                $(".woo_shop_cart_layout").hide(200);
            }

        }


        // webhook
        function hook() {

            // webhook value - html 
            var hook_value_html = $('.add_hook_value').attr('data-html');

            // add value
            $(document).on('click', '.add_hook_value', function () {

                $('.ctc_hook_value').append(hook_value_html);
            });

            // Remove value
            $('.ctc_hook_value').on('click', '.hook_remove_value', function (e) {
                e.preventDefault();
                $(this).closest('.additional-value').remove();
            });

        }


        // things based on screen size
        function ss() {

            var is_mobile = (typeof screen.width !== "undefined" && screen.width > 1024) ? "no" : "yes";

            if ('yes' == is_mobile) {

                // WhatsApp number tooltip position for mobile
                // $("#whatsapp_cc").data('position', 'bottom');
                $("#whatsapp_cc").attr('data-position', 'bottom');
                $("#whatsapp_number").attr('data-position', 'bottom');
            }
        }


        function other() {

            // google ads - checkbox
            $('.ga_ads_display').on('click', function (e) {
                $('.ga_ads_checkbox').toggle(500);
            });

            // display - call gtag_report_conversion by default if checked.
            if ($('#ga_ads').is(':checked')) {
                $(".ga_ads_checkbox").show();
            }

            // hover text on save_changes button
            var text = $('#ctc_save_changes_hover_text').text();
            $("#submit").attr('title', text);

            // analytics - ga4 display only if ga is enabled.
            $("#google_analytics").on("change", function (e) {
                if ($('#google_analytics').is(':checked')) {
                    $(".ctc_ga4").show();
                } else {
                    $(".ctc_ga4").hide();
                }
            });

            if ($('#google_analytics').is(':checked')) {
                $(".ctc_ga4").show();
            } else {
                $(".ctc_ga4").hide();
            }

            // select styles issue

            if ($('#select_styles_issue').is(':checked')) {
                $(".select_styles_issue_checkbox").show();
            }
            $('.select_styles_issue_description').on('click', function (e) {
                $('.select_styles_issue_checkbox').toggle(500);
            });


            // s3e - shadow on hover
            if (!$('#s3_box_shadow').is(':checked')) {
                $(".s3_box_shadow_hover").show();
            }

            $('#s3_box_shadow').on('change', function (e) {
                if ($('#s3_box_shadow').is(':checked')) {
                    $(".s3_box_shadow_hover").hide(400);
                } else {
                    $(".s3_box_shadow_hover").show(500);
                }
            });

        }

        // collapsible..
        function collapsible() {

            var ht_ctc_admin = {};

            if (localStorage.getItem('ht_ctc_admin')) {
                ht_ctc_admin = localStorage.getItem('ht_ctc_admin');
                ht_ctc_admin = JSON.parse(ht_ctc_admin);
            }
            // else {
            //     ht_ctc_admin = demo;
            //     demo = JSON.stringify(demo);
            //     localStorage.setItem('ht_ctc_admin', demo);
            // }

            // get items from ht_ctc_admin
            function ctc_getItem(item) {
                if (ht_ctc_admin[item]) {
                    return ht_ctc_admin[item];
                } else {
                    return false;
                }
            }

            // set items to ht_ctc_admin storage
            function ctc_setItem(name, value) {
                ht_ctc_admin[name] = value;
                var newValues = JSON.stringify(ht_ctc_admin);
                localStorage.setItem('ht_ctc_admin', newValues);
            }

            /**
             * ht_ctc_sidebar_contat - not added, as it may cause view distraction..
             */
            var styles_list = [
                'ht_ctc_s1',
                'ht_ctc_s2',
                'ht_ctc_s3',
                'ht_ctc_s3_1',
                'ht_ctc_s4',
                'ht_ctc_s5',
                'ht_ctc_s6',
                'ht_ctc_s7',
                'ht_ctc_s7_1',
                'ht_ctc_s8',
                'ht_ctc_s99',
                'ht_ctc_webhooks',
                'ht_ctc_analytics',
                'ht_ctc_animations',
                'ht_ctc_other_settings',
                'ht_ctc_enable_share_group',
                'ht_ctc_debug',
                'ht_ctc_device_settings',
                'ht_ctc_show_hide_settings',
                'ht_ctc_woo_1',
                'ht_ctc_woo_shop',
                'ht_ctc_woo_cart',
                'ht_ctc_woo_checkout',
                'ht_ctc_woo_myaccount',
            ];

            var default_active = [
                'ht_ctc_device_settings',
                'ht_ctc_show_hide_settings',
                'ht_ctc_woo_1',
                'ht_ctc_webhooks',
                'ht_ctc_analytics',
                'ht_ctc_animations',
                'ht_ctc_other_settings',
            ];


            styles_list.forEach(e => {

                // one known issue.. is already active its not working as expected. 
                var is_col = (ctc_getItem('col_' + e)) ? ctc_getItem('col_' + e) : '';
                if ('open' == is_col) {
                    $('.' + e + ' li').addClass('active');
                } else if ('close' == is_col) {
                    $('.' + e + ' li').removeClass('active');
                } else if (default_active.includes(e)) {
                    // if not changed then for default_active list add active..
                    $('.' + e + ' li').addClass('active');
                }


                $('.' + e).collapsible({
                    onOpenEnd() {
                        ctc_setItem('col_' + e, 'open');
                    },
                    onCloseEnd() {
                        ctc_setItem('col_' + e, 'close');
                    }
                });

            });

        }



    });


})(jQuery);