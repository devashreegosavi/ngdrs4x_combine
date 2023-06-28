<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

class ItemListTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_usage_items_list');
        $this->setPrimaryKey('usage_param_id');
    }

    public function InputItemListdata($lang) {
        $InputItemList = $this->find('list', [
                            'keyField' => 'usage_param_id',
                            'valueField' => 'usage_param_desc_' . $lang])
                        ->where(['usage_param_type_id =' => 1])->toArray();
        return $InputItemList;
    }

    public function OutputItemListdata($lang) {

        $OutputItemList = $this->find('list', [
                            'keyField' => 'usage_param_id',
                            'valueField' => 'usage_param_desc_' . $lang])
                        ->where(['usage_param_type_id =' => 2])->toArray();
        return $OutputItemList;
    }

}

?>