<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;

class BankPaymentTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_trn_bank_payment');
        $this->setPrimaryKey('trn_id');
    }
  
}

?>