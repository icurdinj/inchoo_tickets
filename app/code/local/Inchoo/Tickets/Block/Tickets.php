<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 31.08.15.
 * Time: 14:47
 */
class Inchoo_Tickets_Block_Tickets extends Mage_Core_Block_Template
{
    /**
     * Return all tickets for current customer
     * @return Inchoo_Tickets_Model_Resource_Ticket_Collection
     */
    public function getTickets(){
        return Mage::getResourceModel('inchoo_tickets/ticket_collection')
            ->addFieldToSelect('*')
            ->addFieldToFilter('customer_id', Mage::getSingleton('customer/session')->getCustomer()->getId())
            ->setOrder('ticket_id', 'desc');
    }

    public function getCloseUrl($ticket)
    {
        return $this->getUrl('inchoo/tickets/close', ['ticket'=>$ticket->getTicket_id()]);
    }

    public function getOpenUrl($ticket)
    {
        return $this->getUrl('inchoo/tickets/open', ['ticket'=>$ticket->getTicket_id()]);
    }

    public function getViewUrl($ticket)
    {
        return $this->getUrl('inchoo/tickets/view', ['ticket'=>$ticket->getTicket_id()]);
    }
}