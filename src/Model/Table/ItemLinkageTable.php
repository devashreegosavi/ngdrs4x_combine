<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

class ItemLinkageTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_usage_lnk_category');
        $this->setPrimaryKey('usage_lnk_id');
    }

    public function fieldlist($MainLanguagedata) {
        $fieldlist['valrule_itemlinkage']['usage_param_id']['select'] = 'is_required';
    }
}

?>