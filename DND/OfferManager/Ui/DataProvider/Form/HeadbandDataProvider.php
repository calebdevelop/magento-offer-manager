<?php

namespace DND\OfferManager\Ui\DataProvider\Form;

use DND\OfferManager\Api\HeadbandRepositoryInterface;
use DND\OfferManager\Model\HeadbandFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use DND\OfferManager\Model\ResourceModel\Headband\CollectionFactory;

class HeadbandDataProvider extends AbstractDataProvider
{
    CONST MEDIA_PATH_STORAGE = 'dnd/headband';

    /**
     * @var array
     */
    protected array $loadedData;

    protected HeadbandRepositoryInterface $repository;

    protected RequestInterface $request;

    protected HeadbandFactory $modelFactory;

    protected StoreManagerInterface $storeManager;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        HeadbandRepositoryInterface $repository,
        StoreManagerInterface $storeManager,
        HeadbandFactory $modelFactory = null,
        ?RequestInterface $request = null,
        array $meta = [],
        array $data = []
    )
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->repository = $repository;
        $this->storeManager =$storeManager;
        $this->request = $request ?? ObjectManager::getInstance()->get(RequestInterface::class);
        $this->modelFactory = $modelFactory ?: ObjectManager::getInstance()->get(HeadbandFactory::class);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $model = $this->getCurrentHeadband();
        $this->loadedData[$model->getId()] = $model->getData();

        if ($model->getMedia()) {
            $this->loadedData[$model->getId()]['media'] = [];
            $this->loadedData[$model->getId()]['media'][0] = [
                'name' => $model->getMedia(),
                'url'  => $this->getImageUrl($model->getMedia())
            ];
        }

        return $this->loadedData;
    }

    private function getCurrentHeadband()
    {
        $entityId = $this->getEntityId();
        if ($entityId) {
            try {
                $model = $this->repository->getById($entityId);
            } catch (LocalizedException $e) {
                $model = $this->modelFactory->create();
            }

            return $model;
        }

        return  $this->modelFactory->create();
    }

    private function getEntityId()
    {
        return $this->request->getParam($this->getRequestFieldName());
    }

    /**
     * @return string
     */
    public function getRequestFieldName()
    {
        return $this->requestFieldName;
    }

    public function getImageUrl($relativePath)
    {
        return $this->storeManager->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) .
            self::MEDIA_PATH_STORAGE  . '/' . ltrim($relativePath, '/');
    }
}
