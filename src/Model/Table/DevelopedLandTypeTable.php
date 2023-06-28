<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class DevelopedLandTypeTable extends Table
{
    
    public function initialize(array $config): void
    {
        $this->setTable('ngdrstab_mst_developed_land_types');
        $this->setPrimaryKey('developed_land_types_id');
    }
    
}