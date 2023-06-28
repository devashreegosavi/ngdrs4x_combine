<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

class UsageMainCategoryTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_usage_main_category');
        $this->setPrimaryKey('usage_main_catg_id');
    }
	
	 public function UsageMainCategoryListdata($lang) {
        $MainCatglist = $this->find('list', [
                    'keyField' => 'usage_main_catg_id',
                    'valueField' => 'usage_main_catg_desc_' . $lang
                ])->toArray();
        return $MainCatglist;
    }

}

?>