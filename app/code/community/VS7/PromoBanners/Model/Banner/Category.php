<?php

class VS7_PromoBanners_Model_Banner_Category extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('vs7_promobanners/banner_category');
    }
}