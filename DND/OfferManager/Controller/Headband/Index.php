<?php

namespace DND\OfferManager\Controller\Headband;

use DND\OfferManager\Api\HeadbandRepositoryInterface;
use DND\OfferManager\Model\Headband;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

class Index implements HttpGetActionInterface
{
    CONST IMG_BASE_PATH = 'dnd/headband';

    private JsonFactory $resultJsonFactory;

    private RequestInterface $request;

    private HeadbandRepositoryInterface $repository;

    private StoreManagerInterface $storeManager;

    public function __construct(
        RequestInterface $request,
        JsonFactory $jsonFactory,
        HeadbandRepositoryInterface $repository,
        StoreManagerInterface $storeManager
    )
    {
        $this->request = $request;
        $this->resultJsonFactory = $jsonFactory;
        $this->repository = $repository;
        $this->storeManager = $storeManager;
    }

    public function execute()
    {
        $catId = $this->request->getParam('category');
        $result = $this->resultJsonFactory->create();
        $result->setHeader('Content-Type', 'application/json');
        if (!$catId) {
            $result->setData([]);
        } else {
            $collection = $this->repository->getCollectionByCategory($catId);
            $data = [];
            /** @var Headband $item */
            foreach ($collection as $item) {
                $data[] = array_merge($item->getData(), [
                    'media' => $this->getImageUrl($item->getMedia())
                ]);
            }
            $result->setData($data);
        }
        return $result;
    }

    private function getImageUrl($imgPath)
    {
        return rtrim(
            $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA),
            '/'
        ) . '/' . self::IMG_BASE_PATH . '/' . ltrim($imgPath, '/');
    }
}
