<?php

namespace DND\OfferManager\Model\HeadbandCategory;

use DND\OfferManager\Api\Data\HeadbandInterface;
use DND\OfferManager\Api\HeadbandCategoryRepositoryInterface;
use DND\OfferManager\Model\Headband;
use DND\OfferManager\Model\HeadbandCategoryFactory;

class SaveHandler
{
    private HeadbandCategoryRepositoryInterface $repository;

    private $modelFactory;

    public function __construct(
        HeadbandCategoryRepositoryInterface $repository,
        HeadbandCategoryFactory $modelFactory
    )
    {
        $this->repository = $repository;
        $this->modelFactory = $modelFactory;
    }

    /**
     * @param Headband|HeadbandInterface $headband
     * @return void
     */
    public function execute(HeadbandInterface $headband)
    {
        $bdIds = $headband->getCategoryIdsInDb();
        $idsRemove = array_diff($bdIds, $headband->getCategoryIds());
        if (!empty($idsRemove)) {
            $this->repository->deleteRelation($headband->getId(), $idsRemove);
        }
        foreach ($headband->getCategoryIds() as $categoryId)
        {
            if (!in_array($categoryId, $bdIds)) {
                $model = $this->modelFactory->create();
                $model->addData([
                    'headband_id' => $headband->getId(),
                    'category_id' => $categoryId
                ]);
                $this->repository->save($model);
            }
        }
    }
}
