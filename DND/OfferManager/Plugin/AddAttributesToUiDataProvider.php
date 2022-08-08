<?php

namespace DND\OfferManager\Plugin;

use DND\OfferManager\Model\Headband;
use DND\OfferManager\Ui\DataProvider\ListingDataProvider;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

class AddAttributesToUiDataProvider
{
    private AttributeRepositoryInterface $attributeRepository;

    public function __construct(
        AttributeRepositoryInterface $attributeRepository
    )
    {
        $this->attributeRepository = $attributeRepository;
    }

    public function afterGetSearchResult(ListingDataProvider $dataProvider, SearchResult $searchResult)
    {
        $descriptionAttr = $this->attributeRepository->get(Headband::ENTITY, 'description');
        $mediaAttr = $this->attributeRepository->get(Headband::ENTITY, 'media');

        $searchResult->getSelect()
            ->joinLeft(
                ['desc_attr' => $searchResult->getTable('headband_entity_varchar')],
                'desc_attr.entity_id = main_table.entity_id and desc_attr.attribute_id = '
                . $descriptionAttr->getAttributeId(),
                ['description' => 'desc_attr.value']
            )
            ->joinLeft(
                ['media_attr' => $searchResult->getTable('headband_entity_media')],
                'media_attr.entity_id = main_table.entity_id and media_attr.attribute_id = '
                . $mediaAttr->getAttributeId(),
                ['media' => 'media_attr.value']
            );

        return $searchResult;
    }
}
