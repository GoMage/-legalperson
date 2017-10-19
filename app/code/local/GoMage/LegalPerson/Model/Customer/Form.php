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
class GoMage_LegalPerson_Model_Customer_Form extends Mage_Customer_Model_Form
{
    /**
     * @return Mage_Customer_Model_Resource_Form_Attribute_Collection
     */
    protected function _getFormAttributeCollection()
    {
        /** @var GoMage_LegalPerson_Helper_Data $helper */
        $helper     = Mage::helper('gomage_legalperson');
        $collection = parent::_getFormAttributeCollection();

        if (!Mage::getStoreConfigFlag('gomage_checkout/person/enabled')) {
            $collection->addFieldToFilter('attribute_code', array('nin' => $helper->getFieldsName()));
        }
        return $collection;
    }

    /**
     * Set default attribute values for new entity
     *
     * @return GoMage_LegalPerson_Model_Customer_Form
     */
    public function initDefaultValues()
    {
        if (!$this->getEntity()->getId()) {
            /** @var Mage_Customer_Model_Attribute $attribute */
            foreach ($this->getAttributes() as $attribute) {
                $default = '';
                if ($backendModel = $attribute->getBackendModel()) {
                    /** @var Mage_Eav_Model_Entity_Attribute_Backend_Abstract $backendModel */
                    $backendModel = Mage::getModel($backendModel)->setAttribute($attribute);
                    $default      = $backendModel->getDefaultValue();
                }
                if ($default == '') {
                    $default = $attribute->getDefaultValue();
                }
                if ($default != '') {
                    $this->getEntity()->setData($attribute->getAttributeCode(), $default);
                }
            }
        }
        return $this;
    }
}