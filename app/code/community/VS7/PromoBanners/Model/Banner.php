<?php

class VS7_PromoBanners_Model_Banner extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('vs7_promobanners/banner');
    }

    protected function _beforeSave()
    {
        parent::_beforeSave();
        $now = Mage::getSingleton('core/date')->gmtDate();
        if ($this->isObjectNew()) {
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);
        return $this;
    }
}