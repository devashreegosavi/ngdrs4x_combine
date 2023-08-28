<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class IdentificationFieldsTable extends Table
{
    
    public function initialize(array $config): void
    {
        $this->setTable('ngdrstab_mst_identifire_fields');
        $this->setPrimaryKey('id');
    }
 
}