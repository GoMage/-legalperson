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
class GoMage_LegalPerson_Model_Field extends Varien_Object
{

    /** @var  string */
    protected $_name;

    /** @var  string */
    protected $_label;

    /** @var  bool */
    protected $_required;

    /** @var  bool */
    protected $_optional;

    /** @var  bool */
    protected $_enabled;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->_label;
    }

    /**
     * @return bool
     */
    public function isRequired()
    {
        return $this->_required;
    }

    /**
     * @return bool
     */
    public function isOptional()
    {
        return $this->_optional;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->_enabled;
    }

}