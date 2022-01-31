<?php
/**
 * 
 * @included from - class-ht-ctc-{chat/group/share}.php
 * 
 * sets $display - yes to show styles or no to hide styles
 * @updated 3.3.3
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$this_page_id = get_the_ID();

// yes to display style and no to hide styles
// @uses at 'class-ht-ctc-{chat/group/share}.php'
$display = 'yes';

$display_fallback = array('global_display'=>'show');

$display_settings = (isset($options['display'])) ? $options['display'] : $display_fallback;

$post_type = get_post_type();



$show_or_hide = (isset($display_settings['global_display'])) ? esc_html($display_settings['global_display']) : 'show';


// new way..
if ( 'hide' == $show_or_hide ) {
    // global value: hide on all pages
    $display = 'no';

    // if any page override to show

    // is_home and is_front_page - combined. 
    if ( is_home() || is_front_page() ) {
        if ( isset( $display_settings['home'] ) && 'show' == $display_settings['home'] ) {
            $display = 'yes';
            return;
        }
    }


    if ( is_singular() ) {
        // singular post .. any post type, single page

        
        // is_single (post type: posts or other(custom post type or so ..), but not pages )
        if ( is_single() ) {
            
            if ( 'post' == $post_type ) {
                // post type: post (singular page)
                if ( isset( $display_settings['posts'] ) && 'show' == $display_settings['posts'] ) {
                    $display = 'yes';
                    return;
                }
            } else {
                // custom post type
                $custom_post_types = get_post_types( array('public' => true, '_builtin' => false) );
                unset($custom_post_types['product']);

                if ( !empty($custom_post_types ) ) {
                    if ( in_array( $post_type, $custom_post_types ) ) {
                        if ( isset( $display_settings[$post_type] ) && 'show' == $display_settings[$post_type] ) {
                            $display = 'yes';
                            return;
                        }
                    }
                }
                
            }
        }

        // post type: page (but not home/front page)
        if ( is_page() ) {
            if ( ( !is_home() ) && ( !is_front_page() ) ) {
                if ( isset( $display_settings['pages'] ) && 'show' == $display_settings['pages'] ) {
                    $display = 'yes';
                    return;
                }
            }
        }

        // woocommerce (shop page is at archive)
        if ( class_exists( 'WooCommerce' ) ) {
            
            if ( function_exists( 'is_product' ) && is_product() ) {
                if ( isset( $display_settings['woo_product'] ) && 'show' == $display_settings['woo_product']  ) {
                    $display = 'yes';
                    return; 
                }
            }

            if ( function_exists( 'is_cart' ) && is_cart() ) {
                if ( isset( $display_settings['woo_cart'] ) && 'show' == $display_settings['woo_cart']  ) {
                    $display = 'yes';
                    return; 
                }
            }

            /**
             * @since 3.5.3
             * this have to be before checkout - if this value is not set, no problem - checkout will handle this
             */
            if ( function_exists( 'is_order_received_page' ) && is_order_received_page() ) {
                if ( isset( $display_settings['woo_order_received'] ) && 'show' == $display_settings['woo_order_received']  ) {
                    $display = 'yes';
                    return; 
                }
            }

            // its a checkout page - but in its not a thank you page
            if ( function_exists( 'is_checkout' ) && is_checkout() ) {
                if ( isset( $display_settings['woo_checkout'] ) && 'show' == $display_settings['woo_checkout']  ) {
                    // its not a thank you page
                    if ( function_exists( 'is_order_received_page' ) && !is_order_received_page() ) {
                        $display = 'yes';
                        return;
                    }
                }
            }

            if ( function_exists( 'is_account_page' ) && is_account_page() ) {
                if ( isset( $display_settings['woo_account'] ) && 'show' == $display_settings['woo_account']  ) {
                    $display = 'yes';
                    return; 
                }
            }

        }
    
        // based on post id's
        $pages_list_toshow = (isset($display_settings['list_showon_pages'])) ? esc_html($display_settings['list_showon_pages']) : '';
        $pages_list_toshow_array = explode(',', $pages_list_toshow);

        if ( is_array($pages_list_toshow_array) && $pages_list_toshow_array[0] ) {
            if ( in_array( $this_page_id, $pages_list_toshow_array ) ) {
                $display = 'yes';
                return;
            }
        }

        // based on catergorys - list
        $list_showon_cat = (isset($display_settings['list_showon_cat'])) ? esc_html( $display_settings['list_showon_cat'] ) : '';
        
        // avoid calling foreach, explode when hide on categorys list is empty
        if( '' !== $list_showon_cat ) {
        
            //  Get current post Categorys list and create an array for that..
            $current_categorys_array = array();
            $current_categorys = get_the_category();
            foreach ( $current_categorys as $category ) {
                $current_categorys_array[] = strtolower($category->name);
            }
        
            $list_showon_cat_array = explode(',', $list_showon_cat);
        
            foreach ( $list_showon_cat_array as $category ) {
                $category_trim = trim($category);
                if ( in_array( strtolower($category_trim), $current_categorys_array ) ) {
                    $display = 'yes';
                    return;
                }
            }
        }
    } elseif ( is_archive() ) {
        // loop posts

        // woocommerce shop - archive
        if ( class_exists( 'WooCommerce' ) ) {
            if ( function_exists( 'is_shop' ) && is_shop() ) {
                if ( isset( $display_settings['woo_shop'] ) && 'show' == $display_settings['woo_shop']  ) {
                    $display = 'yes';
                    return; 
                }
            }
        }

        // category
        if ( is_category() ) {
            if ( isset( $display_settings['category'] ) && 'show' == $display_settings['category'] ) {
                $display = 'yes';
                return;
            }
        }
        
        // archive
        if ( is_archive() ) {
            if ( isset( $display_settings['archive'] ) && 'show' == $display_settings['archive'] ) {
                $display = 'yes';
                return;
            }
        }
    }


    // 404 page
    if ( is_404() ) {
        if ( isset( $display_settings['page_404'] ) && 'show' == $display_settings['page_404'] ) {
            $display = 'yes';
            return;
        }
    }

} else {
    // global value: show on all pages
    $display = 'yes';

    // if any page override to hide

    // is_home and is_front_page - combined. 
    if ( is_home() || is_front_page() ) {
        if ( isset( $display_settings['home'] ) && 'hide' == $display_settings['home'] ) {
            $display = 'no';
            return;
        }
    }

    if ( is_singular() ) {
        // singular post .. any post type, single page

        // is_single (post type: posts or other(custom post type or so ..), but not pages )
        if ( is_single() ) {
            
            if ( 'post' == $post_type ) {
                
                if ( isset( $display_settings['posts'] ) && 'hide' == $display_settings['posts'] ) {
                    $display = 'no';
                    return;
                }
            } else {
                // custom post type (but not woo single product pages)

                $custom_post_types = get_post_types( array('public' => true, '_builtin' => false) );
                unset($custom_post_types['product']);

                if ( !empty($custom_post_types ) ) {
                    if ( in_array( $post_type, $custom_post_types ) ) {
                        if ( isset( $display_settings[$post_type] ) && 'hide' == $display_settings[$post_type] ) {
                            $display = 'yes';
                            return;
                        }
                    }
                }
                
            }
        }
        
        // page
        if ( is_page() ) {
            if ( ( !is_home() ) && ( !is_front_page() ) ) {
                if ( isset( $display_settings['pages'] ) && 'hide' == $display_settings['pages'] ) {
                    $display = 'no';
                    return;
                }
            }
        }

        // woocommerce (shop page is at archive)
        if ( class_exists( 'WooCommerce' ) ) {
            
            if ( function_exists( 'is_product' ) && is_product() ) {
                if ( isset( $display_settings['woo_product'] ) && 'hide' == $display_settings['woo_product'] ) {
                    $display = 'no';
                    return; 
                }
            }

            if ( function_exists( 'is_cart' ) && is_cart() ) {
                if ( isset( $display_settings['woo_cart'] ) && 'hide' == $display_settings['woo_cart']  ) {
                    $display = 'no';
                    return; 
                }
            }

            // this have to be before checkout
            if ( function_exists( 'is_order_received_page' ) && is_order_received_page() ) {
                if ( isset( $display_settings['woo_order_received'] ) && 'hide' == $display_settings['woo_order_received']  ) {
                    $display = 'no';
                    return; 
                }
            }

            // its a checkout page - but in its not a thank you page
            if ( function_exists( 'is_checkout' ) && is_checkout() ) {
                if ( isset( $display_settings['woo_checkout'] ) && 'hide' == $display_settings['woo_checkout']  ) {
                    if ( function_exists( 'is_order_received_page' ) && !is_order_received_page() ) {
                        $display = 'no';
                        return; 
                    }
                }
            }

            if ( function_exists( 'is_account_page' ) && is_account_page() ) {
                if ( isset( $display_settings['woo_account'] ) && 'hide' == $display_settings['woo_account']  ) {
                    $display = 'no';
                    return; 
                }
            }

        }

        

        // based on post id's'
        $pages_list_tohide = (isset($display_settings['list_hideon_pages'])) ? esc_html($display_settings['list_hideon_pages']) : '';
        $pages_list_tohide_array = explode(',', $pages_list_tohide);

        if( ( is_single() || is_page() ) ) {
            if( is_array($pages_list_tohide_array) && $pages_list_tohide_array[0] ) {
                if( in_array( $this_page_id, $pages_list_tohide_array ) ) {
                    $display = 'no';
                    return;
                }
            }
        }

        // Hide styles on this catergorys - list
        $list_hideon_cat = (isset($display_settings['list_hideon_cat'])) ? esc_html( $display_settings['list_hideon_cat'] ) : '';
        
        // avoid calling foreach, explode when hide on categorys list is empty
        if( '' !== $list_hideon_cat ) {
        
            //  Get current post Categorys list and create an array for that..
            $current_categorys_array = array();
            $current_categorys = get_the_category();
            foreach ( $current_categorys as $category ) {
                $current_categorys_array[] = strtolower($category->name);
            }
        
            $list_hideon_cat_array = explode(',', $list_hideon_cat);
        
            foreach ( $list_hideon_cat_array as $category ) {
                $category_trim = trim($category);
                if ( in_array( strtolower($category_trim), $current_categorys_array ) ) {
                    $display = 'no';
                    return;
                }
            }
        }

        

    } elseif ( is_archive() ) {
        // loop posts

        // woocommerce shop - archive
        if ( class_exists( 'WooCommerce' ) ) {
            if ( function_exists( 'is_shop' ) && is_shop() ) {
                if ( isset( $display_settings['woo_shop'] ) && 'hide' == $display_settings['woo_shop']  ) {
                    $display = 'no';
                    return; 
                }
            }
        }

        // category
        if ( is_category() ) {
            if ( isset( $display_settings['category'] ) && 'hide' == $display_settings['category'] ) {
                $display = 'no';
                return;
            }
        }
        
        // archive
        if ( is_archive() ) {
            if ( isset( $display_settings['archive'] ) && 'hide' == $display_settings['archive'] ) {
                $display = 'no';
                return;
            }
        }

    }
    
    // 404 page
    if ( is_404() ) {
        if ( isset( $display_settings['page_404'] ) && 'hide' == $display_settings['page_404'] ) {
            $display = 'no';
            return;
        }
    }
    
    
}