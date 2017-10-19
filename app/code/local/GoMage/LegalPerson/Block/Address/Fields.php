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

class GoMage_LegalPerson_Block_Address_Fields extends Mage_Core_Block_Template
{
    protected $_address;
    protected $_prefix = '';
    protected $_countryElementId = 'country';

    public function setAddress($address)
    {
        $this->_address = $address;
        return $this;
    }

    public function getAddress()
    {
        if (is_null($this->_address)) {
            $this->_address = Mage::getModel('customer/address');
        }
        return $this->_address;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return Mage::getStoreConfigFlag('gomage_checkout/person/enabled');
    }

    /**
     * @return array
     */
    public function getPersonTypeOptions()
    {
        /** @var GoMage_LegalPerson_Model_Entity_Source_Type $type */
        $type = Mage::getModel('gomage_legalperson/entity_source_type');

        return $type->getOptionArray();
    }

    /**
     * @return int
     */
    public function getPersonType()
    {
        $type = $this->getAddress()->getData('gm_lp_type');
        if (empty($type)) {
            $type = intval(Mage::getStoreConfig('gomage_checkout/person/default'));
        }
        return intval($type);
    }

    /**
     * @return array
     */
    public function getTextFields()
    {
        /** @var GoMage_LegalPerson_Helper_Data $helper */
        $helper = $this->helper('gomage_legalperson');
        $fields = $helper->getFieldsLabels();

        return array_diff_key($fields, array_flip(array('company', 'vat_id', 'gm_lp_type')));
    }

    /**
     * @return string
     */
    public function getCountryElementId()
    {
        return $this->_countryElementId;
    }

    /**
     * @param  string $countryElementId
     * @return $this
     */
    public function setCountryElementId($countryElementId)
    {
        $this->_countryElementId = $countryElementId;
        return $this;
    }

    /**
     * @param  string $prefix
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->_prefix = $prefix;
        return $this;
    }

    /**
     * @param  string $id
     * @return string
     */
    public function getFieldId($id)
    {
        return ($this->_prefix ? $this->_prefix . '_' : '') . $id;
    }

    public function getFieldName($name)
    {
        return ($this->_prefix ? $this->_prefix . '[' : '') . $name . ($this->_prefix ? ']' : '');
    }

}
