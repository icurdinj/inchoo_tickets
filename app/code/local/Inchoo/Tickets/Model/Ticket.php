<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 31.08.15.
 * Time: 11:45
 */ 
class Inchoo_Tickets_Model_Ticket extends Mage_Core_Model_Abstract
{
    const ENTITY = 'ticket';
    const EMAIL_EVENT_NAME_NEW_TICKET = 'new_ticket';

    protected function _construct()
    {
        $this->_init('inchoo_tickets/ticket');
    }

    public function validateSubject(){
        return Zend_Validate::is($this->getSubject(), 'StringLength', ['min'=>1, 'max'=>255]);
    }

    public function getStatus()
    {
        if ($this->getData('status') == 1) return 'Open';
        else return 'Closed';
    }

    /**
     * Wrapper for getCreated_at().
     *
     * This function previously returned date from first message:
     * <code>$messages = Mage::getModel('inchoo_tickets/message')
     *  ->getCollection()
     *  ->addFieldToFilter('ticket_id', $this->getTicket_id())
     *  ->addOrder('ticket_message_id', 'ASC');
     * $message = $messages->getFirstItem();
     * return $message->getTimestamp();</code>
     * Now it returns Created_at column from this model
     *
     * @return string
     */
    public function getTimestamp(){
        return $this->getCreated_at();
    }

    public function sendNotificationEmailToAdmin()
    {
        $helper = Mage::helper('inchoo_tickets');

        if ($helper->isEmailEnabled()) {
            try {
                $store = Mage::app()->getStore();
                $storeId = $store->getId();

                $emailInfo = Mage::getModel('core/email_info');
                $emailInfo->addTo(
                    $helper->getCustomerSupportEmail($storeId),
                    $helper->getCustomerSupportName($storeId)
                );

                $emailQueue = Mage::getModel('core/email_queue');
                $emailQueue->setEntityId($this->getId())
                    ->setEntityType(self::ENTITY)
                    ->setEventType(self::EMAIL_EVENT_NAME_NEW_TICKET)
                    ->setIsForceCheck(true);

                $mailer = Mage::getModel('core/email_template_mailer');
                $mailer->addEmailInfo($emailInfo);
                $mailer->setSender([
                    'email' => 'automated@magento.loc',
                    'name' => 'automated'
                ]);
                $mailer->setStoreId($storeId);
                $mailer->setTemplateId($helper->getEmailTemplate($storeId));
                $mailer->setTemplateParams([]);

                $mailer->setQueue($emailQueue)->send();
            } catch (Exception $e) {
                Mage::logException($e);
            }
        }
    }
}