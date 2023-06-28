<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query; 

class RateTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_rate');
        $this->setPrimaryKey('rate_id');
    }

}

?>