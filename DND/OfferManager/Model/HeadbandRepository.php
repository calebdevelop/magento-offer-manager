<?php

namespace DND\OfferManager\Model;

use DND\OfferManager\Api\Data\HeadbandInterface;
use DND\OfferManager\Api\HeadbandRepositoryInterface;
use DND\OfferManager\Model\ResourceModel\Headband as ResourceModel;

class HeadbandRepository implements HeadbandRepositoryInterface
{
    private ResourceModel $resource;

    private HeadbandFactory $modelFactory;

    private ResourceModel\CollectionFactory $collectionFactory;

    public function __construct(
        ResourceModel $resource,
        HeadbandFactory $modelFactory,
        ResourceModel\CollectionFactory $collectionFactory
    )
    {
        $this->resource = $resource;
        $this->modelFactory = $modelFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @throws \LogicException
     * @throws \Exception
     */
    public function save(HeadbandInterface $headband)
    {
        $this->resource->save($headband);
    }

    public function getById($id)
    {
        $model = $this->modelFactory->create();
        $model->load($id);
        return $model;
    }

    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCollectionByCategory($categoryId): ResourceModel\Collection
    {
        $collection = $this->collectionFactory->create();
        $collection->addAttributeToSelect('*');
        $where = $collection->getConnection()->quoteInto('ca.category_id = ?', (int)$categoryId);
        $collection->getSelect()->joinInner(
            ['ca' => $collection->getResource()->getTable('headband_category')],
            'e.entity_id = ca.headband_id',
            null
        )->where($where);

        return $collection;
    }
}
