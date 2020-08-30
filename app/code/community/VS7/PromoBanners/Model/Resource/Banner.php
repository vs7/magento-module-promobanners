<?php

class VS7_PromoBanners_Model_Resource_Banner extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        $this->_init('vs7_promobanners/banner', 'entity_id');
    }
}