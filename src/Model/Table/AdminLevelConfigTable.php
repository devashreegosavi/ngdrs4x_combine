<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class AdminLevelConfigTable extends Table
{
    
    public function initialize(array $config): void
    {
        $this->setTable('ngdrstab_conf_state_district_div_level');
        $this->setPrimaryKey('config_id');
    }
    
}