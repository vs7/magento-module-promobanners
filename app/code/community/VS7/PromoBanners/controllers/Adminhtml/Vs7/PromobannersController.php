<?php

class VS7_PromoBanners_Adminhtml_Vs7_PromobannersController extends Mage_Adminhtml_Controller_Action
{
    public function chooserCategoriesAction()
    {
        $request = $this->getRequest();
        $ids = $request->getParam('selected', array());
        $check = $request->getParam('check');
        if ($check == 1) {
            $ids = Mage::getResourceModel('catalog/category_collection')->getAllIds();
        } elseif ($check == 2) {
            $ids = array();
        } else {
            if (is_array($ids)) {
                foreach ($ids as $key => &$id) {
                    $id = (int)$id;
                    if ($id <= 0) {
                        unset($ids[$key]);
                    }
                }

                $ids = array_unique($ids);
            } else {
                $ids = array();
            }
        }

        $block = $this->getLayout()
            ->createBlock(
                'vs7_promobanners/adminhtml_catalog_category_tree',
                'categories',
                array('js_form_object' => $request->getParam('form'))
            )
            ->setCategoryIds($ids);
        if ($block) {
            $this->getResponse()->setBody($block->toHtml());
        }
    }

    public function categoriesJsonAction()
    {
        if ($categoryId = (int)$this->getRequest()->getPost('id')) {
            $this->getRequest()->setParam('id', $categoryId);

            if (!$category = $this->_initCategory()) {
                return;
            }
            $this->getResponse()->setBody(
                $this->getLayout()->createBlock('adminhtml/catalog_category_tree')
                    ->getTreeJson($category)
            );
        }
    }

    protected function _initCategory()
    {
        $categoryId = (int)$this->getRequest()->getParam('id', false);
        $storeId = (int)$this->getRequest()->getParam('store');

        $category = Mage::getModel('catalog/category');
        $category->setStoreId($storeId);

        if ($categoryId) {
            $category->load($categoryId);
            if ($storeId) {
                $rootId = Mage::app()->getStore($storeId)->getRootCategoryId();
                if (!in_array($rootId, $category->getPathIds())) {
                    $this->_redirect('*/*/', array('_current' => true, 'id' => null));
                    return false;
                }
            }
        }

        Mage::register('category', $category);
        Mage::register('current_category', $category);

        return $category;
    }
}