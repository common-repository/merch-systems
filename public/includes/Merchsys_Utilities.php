<?php

/**
 * @package merchsys
 * @subpackage merchsys/public
 */

/**
 * Class for common functions
 * Every method calls the function with the same name if defined in the functions.php in the custom folder
 */
class MerchSys_Utilities
{

    /**
     * This method calls function merchsys_filter_product_text
     * It manipulates the product text if different from the one set in the merchsys shop admin
     *
     * @param string $string
     *            The string to be modified
     * @return string $string The modified string
     */
    static function merchsys_filter_product_text($string)
    {
        if (function_exists('merchsys_filter_product_text')) {
            $string = merchsys_filter_product_text($string);
        }
        return $string;
    }

    /**
     * This method is used to get a custom image for the "back to shop" button
     */
    static function merchsys_get_back_to_shop_navigation_image()
    {
        $image = "";
        if (function_exists('merchsys_get_back_to_shop_navigation_image')) {
            $image = merchsys_get_back_to_shop_navigation_image();
        }
        return $image;
    }

    /**
     * This method returns the currency symbol.
     * If the custom function doesn't exist it returns the default ones
     */
    static function get_currency_symbol()
    {
        if (function_exists('get_currency_symbol')) {
            $currency = get_currency_symbol();
        } else {
            switch (MerchSys_Public::$currency) {
                case 'EUR':
                    $currency = '€';
                    break;
                case 'USD':
                    $currency = '$';
                    break;
                default:
                    $currency = MerchSys_Public::$currency;
                    break;
            }
        }
        return $currency;
    }
}
