<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

class UsageSubCategoryTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_usage_sub_category');
        $this->setPrimaryKey('usage_sub_catg_id');
    }

}

?>