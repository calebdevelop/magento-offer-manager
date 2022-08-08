<?php

namespace DND\OfferManager\Setup;

use DND\OfferManager\Model\Headband;
use Magento\Eav\Setup\EavSetup;

class HeadbandSetup extends EavSetup
{
    public function getDefaultEntities(): array
    {
        return [
            Headband::ENTITY => [
                'entity_model' => \DND\OfferManager\Model\ResourceModel\Headband::class,
                'table' => Headband::ENTITY . '_entity',
                'attributes' => [
                    'show_at' => [
                        'type' => 'static',
                    ],
                    'show_until' => [
                        'type' => 'static',
                    ],
                ],
            ],
        ];
    }
}
