<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class DocumentExecutionTypeTable extends Table
{
    
    public function initialize(array $config): void
    {
        $this->setTable('ngdrstab_mst_document_execution_type');
        $this->setPrimaryKey('execution_type_id');
    }
    
}