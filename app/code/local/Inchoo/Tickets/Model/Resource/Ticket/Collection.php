<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 31.08.15.
 * Time: 11:45
 */ 
class Inchoo_Tickets_Model_Resource_Ticket_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('inchoo_tickets/ticket');
    }

    public function joinCustomerEmail()
    {
        $this->getSelect()->join(
            array('customer_table' => 'customer_entity'),
            'main_table.customer_id = customer_table.entity_id',
            array('email')
        );
    }
}