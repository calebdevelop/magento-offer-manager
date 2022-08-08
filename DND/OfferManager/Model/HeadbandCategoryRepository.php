<?php

namespace DND\OfferManager\Model;

use DND\OfferManager\Api\Data\HeadbandCategoryInterface;
use DND\OfferManager\Api\HeadbandCategoryRepositoryInterface;
use DND\OfferManager\Model\ResourceModel\HeadbandCategory as ResourceModel;
use Magento\Framework\Exception\AlreadyExistsException;

class HeadbandCategoryRepository implements HeadbandCategoryRepositoryInterface
{
    protected ResourceModel $resource;

    public function __construct(
        ResourceModel $resource
    )
    {
        $this->resource = $resource;
    }

    public function save(HeadbandCategoryInterface $model)
    {
        try {
            $this->resource->save($model);
        } catch (AlreadyExistsException $e) {
        } catch (\Exception $e) {
        }
    }

    public function delete(HeadbandCategoryInterface $model)
    {
        try {
            $this->resource->delete($model);
        } catch (\Exception $e) {
        }
    }

    public function deleteRelation($entityId, $categoryIds)
    {
        $connexion = $this->resource->getConnection();
        $tableName = $this->resource->getTable('headband_category');
        $ids = is_array($categoryIds) ? $categoryIds : [$categoryIds];
        $where[] = $connexion->quoteInto('headband_id = ?', $entityId);
        $where[] = $connexion->quoteInto('category_id IN(?)', $ids);
        $connexion->delete($tableName, $where);
    }
}
