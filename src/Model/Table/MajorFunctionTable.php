<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class MajorFunctionTable extends Table
{
    
    public function initialize(array $config): void
    {
        $this->setTable('ngdrstab_mst_majorfunctions');
        $this->setPrimaryKey('id');
    }

    
    
}