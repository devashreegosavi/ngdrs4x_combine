<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class PaymentModeTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_payment_mode');
        $this->setPrimaryKey('id');
    }

}
