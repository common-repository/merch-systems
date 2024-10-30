<?php

/**
 * @package merchsys
 * @subpackage merchsys/public
 */
class MerchSys_Public
{

    private $plugin_name;

    private $version;

    private $locale;

    public static $site_URL;

    public static $custom_theme_path;

    public static $custom_theme_url_path;

    public $error = '';

    public static $client;

    public static $currency;

    public static $base_installation_path;

    static $user_id;

    static $user;

    private $context_type;

    // eg shop, registration, ecc

    /**
     * Construct method
     * This function sets:
     * - The SOAP client for the MerchSys plugins
     * - The locale
     * - The base path to the custom folder
     * - The currency from the client
     */
    public function __construct()
    {
        $this->plugin_name = MerchSys_Settings::PLUGIN_NAME;
        $this->version = MerchSys_Settings::PLUGIN_VERSION;
        $this->set_paths();
        $this->load_dependencies();
        self::$site_URL = get_site_url();
        $this->locale = MerchSys_Helper::get_locale();
        /* Prepare Url and credentials for the SOAP client */
        $soap_url = get_option('merchsys_soapurl');
        $soap_url = $this->sanitize_soap_url($soap_url);
        $soap_login = get_option('merchsys_soaplogin');
        $soap_pass = get_option('merchsys_soappass');
        if (empty($soap_pass) || empty($soap_login)) {
            self::$client = false;
            return;
        }
        /* Init the SOAP client */
        try {
            $soap_options = array(
                'login' => $soap_login,
                'password' => $soap_pass,
            );
            self::$client = new SoapClient($soap_url, $soap_options);
        } catch (Exception $e) {
            if (strpos($soap_url, 'www.') === false) {
                $soap_url = str_replace('https://', 'https://www.', $soap_url);
                try {
                    self::$client = new SoapClient($soap_url, $soap_options);
                } catch (Exception $e) {
                    $this->error_client();
                    return;
                }
            } else {
                $this->error_client();
                return;
            }
        }
        if ($soap_url != get_option('merchsys_soapurl')) {
            /* Update the soap url in the settings page */
            update_option('merchsys_soapurl', $soap_url, true);
        }
        $this->client_init();
        $this->set_currency();
        return;
    }

    /**
     * This method sets the base folder paths and URL to the custom folder (defined in the class MerchSys_Settings)
     */
    public function set_paths()
    {
        $content_folder = explode('/', trim(content_url(), '/'));
        $content_folder = end($content_folder);
        self::$base_installation_path = ABSPATH . $content_folder . '/';
        self::$custom_theme_path = self::$base_installation_path . MerchSys_Settings::CUSTOM_FOLDER;
        self::$custom_theme_url_path = plugin_dir_url(__FILE__) . '../../../' . MerchSys_Settings::CUSTOM_FOLDER;
    }

    /**
     * The method sanitizes the soap url added in the plgin settings page
     *
     * @param string $url
     *            The given soap url
     * @return string the sanitized url
     */
    private function sanitize_soap_url($url)
    {
        $url = str_replace(array(
            'http://',
            'https://',
            '/wsdl.php',
        ), '', $url);
        return 'https://' . $url . '/wsdl.php';
    }

    /**
     * The initial client set-up
     *
     * - it sets the client cookie
     * - it gets the client session
     * - it sets the client locale
     */
    private function client_init()
    {
        $this->set_cookie();
        $this->get_session();
        $this->set_locale();
    }

    /**
     * Method to set the client cookie
     */
    private function set_cookie()
    {
        if (self::$client == null) {
            return;
        }

        try {
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
            self::$client->__setCookie(MerchSys_Settings::COOKIE_NAME, session_id());
        } catch (Exception $e) {
            $this->error_client($e);
        }
        return;
    }

    /**
     * Method to get the client session
     */
    private function get_session()
    {
        if (self::$client == null) {
            return;
        }

        try {
            self::$client->getSession();
        } catch (Exception $e) {
            $this->error_client($e);
        }
        return;
    }

    /**
     * Method to set the client locale
     *
     * @param $locale The
     *            locale for the client. Optional
     */
    public function set_locale($locale = '')
    {
        if (self::$client == null) {
            return;
        }

        if (strlen($locale) > 0) {
            $this->locale = $locale;
        }

        try {
            self::$client->setLocale($this->locale);
        } catch (Exception $e) {
            $this->error_client($e);
        }
        return;
    }

    /**
     * Method to set the currency as the one given from the client
     */
    public function set_currency()
    {
        if (self::$client == null) {
            return;
        }

        try {
            self::$currency = self::$client->getCurrency();
        } catch (Exception $e) {
            $this->error_client($e);
        }
    }

    /**
     * The method adds en error to show as notification in the WP Admin
     *
     * @param string $errorException
     *            The exception thrown when calling the SOAP client
     */
    public function error_client($errorException = "")
    {
        $this->error .= self::wrap_error(__('Please make sure that the Storekey and Passphrase are defined in your Merchsys settings page', $this->plugin_name));
        if (strlen($errorException) > 0) {
            $this->error .= self::wrap_error($errorException);
        }
        self::$client = null;
    }

    /**
     * The method adds the html markup for the wp admin notification
     *
     * @param string $string
     *            The error to add to the WP admin page
     * @return string The html block for the error notification
     */
    public static function wrap_error($string)
    {
        return '<div class="error notice"><p>' . MerchSys_Settings::PLUGIN_NAME . ' | ' . $string . '</p></div>';
    }

    /**
     * The method lo load all the file dependencies for the public part of the plugin
     */
    private function load_dependencies()
    {
        require_once dirname(__FILE__) . '/includes/Settings.php';
        /* The functions.php file to override certain plugin behaviours from the custom folder */
        if (file_exists(self::$custom_theme_path . '/functions.php')) {
            require_once self::$custom_theme_path . '/functions.php';
        }
        require_once dirname(__FILE__) . '/includes/Merchsys_Utilities.php';
        require_once dirname(__FILE__) . '/includes/Common/Base.php';
        require_once dirname(__FILE__) . '/includes/Common/404.php';
    }

    /**
     * WP Hook to show the errors in the admin area
     */
    public function show_error()
    {
        if (strlen($this->error) > 0) {
            echo $this->error;
        }
    }

    /**
     * Static method to set the current user information
     * Called by the WP Hook plugins_loaded
     */
    public static function set_user_info()
    {
        self::$user_id = get_current_user_id();
        if (self::$user_id != null) {
            self::$user = get_user_meta(self::$user_id);
            $user = get_userdata(self::$user_id);
            self::$user['user_email'] = array(
                $user->user_email,
            );
        } else {
            self::$user = null;
        }
    }

    /**
     * Static method to retrieve the client's Countries list
     */
    public static function get_countries()
    {
        if (self::$client == null) {
            return;
        }

        try {
            return self::$client->getCountries();
        } catch (Exception $e) {
            $class = new self();
            $class->error_client($e);
        }
    }

    /**
     * Static method to retrieve the client's payment methods for an order
     */
    public static function get_payment_methods()
    {
        if (self::$client == null) {
            return;
        }

        try {
            return self::$client->getPayments();
        } catch (Exception $e) {
            $class = new self();
            $class->error_client($e);
        }
    }

    /**
     * Dummy compat method
     */
    public function enqueue_styles() {
    }

    /**
     * Dummy compat method
     */
    public function enqueue_scripts() {
    }
}
