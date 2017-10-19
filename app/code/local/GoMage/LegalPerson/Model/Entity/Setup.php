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
class GoMage_LegalPerson_Model_Entity_Setup extends Mage_Customer_Model_Entity_Setup
{

    protected $_regions = array(
        array('AL', 'Alba', 'Alba'),
        array('AR', 'Arad', 'Arad'),
        array('AG', 'Argeş', 'Arges'),
        array('BC', 'Bacău', 'Bacau'),
        array('BH', 'Bihor', 'Bihor'),
        array('BN', 'Bistrita-Nasaud', 'Bistrita-Nasaud'),
        array('BT', 'Botoşani', 'Botosani'),
        array('BR', 'Brăila', 'Braila'),
        array('BV', 'Braşov', 'Brasov'),
        array('B1', 'Bucureşti Sector 1', 'Bucharest Sector 1'),
        array('B2', 'Bucureşti Sector 2', 'Bucharest Sector 2'),
        array('B3', 'Bucureşti Sector 3', 'Bucharest Sector 3'),
        array('B4', 'Bucureşti Sector 4', 'Bucharest Sector 4'),
        array('B5', 'Bucureşti Sector 5', 'Bucharest Sector 5'),
        array('B6', 'Bucureşti Sector 6', 'Bucharest Sector 6'),
        array('IF', 'Bucureşti SAI', 'Ilfov'),
        array('BZ', 'Buzău', 'Buzau'),
        array('CS', 'Caraş Severin', 'Caras Severin'),
        array('CL', 'Călăraşi', 'Calarasi'),
        array('CJ', 'Cluj', 'Cluj'),
        array('CT', 'Constanţa', 'Constanta'),
        array('CV', 'Covasna', 'Covasna'),
        array('DB', 'Dâmboviţa', 'Dambovita'),
        array('DJ', 'Dolj', 'Dolj'),
        array('GL', 'Galaţi', 'Galati'),
        array('GR', 'Giurgiu', 'Giurgiu'),
        array('GJ', 'Gorj', 'Gorj'),
        array('HR', 'Harghita', 'Harghita'),
        array('HD', 'Hunedoara', 'Hunedoara'),
        array('IL', 'Ialomiţa', 'Ialomita'),
        array('IS', 'Iaşi', 'Iasi'),
        array('MM', 'Maramureş', 'Maramures'),
        array('MH', 'Mehedinţi', 'Mehedinti'),
        array('MS', 'Mureş', 'Mures'),
        array('NT', 'Neamţ', 'Neamt'),
        array('OT', 'Olt', 'Olt'),
        array('PH', 'Prahova', 'Prahova'),
        array('SM', 'Satu Mare', 'Satu Mare'),
        array('SJ', 'Sălăj', 'Salaj'),
        array('SB', 'Sibiu', 'Sibiu'),
        array('SV', 'Suceava', 'Suceava'),
        array('TR', 'Teleorman', 'Teleorman'),
        array('TM', 'Timiş', 'Timis'),
        array('TL', 'Tulcea', 'Tulcea'),
        array('VS', 'Vaslui', 'Vaslui'),
        array('VL', 'Vâlcea', 'Valcea'),
        array('VR', 'Vrancea', 'Vrancea'),
    );

    /**
     * @return array
     */
    public function getRegions()
    {
        return $this->_regions;
    }

}