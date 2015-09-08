<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 31.08.15.
 * Time: 09:22
 */ 
class Inchoo_Tickets_Helper_Data extends Mage_Core_Helper_Abstract {
    const XML_PATH_CUSTOMER_SUPPORT_EMAIL = 'trans_email/ident_support/email';
    const XML_PATH_CUSTOMER_SUPPORT_NAME = 'trans_email/ident_support/name';
    const XML_PATH_EMAIL_TEMPLATE = 'customer/inchoo_tickets/email_template';
    const XML_PATH_EMAIL_ENABLED = 'customer/inchoo_tickets/enabled';

    public function getCustomerSupportEmail($store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_CUSTOMER_SUPPORT_EMAIL, $store);
    }

    public function getCustomerSupportName($store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_CUSTOMER_SUPPORT_NAME, $store);
    }

    public function getEmailTemplate($store = null)
    {
        return Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE, $store);
    }

    public function isEmailEnabled($store = null)
    {
        return (bool)Mage::getStoreConfig(self::XML_PATH_EMAIL_ENABLED, $store);
    }
}