<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

class ConfigLanguageTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_conf_language');
        $this->setPrimaryKey('language_id');
    }

}
