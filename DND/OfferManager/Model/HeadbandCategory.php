<?php

namespace DND\OfferManager\Model;

use DND\OfferManager\Api\Data\HeadbandCategoryInterface;
use DND\OfferManager\Api\Data\HeadbandInterface;
use DND\OfferManager\Model\ResourceModel\HeadbandCategory as Resource;
use Magento\Framework\Model\AbstractModel;

class HeadbandCategory extends AbstractModel implements HeadbandCategoryInterface
{
    private $saveHeadbandCategory;

    /** @var Resource */
    protected $_resource;

    /** @var Resource\Collection */
    protected $_resourceCollection;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        Resource $resource = null,
        Resource\Collection $resourceCollection = null,
        array $data = []
    ){
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    protected function _construct()
    {
        $this->_init(ResourceModel\HeadbandCategory::class);
    }

    /**
     * @return \DND\OfferManager\Model\HeadbandCategory\SaveHandler
     */
    public function getHeadbandCategorySaveHandler()
    {
        if (null === $this->saveHeadbandCategory) {
            $this->saveHeadbandCategory = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\DND\OfferManager\Model\HeadbandCategory\SaveHandler::class);
        }
        return $this->saveHeadbandCategory;
    }

    public function saveHeadbandCategoriesRelations(HeadbandInterface $headband)
    {
        $this->getHeadbandCategorySaveHandler()->execute($headband);
    }
}
