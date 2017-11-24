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
     * @return bool
     */
    public function isAdmin()
    {
        if (Mage::app()->getStore()->isAdmin()) {
            return true;
        }
        if (Mage::getDesign()->getArea() == 'adminhtml') {
            return true;
        }
        return false;
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
            $this->_config['is_admin']  = $this->isAdmin();
        }
        if ($asJson) {
            return Mage::helper('core')->jsonEncode($this->_config);
        }
        return $this->_config;
    }

    public function getAllStoreDomains()
    {
        $domains = array();

        foreach (Mage::app()->getWebsites() as $website) {
            $url = $website->getConfig('web/unsecure/base_url');
            if ($domain = trim(preg_replace('/^.*?\\/\\/(.*)?\\//', '$1', $url))) {
                $domains[] = $domain;
            }

            $url = $website->getConfig('web/secure/base_url');

            if ($domain = trim(preg_replace('/^.*?\\/\\/(.*)?\\//', '$1', $url))) {
                $domains[] = $domain;
            }
        }
        return array_unique($domains);
    }

    public function getAvailableWebsites()
    {
        return $this->_w();
    }

    protected function _w()
    {
        if (!Mage::getStoreConfig('gomage_activation/legalperson/installed') ||
            (intval(Mage::getStoreConfig('gomage_activation/legalperson/count')) > 10)
        ) {
            return array();
        }

        $time_to_update = 60 * 60 * 24 * 15;

        $r = Mage::getStoreConfig('gomage_activation/legalperson/ar');
        $t = Mage::getStoreConfig('gomage_activation/legalperson/time');
        $s = Mage::getStoreConfig('gomage_activation/legalperson/websites');

        $last_check = str_replace($r, '', Mage::helper('core')->decrypt($t));

        $allsites = explode(',', str_replace($r, '', Mage::helper('core')->decrypt($s)));
        $allsites = array_diff($allsites, array(""));

        if (($last_check + $time_to_update) < time()) {
            $this->a(Mage::getStoreConfig('gomage_activation/legalperson/key'),
                intval(Mage::getStoreConfig('gomage_activation/legalperson/count')),
                implode(',', $allsites)
            );
        }

        return $allsites;
    }

    public function a($k, $c = 0, $s = '')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, sprintf('https://www.gomage.com/index.php/gomage_downloadable/key/check'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'key=' . urlencode($k) . '&sku=legal-person&domains=' . urlencode(implode(',', $this->getAllStoreDomains())) . '&ver=' . urlencode('1.0.0'));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        $content = curl_exec($ch);

        try {
            $r = Zend_Json::decode($content);
        } catch (\Exception $e) {
            $r = array();
        }

        $e = Mage::helper('core');
        if (empty($r)) {

            $value1 = Mage::getStoreConfig('gomage_activation/legalperson/ar');

            $groups = array(
                'legalperson' => array(
                    'fields' => array(
                        'ar'       => array(
                            'value' => $value1
                        ),
                        'websites' => array(
                            'value' => (string)Mage::getStoreConfig('gomage_activation/legalperson/websites')
                        ),
                        'time'     => array(
                            'value' => (string)$e->encrypt($value1 . (time() - (60 * 60 * 24 * 15 - 1800)) . $value1)
                        ),
                        'count'    => array(
                            'value' => $c + 1)
                    )
                )
            );

            Mage::getModel('adminhtml/config_data')
                ->setSection('gomage_activation')
                ->setGroups($groups)
                ->save();

            Mage::getConfig()->reinit();
            Mage::app()->reinitStores();

            return;
        }

        $value1 = '';
        $value2 = '';

        if (isset($r['d']) && isset($r['c'])) {
            $value1 = $e->encrypt(base64_encode(Zend_Json::encode($r)));

            if (!$s) {
                $s = Mage::getStoreConfig('gomage_activation/legalperson/websites');
            }

            $s      = array_slice(explode(',', $s), 0, $r['c']);
            $value2 = $e->encrypt($value1 . implode(',', $s) . $value1);
        }
        $groups = array(
            'legalperson' => array(
                'fields' => array(
                    'ar'        => array(
                        'value' => $value1
                    ),
                    'websites'  => array(
                        'value' => (string)$value2
                    ),
                    'time'      => array(
                        'value' => (string)$e->encrypt($value1 . time() . $value1)
                    ),
                    'installed' => array(
                        'value' => 1
                    ),
                    'count'     => array(
                        'value' => 0)

                )
            )
        );

        Mage::getModel('adminhtml/config_data')
            ->setSection('gomage_activation')
            ->setGroups($groups)
            ->save();

        Mage::getConfig()->reinit();
        Mage::app()->reinitStores();

    }

    public function ga()
    {
        $ar = base64_decode(Mage::helper('core')->decrypt(Mage::getStoreConfig('gomage_activation/legalperson/ar')));
        return $ar ? Zend_Json::decode($ar) : array();
    }

}