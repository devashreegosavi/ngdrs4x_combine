<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class IdentificationTable extends Table
{
    
    public function initialize(array $config): void
    {
        $this->setTable('ngdrstab_trn_identification');
        $this->setPrimaryKey('identification_id');
    }
 
}