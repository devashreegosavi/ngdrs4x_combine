<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

class CasteCategoryTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_caste_category');
        $this->setPrimaryKey('id');
    }

}

?>