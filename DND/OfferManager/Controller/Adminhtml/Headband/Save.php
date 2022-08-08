<?php

namespace DND\OfferManager\Controller\Adminhtml\Headband;

use DND\OfferManager\Api\HeadbandRepositoryInterface;
use DND\OfferManager\Helper\PostDataProcessor;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;

class Save extends Action implements HttpPostActionInterface
{
    private HeadbandRepositoryInterface $repository;

    private PostDataProcessor $dataProcessor;

    public function __construct(
        Context $context,
        HeadbandRepositoryInterface $repository,
        PostDataProcessor $dataProcessor
    )
    {
        parent::__construct($context);
        $this->repository = $repository;
        $this->dataProcessor = $dataProcessor;
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $model = $this->dataProcessor->initialise($this->getRequest());
        try {
            $this->repository->save($model);
            $this->messageManager->addSuccessMessage(__('You saved the Offer.'));
            $resultRedirect->setPath('offer/*/edit', ['id' => $model->getId()]);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            if ($model->getId()) {
                $resultRedirect->setPath('offer/*/edit', ['id' => $model->getId()]);
            } else {
                $resultRedirect->setPath('offer/*/edit');
            }
        }

        return $resultRedirect;
    }
}
