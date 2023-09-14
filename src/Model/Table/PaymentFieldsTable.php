<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class PaymentFieldsTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_payment_fields');
        $this->setPrimaryKey('id');
    }

}
