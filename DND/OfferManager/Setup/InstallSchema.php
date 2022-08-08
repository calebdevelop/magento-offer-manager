<?php

namespace DND\OfferManager\Setup;

use DND\OfferManager\Setup\Resource\HeadbandAttributeResource;
use DND\OfferManager\Setup\Resource\HeadbandResource;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    private HeadbandResource $headbandResource;

    private HeadbandAttributeResource $attributeResource;

    public function __construct(
        HeadbandResource $headbandResource,
        HeadbandAttributeResource $attributeResource
    )
    {
        $this->headbandResource = $headbandResource;
        $this->attributeResource = $attributeResource;
    }

    /**
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $tableName = $setup->getTable('headband_entity');
        if (!$setup->getConnection()->isTableExists($tableName)) {
            $this->headbandResource->install($setup);
            $this->attributeResource->install($setup);
        }
        $setup->endSetup();
    }
}
