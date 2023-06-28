<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class GoverningBodyListTable extends Table
{
    
    public function initialize(array $config): void
    {
        $this->setTable('ngdrstab_conf_admblock_local_governingbody_list');
        $this->setPrimaryKey('corp_id');
    }
    
}