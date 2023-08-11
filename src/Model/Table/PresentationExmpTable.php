<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class PresentationExmpTable extends Table
{
    
    public function initialize(array $config): void
    {
        $this->setTable('ngdrstab_mst_presentation_exemption');
        $this->setPrimaryKey('exemption_id');
    }
    
}