<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class GovPartyTypeTable extends Table
{
    
    public function initialize(array $config): void
    {
        $this->setTable('ngdrstab_conf_government_partytype');
        $this->setPrimaryKey('id');
    }
    
}