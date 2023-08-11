<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;

class NationalityTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_nationality');
        $this->setPrimaryKey('nationality_id');
    }
  
}

?>