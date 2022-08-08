<?php

namespace DND\OfferManager\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class HeadbandAction extends Column
{
    CONST EDIT_PATH = 'offer/headband/edit';

    CONST REMOVE_PATH = 'offer/headband/remove';

    private UrlInterface $urlBuilder;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    )
    {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->urlBuilder = $urlBuilder;
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $item[$this->getData('name')] = [
                    'edit' => [
                        'href' => $this->urlBuilder->getUrl(self::EDIT_PATH, ['id' => $item['entity_id']]),
                        'label' => __('Edit')
                    ],
                    'remove' => [
                        'href' => $this->urlBuilder->getUrl(self::REMOVE_PATH, ['id' => $item['entity_id']]),
                        'label' => __('Remove'),
                        'confirm' => [
                            'title' => __('Delete %1', $item['title']),
                            'message' => __('Are you sure you want to delete a %1 record?', $item['title']),
                        ],
                        'post' => true,
                    ],
                ];
            }
        }

        return $dataSource;
    }
}
