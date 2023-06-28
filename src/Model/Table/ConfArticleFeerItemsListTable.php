<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ConfArticleFeerItemsListTable extends Table
{
    
    public function initialize(array $config): void
    {
        $this->setTable('ngdrstab_conf_article_fee_items_list');
        $this->setPrimaryKey('fee_item_list_id');
    }
    
   
}