<?php

/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 01.09.15.
 * Time: 14:12
 */
class Inchoo_Tickets_Block_Ticket extends Mage_Core_Block_Template
{
    protected $ticket_id;

    public function __construct()
    {
        parent::__construct();
        $this->ticket_id = (int)$this->getRequest()->getParam('ticket');
    }

    /**
     * @return Inchoo_Tickets_Model_Resource_TicketMessage_Collection
     */
    public function getMessages(){

        return Mage::getResourceModel('inchoo_tickets/ticketMessage_collection')
            ->addFieldToSelect('*')
            ->addFieldToFilter('ticket_id', $this->ticket_id)
            ->setOrder('ticket_message_id', 'asc');
    }

    public function getSubject()
    {
        return Mage::getModel('inchoo_tickets/ticket')->load($this->ticket_id)->getSubject();
    }

    public function getStatus(){
        return Mage::getModel('inchoo_tickets/ticket')->load($this->ticket_id)->getStatus();
    }

    public function getTicketId()
    {
        return $this->ticket_id;
    }
}