<?php

namespace DND\OfferManager\Model;

use DND\OfferManager\Api\Data\HeadbandCategoryInterface;
use DND\OfferManager\Api\Data\HeadbandInterface;
use DND\OfferManager\Model\ResourceModel\Headband\Collection;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\Framework\Model\AbstractModel;

class Headband extends AbstractModel implements HeadbandInterface
{
    CONST ENTITY = 'headband';

    private HeadbandCategoryInterface $headbandCategoryInstance;

    /** @var \DND\OfferManager\Model\ResourceModel\Headband */
    protected $_resource;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        HeadbandCategoryInterface $headbandCategory,
        \Magento\Framework\Registry $registry,
        \DND\OfferManager\Model\ResourceModel\Headband $resource,
        Collection $resourceCollection,
        array $data = []
    )
    {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->headbandCategoryInstance = $headbandCategory;
    }

    protected function _construct()
    {
        $this->_init(ResourceModel\Headband::class);
    }

    private function getHeadbandCategoryInstance(): HeadbandCategoryInterface
    {
        return $this->headbandCategoryInstance;
    }

    public function afterSave()
    {
        $this->getHeadbandCategoryInstance()->saveHeadbandCategoriesRelations($this);
        return parent::afterSave();
    }

    public function getId()
    {
        return $this->_getData(self::ID);
    }

    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    public function setTitle($title)
    {
        $this->setData(self::TITLE, $title);
        return $this;
    }

    public function isActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    public function setIsActive($active)
    {
        $this->setData(self::IS_ACTIVE, $active);
        return $this;
    }

    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    public function setDescription($description)
    {
        $this->setData(self::DESCRIPTION, $description);
        return $this;
    }

    public function getLink()
    {
        return $this->getData(self::LINK);
    }

    public function setLink($link)
    {
        $this->setData(self::LINK, $link);
        return $this;
    }

    public function getShowAt()
    {
        return $this->getData(self::SHOW_AT);
    }

    public function setShowAt($showAt)
    {
        $this->setData(self::SHOW_AT, $showAt);
        return $this;
    }

    public function getShowUntil()
    {
        return $this->getData(self::SHOW_UNTIL);
    }

    public function setShowUntil($showUntil)
    {
        $this->setData(self::SHOW_UNTIL, $showUntil);
    }

    public function setCategoryIds($categoryIds)
    {
        $this->setData(self::CATEGORY_IDS, $categoryIds);
        return $this;
    }

    /**
     * @return ResourceModel\Headband
     */
    protected function _getResource()
    {
        return $this->_resource;
    }

    public function getCategoryIds()
    {
        if (!$this->hasData(self::CATEGORY_IDS)) {
            $ids = $this->getCategoryIdsInDb();
            $this->setData(self::CATEGORY_IDS, $ids);
        }
        return $this->getData(self::CATEGORY_IDS) ?? [];
    }

    public function getCategoryIdsInDb(): array
    {
        return $this->_getResource()->getCategoryIds($this) ?? [];
    }

    /**
     * @param $media
     * @return HeadbandInterface
     */
    public function setMedia($media)
    {
        $this->setData(self::MEDIA, $media);
        return $this;
    }

    public function getMedia()
    {
        return $this->getData(self::MEDIA);
    }
}
