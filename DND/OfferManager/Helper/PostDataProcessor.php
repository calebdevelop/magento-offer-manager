<?php

namespace DND\OfferManager\Helper;

use DND\OfferManager\Api\Data\HeadbandInterface;
use DND\OfferManager\Api\HeadbandRepositoryInterface;
use DND\OfferManager\Model\HeadbandFactory;
use DND\OfferManager\Model\ImageUploader;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Stdlib\DateTime\Filter\Date;

class PostDataProcessor
{
    /**
     * @var \Magento\Framework\Stdlib\DateTime\Filter\Date
     */
    protected Date $dateFilter;

    protected ImageUploader $imageUploader;

    protected HeadbandFactory $headbandFactory;

    protected HeadbandRepositoryInterface $repository;

    public function __construct(
        Date $dateFilter,
        ImageUploader $imageUploader,
        HeadbandFactory $headbandFactory,
        HeadbandRepositoryInterface $repository
    )
    {
        $this->dateFilter = $dateFilter;
        $this->imageUploader   = $imageUploader;
        $this->headbandFactory = $headbandFactory;
        $this->repository = $repository;
    }

    public function initialise(RequestInterface $request)
    {
        $postValue = $request->getPostValue();

        if (isset($postValue['entity_id']) && $postValue['entity_id']) {
            $model = $this->repository->getById($postValue['entity_id']);
            unset($postValue['entity_id']);
        } else {
            $model = $this->headbandFactory->create();
        }

        // force to default store : to do
        $model->setData('store_id', 0);
        $data = $this->filterPostData($postValue, $model);
        $model->addData($data);

        return $model;
    }

    private function filterPostData($data, HeadbandInterface $model) : array
    {
        $data = $this->filterDate($data);
        if (isset($data['media'][0]['name']) && $model->getMedia() == $data['media'][0]['name']) {
            unset($data['media']);
        } else {
            $data['media'] = $this->processImage($data);
        }

        unset($data['store_id']);

        return $data;
    }

    private function filterDate(array $data) : array
    {
        $filterRules = [];
        foreach (['show_at', 'show_until'] as $dateField) {
            if (!empty($data[$dateField])) {
                $filterRules[$dateField] = $this->dateFilter;
            }
        }

        return (new \Zend_Filter_Input($filterRules, [], $data))->getUnescaped();
    }

    private function processImage($data)
    {
        $media = $data['media'] ?? null;
        if ($media) {
            if ($this->isTmpFileAvailable($media) && $imageName = $this->getUploadedImageName($media)) {
                try {
                    return $this->imageUploader->moveFileFromTmp($imageName);
                } catch (LocalizedException $e) {
                }
            }
        }
        return null;
    }

    /**
     * @param array $value
     * @return bool
     */
    private function isTmpFileAvailable($value) : bool
    {
        return is_array($value) && isset($value[0]['tmp_name']);
    }

    /**
     * @param $value
     * @return string
     */
    private function getUploadedImageName($value) : string
    {
        if (is_array($value) && isset($value[0]['name'])) {
            return $value[0]['name'];
        }

        return '';
    }
}
