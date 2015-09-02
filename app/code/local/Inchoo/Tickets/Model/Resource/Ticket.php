<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 31.08.15.
 * Time: 11:45
 */ 
class Inchoo_Tickets_Model_Resource_Ticket extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('inchoo_tickets/ticket', 'ticket_id');
    }

}