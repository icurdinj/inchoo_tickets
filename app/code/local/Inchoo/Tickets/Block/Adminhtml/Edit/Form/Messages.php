<?php

/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 03.09.15.
 * Time: 15:25
 */
class Inchoo_Tickets_Block_Adminhtml_Edit_Form_Messages extends Mage_Adminhtml_Block_Template
{
    protected $ticket_id;

    public function __construct()
    {
        parent::__construct();
        $this->ticket_id = (int)$this->getRequest()->getParam('id');
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

    /**
     * @return int ticket id
     */
    protected function getTicketId(){
        return (int)$this->getRequest()->getParam('id');
    }
}
