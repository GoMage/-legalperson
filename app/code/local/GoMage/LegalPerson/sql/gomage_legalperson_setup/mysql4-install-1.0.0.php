<?php
/**
 * GoMage LegalPerson Extension
 *
 * @category     Extension
 * @copyright    Copyright (c) 2010-2017 GoMage (https://www.gomage.com)
 * @author       GoMage
 * @license      https://www.gomage.com/license-agreement/  Single domain license
 * @terms of use https://www.gomage.com/terms-of-use
 * @version      Release: 1.0.0
 * @since        Class available since Release 1.0.0
 */

/** @var GoMage_LegalPerson_Model_Entity_Setup $installer */
$installer = $this;
$installer->startSetup();

$regions = $installer->getRegions();

foreach ($regions as $region) {
    $installer->run("
INSERT INTO `{$installer->getTable('directory_country_region')}` (`country_id`, `code`, `default_name`) VALUES 
('RO', '{$region[0]}', '{$region[2]}');
INSERT INTO `{$installer->getTable('directory_country_region_name')}` (`locale`, `region_id`, `name`) VALUES
			('en_US', LAST_INSERT_ID(), '$region[2]'),
			('ro_RO', LAST_INSERT_ID(), '$region[1]');
"
    );
}

$installer->getConnection()
    ->addColumn($installer->getTable('sales_flat_order_address'), 'gm_lp_type', [
            'type'     => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'length'   => 1,
            'default'  => GoMage_LegalPerson_Model_Entity_Source_Type::NATURAL,
            'nullable' => false,
            'comment'  => 'Person Type',
        ]
    );
$installer->getConnection()
    ->addColumn($installer->getTable('sales_flat_quote_address'), 'gm_lp_type', [
            'type'     => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'length'   => 1,
            'default'  => GoMage_LegalPerson_Model_Entity_Source_Type::NATURAL,
            'nullable' => false,
            'comment'  => 'Person Type',
        ]
    );


$fields = array(
    'gm_lp_tro'  => 'Number in Trade Register Office',
    'gm_lp_bank' => 'Bank',
    'gm_lp_iban' => 'IBAN',
    'gm_lp_pc'   => 'Personal Numerical Code',
    'gm_lp_card' => 'Series and number of the ID card',
);

foreach ($fields as $field => $label) {
    $installer->getConnection()
        ->addColumn($installer->getTable('sales_flat_order_address'), $field, [
                'type'    => Varien_Db_Ddl_Table::TYPE_TEXT,
                'length'  => 255,
                'comment' => $label,
            ]
        );
    $installer->getConnection()
        ->addColumn($installer->getTable('sales_flat_quote_address'), $field, [
                'type'    => Varien_Db_Ddl_Table::TYPE_TEXT,
                'length'  => 255,
                'comment' => $label,
            ]
        );
}

$used_in_forms = array('adminhtml_customer_address', 'customer_register_address', 'customer_address_edit');

$installer->addAttribute('customer_address', 'gm_lp_type', array(
        'type'           => 'int',
        'backend'        => 'gomage_legalperson/entity_address_attribute_backend_type',
        'label'          => 'Person Type',
        'input'          => 'select',
        'source'         => 'gomage_legalperson/entity_source_type',
        'frontend_class' => 'gm_lp_type',
        'visible'        => true,
        'required'       => false,
        'default'        => '',
        'frontend'       => '',
        'unique'         => false,
        'note'           => '',
    )
);

$sort_order = 11;
$attribute  = Mage::getSingleton('eav/config')->getAttribute('customer_address', 'gm_lp_type');
$attribute->setData('used_in_forms', $used_in_forms)
    ->setData('is_used_for_customer_segment', true)
    ->setData('is_system', 0)
    ->setData('is_user_defined', 1)
    ->setData('is_visible', 1)
    ->setData('sort_order', $sort_order)
    ->save();

foreach ($fields as $field => $label) {
    $installer->addAttribute('customer_address', $field, array(
            'type'           => 'varchar',
            'backend'        => '',
            'label'          => $label,
            'input'          => 'text',
            'source'         => '',
            'frontend_class' => $field,
            'visible'        => true,
            'required'       => false,
            'default'        => '',
            'frontend'       => '',
            'unique'         => false,
            'note'           => '',
        )
    );
    $attribute = Mage::getSingleton('eav/config')->getAttribute('customer_address', $field);
    $attribute->setData('used_in_forms', $used_in_forms)
        ->setData('is_used_for_customer_segment', true)
        ->setData('is_system', 0)
        ->setData('is_user_defined', 1)
        ->setData('is_visible', 1)
        ->setData('sort_order', $sort_order++)
        ->save();
}

$installer->endSetup();
	 