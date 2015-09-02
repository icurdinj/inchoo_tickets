<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 02.09.15.
 * Time: 13:13
 */
class Inchoo_Tickets_Block_Grid extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct()
    {
        $this->_blockGroup      = 'inchoo_tickets';
        $this->_controller      = 'grid';
        $this->_headerText      = $this->__('Tickets');
        //$this->_addButtonLabel  = $this->__('Add Button Label');
        parent::__construct();
    }

    public function getCreateUrl()
    {
        return $this->getUrl('*/*/new');
    }

}

