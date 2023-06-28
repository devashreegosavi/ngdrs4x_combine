<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class GenderTable extends Table
{
    
    public function initialize(array $config): void
    {
        $this->setTable('ngdrstab_mst_gender');
        $this->setPrimaryKey('id');
    }
    
}