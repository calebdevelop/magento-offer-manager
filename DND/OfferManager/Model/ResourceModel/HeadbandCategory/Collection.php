<?php

namespace DND\OfferManager\Model\ResourceModel\HeadbandCategory;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \DND\OfferManager\Model\HeadbandCategory::class,
            \DND\OfferManager\Model\ResourceModel\HeadbandCategory::class
        );
    }
}
