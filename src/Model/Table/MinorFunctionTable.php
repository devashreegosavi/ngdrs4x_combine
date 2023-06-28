<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class MinorFunctionTable extends Table
{
    
    public function initialize(array $config): void
    {
        $this->setTable('ngdrstab_mst_minorfunctions');
        $this->setPrimaryKey('minor_id');
    }
     public function getminorfunctionlist($lang){
        $getminorfunlist = $this->find('list', [
                'keyField' => 'minor_id',
                'valueField' => 'function_desc_'.$lang
            ])->where(['dispaly_flag' => 'O'])
              ->order(['function_desc_en' => 'ASC'])->toArray();
        return $getminorfunlist;
    }
    
}