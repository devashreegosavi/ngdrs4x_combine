<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class NgdrstabMstUnitTable extends Table
{
    
    public function initialize(array $config): void
    {
        $this->setTable('ngdrstab_mst_unit');
        $this->setPrimaryKey('unit_id');
    }
    
}