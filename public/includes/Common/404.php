<?php

/**
 * @package merchsys
 * @subpackage merchsys/public/includes/Shop
 */

/**
 * Class to show a 404 Page for the plugins pages.
 * Called if the template is missing
 */
class MerchSys_Common_404 extends MerchSys_Common_Base
{

    public function __construct()
    {
        parent::__construct('404');
        $this->message = __('404 Page not found', MerchSys_Helper::$plugin_name);
    }
}