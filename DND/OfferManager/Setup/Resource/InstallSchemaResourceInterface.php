<?php

namespace DND\OfferManager\Setup\Resource;

use Magento\Framework\Setup\SchemaSetupInterface;

interface InstallSchemaResourceInterface
{
    public function install(SchemaSetupInterface $setup);
}
