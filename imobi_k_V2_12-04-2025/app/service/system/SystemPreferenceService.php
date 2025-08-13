<?php

use Adianti\Database\TTransaction;

class SystemPreferenceService
{
    private static $initialized = false;
    public static $preferences;

    private static function initialize() {

        if (!self::$initialized) {

            $transactionClose = false;
            if(!TTransaction::isOpen('permission'))
            {
                $transactionClose = true;
                TTransaction::openFake('permission');
            }

            self::$preferences = SystemPreference::getAllPreferences();
            self::$initialized = true;

            if ($transactionClose)
            {
                TTransaction::close();
            }
        }
    }

    public static function getPreferences()
    {
        self::initialize();

        return  self::$preferences;
    }

    public static function isStrongPasswordEnabled()
    {
        self::initialize();

        if(!empty(self::$preferences['strong_password']) && self::$preferences['strong_password'] == 'T')
        {
            return true;
        }
        
        return false;
    }

    public static function verifyMaintenanceEnabled($user)
    {
        self::initialize();

        if(!empty(self::$preferences['maintenance_enabled']) && self::$preferences['maintenance_enabled'] == 'T' && $user->login != 'admin')
        {
            if(empty(self::$preferences['maintenance_users']) || !in_array($user->id, explode(',', self::$preferences['maintenance_users'])) )
            {
                throw new Exception(self::$preferences['maintenance_message']);
            }   
        }
    }

    public static function isGoogleRecaptchaEnabled()
    {
        self::initialize();

        if(!empty(self::$preferences['google_recaptcha']) && self::$preferences['google_recaptcha'] == 'T' && !empty(self::$preferences['google_recaptcha_site_key']) && !empty(self::$preferences['google_recaptcha_secret_key']))
        {
            return true;
        }
        
        return false;
    }

    public static function isTwoFactorByEmailEnabled()
    {
        self::initialize();

        if(!empty(self::$preferences['2fa_by_email']) && self::$preferences['2fa_by_email'] == 'T')
        {
            return true;
        }
        
        return false;
    }

    public static function isTwoFactorByGoogleAuthEnabled()
    {
        self::initialize();

        if(!empty(self::$preferences['2fa_by_google_auth']) && self::$preferences['2fa_by_google_auth'] == 'T')
        {
            return true;
        }
        
        return false;
    }
}