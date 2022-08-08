<?php

namespace DND\OfferManager\Model\ResourceModel;

use DND\OfferManager\Api\Data\HeadbandInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class HeadbandCategory extends AbstractDb
{
    /*
    private ResourceConnection $resourceConnection;

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        ResourceConnection $resourceConnection,
        $connectionName = null
    )
    {
        parent::__construct($context, $connectionName);
    }
    */

    protected function _construct()
    {
        $this->_init('headband_category', 'id');
    }

    public function getCategoryLink(HeadbandInterface $headband, $categoryIds = [])
    {
        $connexion = $this->getConnection();

        $select = $connexion->select();
        $select->from($this->_mainTable, ['category_id']);
        $select->where('headband_id = ?', (int)$headband->getId());

        if (!empty($categoryIds)) {
            $select->where('category_id IN(?)', $categoryIds);
        }

        return $connexion->fetchAll($select);
    }
}
