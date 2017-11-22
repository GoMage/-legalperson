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
class  GoMage_LegalPerson_Model_Observer
{
    static public function checkK($event)
    {
        $key = Mage::getStoreConfig('gomage_activation/legalperson/key');
        Mage::helper('gomage_legalperson')->a($key);
    }
}