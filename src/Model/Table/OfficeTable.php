<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class OfficeTable extends Table
{
    
    public function initialize(array $config): void
    {
        $this->setTable('ngdrstab_mst_office');
        $this->setPrimaryKey('office_id');
    }
    
}