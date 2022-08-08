<?php

namespace DND\OfferManager\Controller\Adminhtml\Headband;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\ObjectManager\ObjectManager;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Action implements HttpGetActionInterface
{
    private PageFactory $pageFactory;

    public function __construct(
        Context $context,
        PageFactory $pageFactory
    )
    {
        $this->pageFactory = $pageFactory;
        parent::__construct($context);
    }

    private function _initAction()
    {
        $resultPage = $this->pageFactory->create();

        return $resultPage;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        if ($id) {

        }

        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend($id ? __('Edit Offer') : __('Add Offer'));

        return $resultPage;
    }
}
