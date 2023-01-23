<?php

function elex_get_price_display_html_filter($price='', $product){

    $reg_price = '';

    if( ! $product->is_type( 'variable' )){

        $suffix = $product->get_price_suffix($price);

        $st_price = get_post_meta($product->id,'_regular_price',true);

        if($product->get_sale_price()){

            $price = $product->get_price();

        }else{

            $price = $product->get_regular_price();
        }

        if($st_price !== $price){

            return wc_format_sale_price($st_price, $price).$suffix;    
        }

    }
    
    return wc_price($price);
}