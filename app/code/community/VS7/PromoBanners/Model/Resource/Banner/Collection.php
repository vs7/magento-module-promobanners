<?php

class VS7_PromoBanners_Model_Resource_Banner_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('vs7_promobanners/banner');
    }

    public function addCategoryFilter($categoryId)
    {
        $this->_select->joinLeft(
            array('banner_category' => $this->getTable('vs7_promobanners/banner_category')),
            'main_table.entity_id=banner_category.banner_id',
            array()
        )
        ->where('banner_category.category_id=?', (int)$categoryId);

        return $this;
    }

    public function addActiveRuleFilter()
    {
        $now = Mage::getModel('core/date')->date('Y-m-d');

        $this->_select->joinLeft(
            array('rules' => $this->getTable('salesrule/rule')),
            'main_table.rule_id=rules.rule_id',
            array()
        )
        ->joinLeft(
            array('website' => $this->getTable('salesrule/website')),
            'rules.rule_id=website.rule_id',
            array()
        )
        ->joinLeft(
            array('customer_group' => $this->getTable('salesrule/customer_group')),
            'rules.rule_id=customer_group.rule_id',
            array()
        )
        ->where('rules.from_date is null or rules.from_date <= ?', $now)
        ->where('rules.to_date is null or rules.to_date >= ?', $now)
        ->where('rules.is_active = 1')
        ->where('website.website_id = ?', Mage::app()->getWebsite()->getId())
        ->where('customer_group.customer_group_id = ?', Mage::getSingleton('customer/session')->getCustomerGroupId());

        return $this;
    }
}