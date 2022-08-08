<?php

namespace DND\OfferManager\Block\Frontend\Headband;

class Template extends \Magento\Framework\View\Element\Template
{
    protected $registry;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    )
    {
        $this->registry = $registry;
        parent::__construct($context, $data);
    }

    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getCurrentCategory()
    {
        return $this->registry->registry('current_category')->getId();
    }
}
