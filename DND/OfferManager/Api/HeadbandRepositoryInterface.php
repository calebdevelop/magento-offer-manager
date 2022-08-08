<?php

namespace DND\OfferManager\Api;

use DND\OfferManager\Api\Data\HeadbandInterface;
use DND\OfferManager\Model\ResourceModel\Headband\Collection;

interface HeadbandRepositoryInterface
{
    /**
     * @param HeadbandInterface $headband
     * @return mixed
     * @throws \LogicException
     * @throws \Exception
     */
    public function save(HeadbandInterface $headband);

    /**
     * @param $id
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($id);

    /**
     * @param $categoryId
     * @return Collection
     */
    public function getCollectionByCategory($categoryId);
}
