<?php

namespace DND\OfferManager\Controller\Adminhtml\Headband;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;

class Index extends Action implements HttpGetActionInterface
{
    private $pageFactory;

    public function __construct(
        Context $context,
        PageFactory $rawFactory
    )
    {
        $this->pageFactory = $rawFactory;

        parent::__construct($context);
    }


    public function execute(): Page
    {
        $resultPage = $this->pageFactory->create();
        //$resultPage->setActiveMenu('Magento_Catalog::catalog_products');
        $resultPage->getConfig()->getTitle()->prepend(__('Admin Offer Manager'));

        return $resultPage;
    }
}
