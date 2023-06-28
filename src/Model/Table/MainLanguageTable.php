<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

class MainLanguageTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_language');
        $this->setPrimaryKey('id');
    }

    public function MainLanguagelistdata($lang) {
        $MainLanguagedata = $this->find()
                ->select(['mainlanguage.id','language_name', 'language_code'])
                ->join([
                    'conf' => [
                        'table' => 'ngdrstab_conf_language',
                        'type' => 'INNER',
                        'conditions' => 'conf.language_id = MainLanguage.id',
                    ]
                ])
                ->order(['conf.language_id' => 'ASC'])->toArray();
        
        return $MainLanguagedata;
    }

       
}
