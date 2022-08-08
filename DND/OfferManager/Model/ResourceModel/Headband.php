<?php

namespace DND\OfferManager\Model\ResourceModel;

use DND\OfferManager\Api\Data\HeadbandInterface;
use Magento\Eav\Model\Entity\AbstractEntity;
use Magento\Eav\Model\Entity\Attribute\UniqueValidationInterface;
use Magento\Eav\Model\Entity\AttributeLoaderInterface;
use Magento\Eav\Model\Entity\Context;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\DataObject;
use Magento\Framework\EntityManager\EntityManager;

class Headband extends AbstractEntity
{
    private EntityManager $entityManager;

    private $categoryLinkInstance;

    public function __construct(
        Context $context,
        EntityManager $entityManager,
        $data = [],
        UniqueValidationInterface $uniqueValidator = null,
        AttributeLoaderInterface $attributeLoader = null
    )
    {
        $this->entityManager = $entityManager;
        parent::__construct($context, $data, $uniqueValidator, $attributeLoader);
    }

    public function getEntityType(): \Magento\Eav\Model\Entity\Type
    {
        if (empty($this->_type)) {
            $this->setType(\DND\OfferManager\Model\Headband::ENTITY);
        }
        return parent::getEntityType();
    }

    /**
     * @param HeadbandInterface|\Magento\Framework\Model\AbstractModel $object
     * @return $this|Headband
     * @throws \LogicException
     * @throws \Exception
     */
    public function save(\Magento\Framework\Model\AbstractModel $object)
    {
        $this->entityManager->save($object);
        $object->afterSave();
        return $this;
    }

    /**
     * @return \DND\OfferManager\Model\ResourceModel\HeadbandCategory
     */
    public function getHeadbandCategoryLink()
    {
        if (null === $this->categoryLinkInstance) {
            $this->categoryLinkInstance = ObjectManager::getInstance()
                ->get(\DND\OfferManager\Model\ResourceModel\HeadbandCategory::class);
        }
        return $this->categoryLinkInstance;
    }

    /**
     * @param $headband HeadbandInterface|DataObject
     * @return array
     */
    public function getCategoryIds($headband)
    {
        $result = $this->getHeadbandCategoryLink()->getCategoryLink($headband);
        return array_column($result, 'category_id');
    }

    protected function _afterLoad(DataObject $object)
    {
        $object->setData(HeadbandInterface::CATEGORY_IDS, $this->getCategoryIds($object));
        return parent::_afterLoad($object);
    }
}
