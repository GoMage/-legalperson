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

class GoMage_LegalPerson_Block_Onepage_Shipping extends GoMage_Checkout_Block_Onepage_Shipping
{

    /**
     * @param  array $fields
     * @return string
     */
    protected function _renderFields($fields)
    {
        /** @var GoMage_LegalPerson_Block_Address_Fields $block */
        $block = $this->getLayout()->createBlock('gomage_legalperson/address_fields');
        $block->setAddress($this->getAddress())
            ->setPrefix($this->prefix)
            ->setCountryElementId('country_id')
            ->setTemplate('gomage/legalperson/address/fields.phtml');

        return $block->toHtml() . parent::_renderFields($fields);
    }

}