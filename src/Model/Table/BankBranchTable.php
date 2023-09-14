<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;

class BankBranchTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_bank_branch');
        $this->setPrimaryKey('branch_id');
    }
  
}

?>