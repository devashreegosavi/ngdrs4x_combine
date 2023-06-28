<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class WitnessFieldsTable extends Table
{
    
    public function initialize(array $config): void
    {
        $this->setTable('ngdrstab_mst_witness_fields');
        $this->setPrimaryKey('field_id');
    }
    
}