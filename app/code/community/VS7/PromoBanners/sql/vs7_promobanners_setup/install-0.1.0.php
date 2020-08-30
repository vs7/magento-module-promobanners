<?php
$this->startSetup();

$this->getConnection()->dropTable($this->getTable('vs7_promobanners/banner'));
$table = $this->getConnection()
    ->newTable($this->getTable('vs7_promobanners/banner'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Banner ID')
    ->addColumn('rule_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
    ), 'Rule ID')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
    ), 'Name')
    ->addColumn('url_key', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(),
        'URL Key'
    )
    ->addColumn('text', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(),
        'Text'
    )
    ->addColumn('image', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(),
        'Image'
    )
    ->addColumn('position', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array('nullable'  => false, 'default'   => '0',),
        'Position'
    )
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(),
        'Banner Modification Time'
    )
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(),
        'Banner Creation Time'
    )
    ->addForeignKey(
        $this->getFkName(
            'vs7_promobanners/banner',
            'rule_id',
            'salesrule/rule',
            'rule_id'
        ),
        'rule_id',
        $this->getTable('salesrule/rule'),
        'rule_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->setComment('Banner Table');

$this->getConnection()->createTable($table);

$this->getConnection()->dropTable($this->getTable('vs7_promobanners/banner_category'));
$table = $this->getConnection()
    ->newTable($this->getTable('vs7_promobanners/banner_category'))
    ->addColumn(
        'rel_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'unsigned'  => true,
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ),
        'Relation ID'
    )
    ->addColumn(
        'banner_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => '0',
        ),
        'Banner ID'
    )
    ->addColumn(
        'category_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => '0',
        ),
        'Category ID'
    )
    ->addIndex(
        $this->getIdxName(
            'vs7_promobanners/banner_category',
            array('category_id')
        ),
        array('category_id')
    )
    ->addForeignKey(
        $this->getFkName(
            'vs7_promobanners/banner_category',
            'banner_id',
            'vs7_promobanners/banner',
            'entity_id'
        ),
        'banner_id',
        $this->getTable('vs7_promobanners/banner'),
        'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->addForeignKey(
        $this->getFkName(
            'vs7_promobanners/banner_category',
            'category_id',
            'catalog/category',
            'entity_id'
        ),
        'category_id',
        $this->getTable('catalog/category'),
        'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->addIndex(
        $this->getIdxName(
            'vs7_promobanners/banner_category',
            array('banner_id', 'category_id'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array('banner_id', 'category_id'),
        array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE)
    )
    ->setComment('Banner to Category Relation Table');
$this->getConnection()->createTable($table);

$this->endSetup();
