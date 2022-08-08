<?php

namespace DND\OfferManager\Api;

use DND\OfferManager\Api\Data\HeadbandCategoryInterface;

interface HeadbandCategoryRepositoryInterface
{
    public function save(HeadbandCategoryInterface $headband);

    public function deleteRelation($entityId, $categoryId);
}
