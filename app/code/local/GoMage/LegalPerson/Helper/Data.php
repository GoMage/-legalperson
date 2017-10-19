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
class GoMage_LegalPerson_Helper_Data extends Mage_Core_Helper_Abstract
{

    /** @var array */
    protected $_fieldsLabels = array(
        'gm_lp_type' => 'Person Type',
        'gm_lp_tro'  => 'Number in Trade Register Office',
        'gm_lp_bank' => 'Bank',
        'gm_lp_iban' => 'IBAN',
        'gm_lp_pc'   => 'Personal Numerical Code',
        'gm_lp_card' => 'Series and number of the ID card',
        'company'    => 'Company',
        'vat_id'     => 'VAT number',
    );

    /** @var string */
    protected $_switcher = 'gm_lp_type';

    /** @var array */
    protected $_config = array();

    /**
     * @return array
     */
    public function getFieldsLabels()
    {
        return $this->_fieldsLabels;
    }

    /**
     * @param  bool $with_switcher
     * @return array
     */
    public function getFieldsName($with_switcher = true)
    {
        $fields = array_keys($this->getFieldsLabels());

        if (!$with_switcher) {
            $fields = array_diff($fields, array($this->_switcher));
        }

        return $fields;
    }

    /**
     * @return GoMage_LegalPerson_Model_Field[]
     */
    public function getNaturalFields()
    {
        $result = array();
        foreach ($this->getFieldsName(false) as $name) {

            $required = Mage::getStoreConfig('gomage_checkout/natural_person/' . $name) == 'req';
            $optional = Mage::getStoreConfig('gomage_checkout/natural_person/' . $name) == 'opt';

            /** @var GoMage_LegalPerson_Model_Field $field */
            $field = Mage::getModel('gomage_legalperson/field', array(
                    'name'     => $name,
                    'label'    => $this->_fieldsLabels[$name],
                    'required' => $required,
                    'optional' => $optional,
                    'enabled'  => $required || $optional,
                )
            );

            $result[] = $field;
        }

        return $result;
    }

    /**
     * @return GoMage_LegalPerson_Model_Field[]
     */
    public function getLegalFields()
    {
        $result = array();
        foreach ($this->getFieldsName(false) as $name) {

            $required = Mage::getStoreConfig('gomage_checkout/legal_person/' . $name) == 'req';
            $optional = Mage::getStoreConfig('gomage_checkout/legal_person/' . $name) == 'opt';

            /** @var GoMage_LegalPerson_Model_Field $field */
            $field = Mage::getModel('gomage_legalperson/field', array(
                    'name'     => $name,
                    'label'    => $this->_fieldsLabels[$name],
                    'required' => $required,
                    'optional' => $optional,
                    'enabled'  => $required || $optional,
                )
            );

            $result[] = $field;
        }

        return $result;
    }

    /**
     * @return GoMage_LegalPerson_Model_Field
     */
    public function getSwitcherField()
    {
        $enabled = Mage::getStoreConfigFlag('gomage_checkout/person/enabled');
        return Mage::getModel('gomage_legalperson/field', array(
                'name'     => $this->_switcher,
                'label'    => $this->_fieldsLabels[$this->_switcher],
                'required' => $enabled,
                'optional' => false,
                'enabled'  => $enabled,
            )
        );
    }

    /**
     * @param bool $asJson
     * @return array|string
     */
    public function getConfig($asJson = false)
    {
        if (empty($this->_config)) {
            $this->_config['countries'] = preg_split('/\,/',
                Mage::getStoreConfig('gomage_checkout/person/countries'), 0, PREG_SPLIT_NO_EMPTY
            );
            $this->_config['switcher']  = $this->getSwitcherField()->toArray();
            $this->_config['natural']   = array_map(function ($field) {
                return $field->toArray();
            }, $this->getNaturalFields()
            );
            $this->_config['legal']     = array_map(function ($field) {
                return $field->toArray();
            }, $this->getLegalFields()
            );
        }
        if ($asJson) {
            return Mage::helper('core')->jsonEncode($this->_config);
        }
        return $this->_config;
    }

}