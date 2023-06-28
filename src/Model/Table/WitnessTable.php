<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class WitnessTable extends Table
{
    
    public function initialize(array $config): void
    {
        $this->setTable('ngdrstab_trn_witness');
        $this->setPrimaryKey('witness_id');
    }
    
}