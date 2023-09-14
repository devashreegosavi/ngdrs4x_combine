<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class TrnCitizenPaymentEntryTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_trn_citizen_payment_entry');
        $this->setPrimaryKey('payment_id');
    }

}
