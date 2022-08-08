<?php

namespace DND\OfferManager\Setup\Resource;

use DND\OfferManager\Model\Headband;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\SchemaSetupInterface;

class HeadbandResource implements InstallSchemaResourceInterface
{
    /**
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup)
    {
        $table = $setup->getConnection()
            ->newTable(Headband::ENTITY . '_entity')
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ]
            )
            ->addColumn(
                'is_active',
                Table::TYPE_BOOLEAN,
                null,
                ['nullable' => false, 'default' => 1],
                'Title'
            )
            ->addColumn(
                'title',
                Table::TYPE_TEXT,
                100,
                ['nullable' => false],
                'Title'
            )
            ->addColumn(
                'show_at',
                Table::TYPE_DATETIME,
                null,
                ['nullable' => false],
                'Show At'
            )
            ->addColumn(
                'show_until',
                Table::TYPE_DATETIME,
                null,
                ['nullable' => false],
                'Show Until'
            )
            ->setComment('DND Headband Table')
            ->setOption('type', 'InnoDB')
            ->setOption('charset', 'utf8');
        $setup->getConnection()->createTable($table);

        $table = $setup->getConnection()
            ->newTable( 'headband_category')
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ]
            )
            ->addColumn(
                'headband_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned'=> true, 'nullable'=> false, 'default'=> '0'],
                'Headband ID'
            )
            ->addColumn(
                'category_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned'=> true, 'nullable'=> false, 'default'=> '0'],
                'Category ID'
            )
            ->addIndex(
                $setup->getIdxName('headband_category',
                    ['headband_id', 'category_id'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['headband_id', 'category_id'],
                ['type'=>\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
            )
            ->addIndex(
                $setup->getIdxName('headband_category', ['headband_id']),
                ['headband_id']
            )
            ->addIndex(
                $setup->getIdxName('headband_category', ['category_id']),
                ['category_id']
            )
            ->addForeignKey(
                $setup->getFkName(
                    'headband_category',
                    'entity_id',
                    'headband_entity',
                    'headband_id'
                ),
                'headband_id',
                $setup->getTable(Headband::ENTITY . '_entity'),
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $setup->getFkName(
                    'catalog_category_entity',
                    'entity_id',
                    'headband_category',
                    'category_id'
                ),
                'category_id',
                $setup->getTable('catalog_category_entity'),
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
            ->setComment('DND Headband Categories')
            ->setOption('type', 'InnoDB')
            ->setOption('charset', 'utf8');
        $setup->getConnection()->createTable($table);

    }
}
