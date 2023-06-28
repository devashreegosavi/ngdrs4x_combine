<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query; 

class RateSearchTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_conf_rate_search');
        $this->setPrimaryKey('search_id');
    }

}

?>