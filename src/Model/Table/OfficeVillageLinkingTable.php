<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class OfficeVillageLinkingTable extends Table
{
    
    public function initialize(array $config): void
    {
        $this->setTable('ngdrstab_trn_office_village_linking');
        $this->setPrimaryKey('id');
    }
    
}