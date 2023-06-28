<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ArticleTrnFieldsTable extends Table
{
    
    public function initialize(array $config): void
    {
        $this->setTable('ngdrstab_trn_articledepfields');
        $this->setPrimaryKey('id');
    }
   
}