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
class GoMage_LegalPerson_Model_Entity_Address_Attribute_Backend_Type
    extends Mage_Eav_Model_Entity_Attribute_Backend_Abstract
{

    /**
     * Retrieve default value
     *
     * @return mixed
     */
    public function getDefaultValue()
    {
        if ($this->_defaultValue === null) {
            $this->_defaultValue = intval(Mage::getStoreConfig('gomage_checkout/person/default'));
        }
        return $this->_defaultValue;
    }

}