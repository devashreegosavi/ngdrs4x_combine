<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

class UsageCategoryTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_usage_category');
        $this->setPrimaryKey('usage_cat_id');
    }

}

?>