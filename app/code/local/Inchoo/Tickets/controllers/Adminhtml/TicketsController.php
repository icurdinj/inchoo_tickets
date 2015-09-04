<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 02.09.15.
 * Time: 12:35
 */

class Inchoo_Tickets_Adminhtml_TicketsController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('inchoo_tickets/grid'));
        $this->renderLayout();
    }

    public function exportCsvAction()
    {
        $fileName = '_export.csv';
        $content = $this->getLayout()->createBlock('inchoo_tickets/grid_grid')->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function exportExcelAction()
    {
        $fileName = '_export.xml';
        $content = $this->getLayout()->createBlock('inchoo_tickets/grid_grid')->getExcel();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('inchoo_tickets/ticket');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->_getSession()->addError(
                    Mage::helper('inchoo_tickets')->__('This  no longer exists.')
                );
                $this->_redirect('*/*/');
                return;
            }
        }

        $data = $this->_getSession()->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('current_model', $model);

        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('inchoo_tickets/grid_edit'));
        $this->renderLayout();
    }

    public function saveAction()
    {
        $redirectBack = $this->getRequest()->getParam('back', false);
        if ($data = $this->getRequest()->getPost()) {

            $id = $this->getRequest()->getParam('id');
            $model = Mage::getModel('inchoo_tickets/ticket');
            if ($id) {
                $model->load($id);
                if (!$model->getId()) {
                    $this->_getSession()->addError(
                        Mage::helper('inchoo_tickets')->__('This  no longer exists.')
                    );
                    $this->_redirect('*/*/index');
                    return;
                }
            }

            // save model
            try {
                $model->addData($data);
                $this->_getSession()->setFormData($data);
                $model->save();
                $this->_getSession()->setFormData(false);
                $this->_getSession()->addSuccess(
                    Mage::helper('inchoo_tickets')->__('The  has been saved.')
                );
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                $redirectBack = true;
            } catch (Exception $e) {
                $this->_getSession()->addError(Mage::helper('inchoo_tickets')->__('Unable to save the .'));
                $redirectBack = true;
                Mage::logException($e);
            }

            if ($redirectBack) {
                $this->_redirect('*/*/edit', array('id' => $model->getId()));
                return;
            }
        }
        $this->_redirect('*/*/index');
    }

    public function addMessageAction()
    {
        if (!$this->_validateFormKey()) return $this->_redirect('adminhtml/tickets');

        if ($this->getRequest()->isPost()) {
            $ticketId = $this->getRequest()->getPost('ticket_id');
            $message = Mage::getModel('inchoo_tickets/message');

            $message->setTicket_id($ticketId)
                ->setMessage($this->getRequest()->getPost('message'))
                ->setAuthor(false); // false=admin

            if ($message->validateMessage()) $message->save();
        }

        $this->_redirect("adminhtml/tickets/edit/id/$ticketId");
    }
}