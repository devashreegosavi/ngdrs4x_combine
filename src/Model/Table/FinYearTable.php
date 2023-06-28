<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

class FinYearTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_finyear');
        $this->setPrimaryKey('finyear_id');
    }

    public function FinYearListdata($lang) {
        $FinyearList = $this->find('list', [
                    'keyField' => 'finyear_id',
                    'valueField' => 'finyear_desc'
                ])->toArray();
        return $FinyearList;
    }

}

?>