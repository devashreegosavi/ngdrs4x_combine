<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

class ValSubruleTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_evalsubrule');
        $this->setPrimaryKey('subrule_id');
    }

    public function ValSubrulelistdata($lang) {
        $ValSubruledata = $this->find('list', [
                    'keyField' => 'subrule_id',
                    'valueField' => 'evalsubrule_desc'
                ])->toArray();
        return $ValSubruledata;
    }

}

?>