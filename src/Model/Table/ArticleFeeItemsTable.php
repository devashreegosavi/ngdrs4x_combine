<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ArticleFeeItemsTable extends Table
{
    
    public function initialize(array $config): void
    {
        $this->setTable('ngdrstab_mst_article_fee_items');
        $this->setPrimaryKey('fee_item_id');
    }
    
}