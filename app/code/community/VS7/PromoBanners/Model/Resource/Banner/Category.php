<?php

class VS7_PromoBanners_Model_Resource_Banner_Category extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function  _construct()
    {
        $this->_init('vs7_promobanners/banner_category', 'rel_id');
    }

    public function saveBannerRelation($banner, $data)
    {
        $deleteCondition = $this->_getWriteAdapter()->quoteInto('banner_id=?', $banner->getId());
        $this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);

        foreach ($data as $categoryId) {
            if (empty($categoryId)) continue;
            $this->_getWriteAdapter()->insert(
                $this->getMainTable(),
                array(
                    'banner_id' => $banner->getId(),
                    'category_id' => $categoryId
                )
            );
        }
        return $this;
    }
}