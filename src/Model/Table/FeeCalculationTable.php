<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class FeeCalculationTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_trn_fee_calculation');
        $this->setPrimaryKey('fee_calc_id');
    }

}
