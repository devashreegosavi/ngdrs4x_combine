<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;

class AttributeParameterTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_attribute_parameter');
        $this->setPrimaryKey('attribute_id');
    }

}

?>