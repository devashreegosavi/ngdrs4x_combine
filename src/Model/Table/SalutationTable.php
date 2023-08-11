<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;

class SalutationTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_salutation');
        $this->setPrimaryKey('salutation_id');
    }
  
}

?>