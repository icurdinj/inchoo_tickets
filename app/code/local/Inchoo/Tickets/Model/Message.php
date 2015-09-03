<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 31.08.15.
 * Time: 12:42
 */ 
class Inchoo_Tickets_Model_Message extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('inchoo_tickets/ticketMessage');
    }

    public function validateMessage()
    {
        return Zend_Validate::is($this->getMessage(), 'StringLength', ['min'=>1, 'max'=>255]);
    }

    public function getAuthor(){
        if ($this->getData('author') == 1) return 'Customer';
        else return 'Admin';
    }
}