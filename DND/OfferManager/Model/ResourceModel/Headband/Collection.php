<?php

namespace DND\OfferManager\Model\ResourceModel\Headband;

use Magento\Eav\Model\Entity\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(\DND\OfferManager\Model\Headband::class, \DND\OfferManager\Model\ResourceModel\Headband::class);
    }
}
