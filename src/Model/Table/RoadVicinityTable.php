<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class RoadVicinityTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_road_vicinity');
        $this->setPrimaryKey('road_vicinity_id');
    }

}

?>