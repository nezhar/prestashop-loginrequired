<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class LoginRequired extends Module
{
    private $excludeRedirectScreens = ['authentication', 'contact', 'password'];

    public function __construct()
    {
        $this->name = 'loginrequired';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'nezhar';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Login Required');
        $this->description = $this->l('A module that redirects users to the login page if they are not logged in.');

        $this->ps_versions_compliancy = array('min' => '1.5', 'max' => _PS_VERSION_);
    }

    public function install()
    {
        return parent::install() && $this->registerHook('displayHeader');
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    public function getContent()
    {
    }

    /**
     * Redirect all pages except login and password reset to the login screen
     */
    public function hookDisplayHeader()
    {
        if (!$this->context->customer->isLogged() && !in_array(Context::getContext()->controller->php_self, $this->excludeRedirectScreens)) {
            Tools::redirect('index.php?controller=authentication');
        }
    }
}
