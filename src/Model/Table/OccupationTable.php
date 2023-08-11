<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class OccupationTable extends Table
{
    
    public function initialize(array $config): void
    {
        $this->setTable('ngdrstab_mst_occupation');
        $this->setPrimaryKey('occupation_id');
    }
    
}