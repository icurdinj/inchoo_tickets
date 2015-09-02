<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 31.08.15.
 * Time: 09:22
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

// Ticket Entity
$installer->getConnection()->createTable(
    $installer->getConnection()
    ->newTable($installer->getTable('inchoo_tickets/ticket'))
    ->addColumn(
        'ticket_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true
        ],
        'Id'
    )
    ->addColumn(
        'customer_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'unsigned' => true,
            'nullable' => false
        ],
        'Customer Id'
    )
    ->addIndex('IDX_CUSTOMER_ID', 'customer_id')
    ->addForeignKey('FK_CUSTOMER_ID', 'customer_id', 'customer_entity', 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->addColumn(
        'status',
        Varien_Db_Ddl_Table::TYPE_BOOLEAN, // true=open, false=closed
        null,
        [
            'default' => true,
            'nullable' => false
        ],
        'Ticket status'
    )
    ->addColumn(
        'subject',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        255,
        [
            'nullable' => false
        ],
        'Ticket subject'
    )
    ->setComment('Inchoo_Tickets ticket entity')
);

// Ticket message entity
$installer->getConnection()->createTable(
    $installer->getConnection()
    ->newTable($installer->getTable('inchoo_tickets/ticket_message'))
    ->addColumn(
        'ticket_message_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true
        ],
        'Id'
    )
    ->addColumn(
        'ticket_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        [
            'unsigned' => true,
            'nullable' => false
        ],
        'Ticket Id'
    )
    ->addIndex('IDX_TICKET_ID', 'ticket_id')
    ->addForeignKey('FK_TICKET_ID', 'ticket_id', 'ticket', 'ticket_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->addColumn(
        'timestamp',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        [
            'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
            'nullable' => false
        ],
        'Timestamp'
    )
    ->addColumn(
        'message',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        255,
        [
            'nullable' => false
        ],
        'Message'
    )
    ->addColumn(
        'author',
        // true=customer, false=admin (would need a rework to allow for multiple admins!)
        Varien_Db_Ddl_Table::TYPE_BOOLEAN,
        null,
        [
            'nullable' => false
        ],
        'Message author'
    )
    ->setComment('Inchoo_Tickets ticket message entity')
);

$installer->endSetup();