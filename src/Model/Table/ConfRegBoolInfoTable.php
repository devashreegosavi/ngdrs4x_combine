<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ConfRegBoolInfoTable extends Table
{
    
    public function initialize(array $config): void
    {
        $this->setTable('ngdrstab_conf_reg_bool_info');
        $this->setPrimaryKey('reginfo_id');
    }
    public function getconfvalueresult($reginfo_id){
        
        $getresult = $this->find()
                    ->select(['is_boolean', 'conf_bool_value'])
                    ->where(['reginfo_id =' => $reginfo_id])
                    ->toArray();        
        $getresult=$getresult[0]->toArray();
        
        return $getresult;    
    }
    
}