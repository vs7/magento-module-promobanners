<?php

class VS7_PromoBanners_Block_Adminhtml_Promo_Quote_Edit_Tab_Categoriesbanner
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    public function getTabLabel()
    {
        return Mage::helper('vs7_promobanners')->__('Categories Banner');
    }

    public function getTabTitle()
    {
        return Mage::helper('vs7_promobanners')->__('Categories Banner');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }

    protected function _prepareForm()
    {
        $rule = Mage::registry('current_promo_quote_rule');
        $model = Mage::getModel('vs7_promobanners/banner')->load($rule->getId(), 'rule_id');

        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('vs7_promobanners_');
        $form->setFieldNameSuffix('vs7_promobanners');
        $this->setForm($form);

        $fieldset = $form->addFieldset('fieldset',
            array('legend' => Mage::helper('vs7_promobanners')->__('Categories Banner'))
        );

        $fieldset->addField('categories_ids', 'text', array(
            'label' => Mage::helper('vs7_promobanners')->__('Categories IDs'),
            'name' => 'categories_ids',
            'after_element_html' => '<a id="category_link" href="javascript:void(0)" onclick="toggleCategories()"><img src="' . $this->getSkinUrl('images/rule_chooser_trigger.gif') . '" alt="" class="v-middle rule-chooser-trigger" title="Select Categories"></a>
                <div id="vs7_promobanners_categories_check" style="display:none">
                    <a href="javascript:toggleCategories(1)">Check All</a> / <a href="javascript:toggleCategories(2)">Uncheck All</a>
                </div>
                <div id="vs7_promobanners_categories_select" style="display:none"></div>
                    <script type="text/javascript">
                    function toggleCategories(check){
                        if($("vs7_promobanners_categories_select").style.display == "none" || (check ==1) || (check == 2)){
                            $("vs7_promobanners_categories_check").style.display ="";
                            var url = "' . $this->getUrl('adminhtml/vs7_promobanners/chooserCategories') . '";
                            if(check == 1){
                                $("vs7_promobanners_categories_ids").value = $("category_all_ids").value;
                            }else if(check == 2){
                                $("vs7_promobanners_categories_ids").value = "";
                            }
                            var params = $("vs7_promobanners_categories_ids").value.split(", ");
                            var parameters = {"form_key": FORM_KEY,"selected[]":params };
                            var request = new Ajax.Request(url,
                                {
                                    evalScripts: true,
                                    parameters: parameters,
                                    onComplete:function(transport){
                                        $("vs7_promobanners_categories_check").update(transport.responseText);
                                        $("vs7_promobanners_categories_check").style.display = "block";
                                    }
                                }
                            );
                        } else {
                              $("vs7_promobanners_categories_select").style.display = "none";
                              $("vs7_promobanners_categories_check").style.display ="none";
                        }
                    };
		            </script>
            '
        ));

        $fieldset->addField('name', 'text', array(
            'name' => 'name',
            'label' => Mage::helper('vs7_promobanners')->__('Banner Name'),
            'title' => Mage::helper('vs7_promobanners')->__('Banner Name'),
            'required' => false,
        ));

        $fieldset->addField('url_key', 'text', array(
            'name' => 'url_key',
            'label' => Mage::helper('vs7_promobanners')->__('Banner URL'),
            'title' => Mage::helper('vs7_promobanners')->__('Banner URL'),
            'required' => false,
        ));

        $fieldset->addField('text', 'textarea', array(
            'name' => 'text',
            'label' => Mage::helper('vs7_promobanners')->__('Banner Description'),
            'title' => Mage::helper('vs7_promobanners')->__('Banner Description'),
            'style' => 'height: 100px;',
        ));

        $fieldset->addField('image', 'image', array(
            'label' => Mage::helper('vs7_promobanners')->__('Banner Image'),
            'required' => false,
            'name' => 'vs7_promobanners_image',
        ));

        $fieldset->addField('position', 'text', array(
            'name' => 'position',
            'label' => Mage::helper('vs7_promobanners')->__('Banner Position'),
            'title' => Mage::helper('vs7_promobanners')->__('Banner Position'),
        ));

        $form->setValues(
            array(
                'name' => $model->getName(),
                'url_key' => $model->getUrlKey(),
                'text' => $model->getText(),
                'position' => $model->getPosition(),
            )
        );

        if ($model->getImage() != null) {
            $form->getElement('image')->setValue(Mage::helper('vs7_promobanners')->getImageMediaPath($model->getImage()));
        }

        if ($model->getId() != null) {
            $categories = Mage::getModel('vs7_promobanners/banner_category')->getCollection()
                ->addFieldToFilter('banner_id', array('eq' => $model->getId()));
            $categoriesIds = $categories->getColumnValues('category_id');
            $form->getElement('categories_ids')->setValue(implode(', ', $categoriesIds));
        }

        $this->setForm($form);

        return parent::_prepareForm();
    }
}