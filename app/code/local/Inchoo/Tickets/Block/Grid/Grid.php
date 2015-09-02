<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 02.09.15.
 * Time: 13:13
 */
class Inchoo_Tickets_Block_Grid_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct()
    {
        parent::__construct();
        $this->setId('grid_id');
        // $this->setDefaultSort('COLUMN_ID');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('inchoo_tickets/ticket')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'ticket_id',
            array(
                'header'=> $this->__('Ticket Id'),
                'width' => '50px',
                'index' => 'ticket_id',
                'type' => 'text'
            )
        );
        $this->addColumn(
            'customer_id',
            array(
                'header'=> $this->__('Customer Id'),
                'width' => '50px',
                'index' => 'customer_id',
                'type' => 'text'
            )
        );
        $this->addColumn(
            'status',
            array(
                'header'=> $this->__('Status'),
                'width' => '50px',
                'index' => 'status',
                'type' => 'text',
                'getter' => 'getStatus'
            )
        );
        $this->addColumn(
            'subject',
            array(
                'header'=> $this->__('Subject'),
                'width' => '50px',
                'type' => 'text',
                'getter' => 'getSubject'
            )
        );
        $this->addColumn(
            'timestamp',
            array(
                'header'=> $this->__('Time'),
                'width' => '50px',
                'type' => 'datetime',
                'getter' => 'getTimestamp'
            )
        );
        $this->addColumn(
            'action',
            array(
                'header'=> $this->__('Action'),
                'width' => '50px',
                'type' => 'action',
                'actions' => [
                    [
                        'caption' => $this->__('Close'),
                        'url' => ['base' => '*/*/close']
                    ],
                    [
                        'caption' => $this->__('Edit'),
                        'url' => ['base' => '*/*/edit']
                    ]
                ]
            )
        );

        $this->addExportType('*/*/exportCsv', $this->__('CSV'));
        $this->addExportType('*/*/exportExcel', $this->__('Excel XML'));
        
        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
       return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    }
