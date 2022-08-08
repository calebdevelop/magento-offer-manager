<?php

namespace DND\OfferManager\Setup;

use DND\OfferManager\Model\Headband;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    private HeadbandSetupFactory $headbandSetupFactory;

    public function __construct(HeadbandSetupFactory $headbandSetupFactory)
    {
        $this->headbandSetupFactory = $headbandSetupFactory;
    }

    /**
     * @throws \Zend_Validate_Exception
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        /** @var HeadbandSetup $headbandSetup */
        $headbandSetup = $this->headbandSetupFactory->create(['setup' => $setup]);
        $headbandSetup->installEntities();

        $headbandSetup->addAttribute(
            Headband::ENTITY, 'description', ['type' => 'varchar']
        );

        $headbandSetup->addAttribute(
            Headband::ENTITY, 'link', ['type' => 'varchar']
        );

        $headbandSetup->addAttribute(
            Headband::ENTITY, 'media', ['type' => 'varchar']
        );

        $setup->endSetup();
    }
}
