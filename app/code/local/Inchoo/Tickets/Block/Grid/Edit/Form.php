<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 02.09.15.
 * Time: 13:13
 */
class Inchoo_Tickets_Block_Grid_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _getModel(){
        return Mage::registry('current_model');
    }

    protected function _getHelper(){
        return Mage::helper('inchoo_tickets');
    }

    protected function _getModelTitle(){
        return 'Ticket';
    }

    protected function _prepareForm()
    {
        $model  = $this->_getModel();
        $modelTitle = $this->_getModelTitle();
        $form   = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('*/*/save'),
            'method'    => 'post'
        ));

        $fieldset   = $form->addFieldset('base_fieldset', array(
            'legend'    => $this->_getHelper()->__("$modelTitle Status"),
            'class'     => 'fieldset-wide',
        ));

        if ($model && $model->getId()) {
            $modelPk = $model->getResource()->getIdFieldName();
            $fieldset->addField($modelPk, 'hidden', array(
                'name' => $modelPk,
            ));
        }

        $fieldset->addField(
            'status',
            'radios',
            array(
                'name'      => 'status',
                'label'     => $this->_getHelper()->__('Status'),
                'values'    => array(
                    array('label' => 'Open', 'value' => 1),
                    array('label' => 'Closed', 'value' => 0)
                ),
                'style'     => '',
                'class'     => ''
            )
        );

        if ($model){
            $form->setValues($model->getData());
        }
        $form->setUseContainer(true);
        $this->setForm($form);

        $comments_block = $this->getLayout()
            ->createBlock('inchoo_tickets/adminhtml_edit_form_messages')
            ->setTemplate('inchoo_tickets/messages.phtml');
        $this->setChild('form_after', $comments_block);

        return parent::_prepareForm();
    }
}
