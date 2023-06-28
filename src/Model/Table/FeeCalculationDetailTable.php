<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class FeeCalculationDetailTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_trn_fee_calculation_detail');
        $this->setPrimaryKey('fee_calc_detail_id');
    }

}
