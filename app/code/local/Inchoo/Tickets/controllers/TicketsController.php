<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 31.08.15.
 * Time: 13:12
 */

class Inchoo_Tickets_TicketsController extends Mage_Core_Controller_Front_Action {
    /**
     * Checking if user is logged in or not for any action in this controller
     */
    public function preDispatch()
    {
        parent::preDispatch();
        if (!Mage::getSingleton('customer/session')->authenticate($this)) {
            $this->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH, true);

            // adding message in customer login page
            Mage::getSingleton('core/session')
                ->addSuccess(Mage::helper('inchoo_tickets')->__('Please sign in or create a new account.'));
        }
    }

    /**
     * Shows customers tickets & add new ticket form
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle($this->__('My Tickets'));
        $this->renderLayout();
    }

    /**
     * Adds a new ticket
     */
    public function addTicketAction()
    {
        if (!$this->_validateFormKey()) return $this->_redirect('inchoo/tickets');

        if ($this->getRequest()->isPost()) {
            $ticket = Mage::getModel('inchoo_tickets/ticket');
            $message = Mage::getModel('inchoo_tickets/message');

            $ticket->setCustomer_id(Mage::getSingleton('customer/session')->getCustomer()->getId())
                ->setSubject($this->getRequest()->getPost('subject'));

            if ($ticket->validateSubject()){
                $ticket->save();

                $message->setTicket_id($ticket->getTicket_id())
                    ->setMessage($this->getRequest()->getPost('message'))
                    ->setAuthor(true); // true=customer

                if ($message->validateMessage()) $message->save();

                $ticket->sendNotificationEmailToAdmin();
            }
        }
        $this->_redirect('inchoo/tickets');
    }

    /**
     * Adds a new message
     */
    public function addMessageAction(){
        if (!$this->_validateFormKey()) return $this->_redirect('inchoo/tickets');

        if ($this->getRequest()->isPost()) {
            $ticketId = $this->getRequest()->getPost('ticket_id');
            $message = Mage::getModel('inchoo_tickets/message');

            $message->setTicket_id($ticketId)
                ->setMessage($this->getRequest()->getPost('message'))
                ->setAuthor(true); // true=customer

            if ($message->validateMessage()) $message->save();
        }

        $this->_redirect("inchoo/tickets/view/ticket/$ticketId");
    }

    /**
     * Closes a ticket
     */
    public function closeAction(){
        $ticket = Mage::getModel('inchoo_tickets/ticket');
        $ticket->load((int)$this->getRequest()->getParam('ticket'))
            ->setStatus(0)
            ->save();

        $this->_redirect('inchoo/tickets');
    }

    public function openAction(){
        $ticket = Mage::getModel('inchoo_tickets/ticket');
        $ticket->load((int)$this->getRequest()->getParam('ticket'))
            ->setStatus(1)
            ->save();

        $this->_redirect('inchoo/tickets');
    }

    public function viewAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle($this->__('Ticket #').$this->getRequest()->getParam('ticket'));
        $this->renderLayout();
    }
}