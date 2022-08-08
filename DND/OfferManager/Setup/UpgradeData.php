<?php

namespace DND\OfferManager\Setup;

use DND\OfferManager\Model\HeadbandFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

class UpgradeData implements UpgradeDataInterface
{
    private HeadbandFactory $headbandFactory;

    public function __construct(HeadbandFactory $headbandFactory)
    {
        $this->headbandFactory = $headbandFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $headband = $this->headbandFactory->create();
        $headband->setViewAt(new \DateTime());
        $headband->setData('description', 'test');
        $headband->save();
        $setup->endSetup();
    }
}
