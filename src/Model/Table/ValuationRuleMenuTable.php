<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;

class ValuationRuleMenuTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_rulefunctions');
        $this->setPrimaryKey('function_id');
    }

}

?>