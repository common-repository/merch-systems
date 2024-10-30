<?php

/**
 * @package merchsys
 * @subpackage merchsys/public
 */
class MerchSys_Settings
{

    const PLUGIN_NAME = 'merchsys';

    const PLUGIN_VERSION = '1.0.0';

    const CUSTOM_FOLDER = 'merchsys_custom';

    // the folder needs to be locarted in the wp content folder
    const COOKIE_NAME = 'MerchSysSessID';

    // the cookie name to store the session id

    /**
     * The $_GET common fields
     */
    const REDIRECT_FIELD = 'ms_r';

    const REFERRER_FIELD = 'ms_ref';

    const CONTEXT_FIELD = 'ms_c';

    const PAGE_FIELD = 'ms_p';

    const ACTION_FIELD = 'ms_a';

    const MESSAGE_FIELD = 'ms_m';

    /**
     * The Default WP field names for the user registration form
     */
    const FIELD_USERNAME = 'user_login';

    const FIELD_EMAIL = 'user_email';

    const FIELD_PASSWORD = 'user_pass';

    /**
     * The default WP fields for the user registration form
     */
    public static $wp_registration_fields = array(
        array(
            'name' => self::FIELD_USERNAME,
            'type' => 'text',
            'required' => true,
            'label' => 'Username',
            'placeholder' => 'Username',
        ),
        array(
            'name' => self::FIELD_PASSWORD,
            'type' => 'password',
            'required' => true,
            'label' => 'Password',
            'placeholder' => 'Password',
        ),
        array(
            'name' => 'password_confirm',
            'type' => 'password',
            'required' => true,
            'compare' => self::FIELD_PASSWORD,
            'label' => 'Confirm password',
            'placeholder' => 'Confirm password',
        ),
    );

    /**
     * The custom fields for the user registration form
     */
    public static $registration_fields = array(
        array(
            'name' => self::FIELD_EMAIL,
            'type' => 'email',
            'required' => true,
            'label' => 'Email',
            'placeholder' => 'Email',
        ),
        array(
            'name' => 'email_confirm',
            'type' => 'email',
            'required' => true,
            'compare' => self::FIELD_EMAIL,
            'label' => 'Confirm Email',
            'placeholder' => 'Confirm Email',
        ),
        array(
            'name' => 'personal_details',
            'type' => 'label',
            'title' => 'Your personal details',
        ),
        array(
            'name' => 'company',
            'type' => 'text',
            'required' => false,
            'label' => 'Company',
            'placeholder' => 'Company',
        ),
        array(
            'name' => 'first_name',
            'type' => 'text',
            'required' => true,
            'label' => 'First name',
            'placeholder' => 'First name',
        ),
        array(
            'name' => 'last_name',
            'type' => 'text',
            'required' => true,
            'label' => 'Last name',
            'placeholder' => 'Last name',
        ),
        array(
            'name' => 'phone',
            'type' => 'text',
            'required' => false,
            'label' => 'Phone',
            'placeholder' => 'Phone',
        ),
        array(
            'name' => 'address',
            'type' => 'label',
            'title' => 'Your address',
        ),
        array(
            'name' => 'street',
            'type' => 'text',
            'required' => true,
            'label' => 'Street',
            'placeholder' => 'Street',
        ),
        array(
            'name' => 'number',
            'type' => 'text',
            'required' => true,
            'label' => 'Number',
            'placeholder' => 'Number',
        ),
        array(
            'name' => 'zip',
            'type' => 'text',
            'required' => true,
            'label' => 'Postcode',
            'placeholder' => 'Postcode',
        ),
        array(
            'name' => 'city',
            'type' => 'text',
            'required' => true,
            'label' => 'City',
            'placeholder' => 'City',
        ),
        array(
            'name' => 'country',
            'type' => 'select',
            'required' => true,
            'label' => 'Country',
            'options_list' => array(
                '',
            ),
            'options_list_method' => 'get_countries',
        ),
        array(
            'name' => 'privacy_accepted',
            'type' => 'checkbox',
            'required' => true,
            'link' => 'privacy',
            'label' => 'Privacy read and accepted',
        ),
    );

    /**
     * The message keys as defined in the client response
     */
    public static $message_keys = array(
        'error.undefined' => 'An error occurred.',
        'error.mandatoryfields' => 'Please fill all mandatory fields.',
        'error.invalidemail' => 'The given email address is invalid.',
        'error.insufficientamount' => 'This product is not in stock anymore.',
        'error.invalidamount' => 'The given amount is not valid.',
        'error.maxperuser' => 'Maximum per user exceeded.',
        'error.invalidaddress' => 'The given address is not valid.',
        'error.minorderamount' => 'The minimum order amount has not been reached.',
        'error.invalidownloadcode' => 'The downloadcode is invalid.',
        'error.invalidvoucher' => 'The voucher is invalid.',
        'error.invalidvoucherproducts' => 'The voucher is not valid for the products in the basket.',
        'success.update' => 'The changes have been saved.',
        'success.orders.changeamount' => 'The amount has been changed.',
        'success.orders.deleteamount' => 'The product has been deleted.',
        'success.orders.insertitem' => 'The item has been added.',
        'success.orders.insertitem.corrected' => 'The item has been added, but the amount has been reduced due to the availability of the item.',
        'success.voucher' => 'The voucher has been added to the shopping cart.',
    );
}

/*
 * Strings to be automatically added to the translation .po files
 */

__('Username');
__('Password');
__('Confirm password');
__('Email');
__('Confirm Email');
__('Your personal details');
__('Company');
__('First name');
__('Last name');
__('Phone');
__('Your address');
__('Street');
__('Number');
__('Postcode');
__('City');
__('Country');
__('An error occurred.');
__('Please fill all mandatory fields.');
__('The given email address is invalid.');
__('This product is not in stock anymore.');
__('The given amount is not valid.');
__('Maximum per user exceeded.');
__('The given address is not valid.');
__('The minimum order amount has not been reached.');
__('The downloadcode is invalid.');
__('The voucher is invalid.');
__('The voucher is not valid for the products in the basket.');
__('The changes have been saved.');
__('The amount has been changed.');
__('The product has been deleted.');
__('The item has been added.');
__('The item has been added, but the amount has been reduced due to the availability of the item.');
__('The voucher has been added to the shopping cart.');
