<?php

class VS7_PromoBanners_Model_Resource_Banner_Category_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('vs7_promobanners/banner_category');
    }
}