<?php

namespace DND\OfferManager\Setup\Resource;

use DND\OfferManager\Model\Headband;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;

class HeadbandAttributeResource implements InstallSchemaResourceInterface
{
    /**
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup)
    {
        $this->createAttributeTable($setup, 'varchar', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255);
        $this->createAttributeTable($setup, 'media', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 60);
    }

    /**
     * @throws \Zend_Db_Exception
     */
    private function createAttributeTable(SchemaSetupInterface $setup, $tableSuffix, $attributeType, $size)
    {
        $table = $setup->getConnection()
            ->newTable($setup->getTable(Headband::ENTITY . '_entity_' . $tableSuffix))
            ->addColumn(
                'value_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity'=> true, 'nullable'=> false, 'primary'=> true],
                'Value ID'
            )
            ->addColumn(
                'attribute_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['unsigned'=> true, 'nullable'=> false, 'default'=> '0'],
                'Attribute Id'
            )
            ->addColumn(
                'store_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['unsigned'=> true, 'nullable'=> false, 'default'=> '0'],
                'Store ID'
            )
            ->addColumn(
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable'=> false, 'default'=> '0'],
                'Entity Id'
            )
            ->addColumn(
                'value',
                $attributeType,
                $size,
                [],
                'value'
            )
            ->addIndex(
                $setup->getIdxName(Headband::ENTITY . '_entity_' . $tableSuffix,
                    ['entity_id', 'attribute_id', 'store_id'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['entity_id', 'attribute_id', 'store_id'],
                ['type'=>\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
            )
            ->addIndex(
                $setup->getIdxName(Headband::ENTITY . '_entity_' . $tableSuffix, ['store_id']),
                ['store_id']
            )
            ->addIndex(
                $setup->getIdxName(Headband::ENTITY . '_entity_' . $tableSuffix, ['attribute_id']),
                ['attribute_id']
            )
            ->addForeignKey(
                $setup->getFkName(
                    Headband::ENTITY . '_entity_' . $tableSuffix,
                    'attribute_id',
                    'eav_attribute',
                    'attribute_id'
                ),
                'attribute_id',
                $setup->getTable('eav_attribute'),
                'attribute_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $setup->getFkName(
                    Headband::ENTITY . '_entity_' . $tableSuffix,
                    'entity_id',
                    Headband::ENTITY . '_entity',
                    'entity_id'
                ),
                'entity_id',
                $setup->getTable(Headband::ENTITY . '_entity'),
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $setup->getFkName(
                    Headband::ENTITY . '_entity_' . $tableSuffix, 'store_id', 'store', 'store_id'
                ),
                'store_id',
                $setup->getTable('store'),
                'store_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
            ->setComment(Headband::ENTITY . ' ' . $attributeType . ' Attribute Backend Table');
        $setup->getConnection()->createTable($table);
    }
}
