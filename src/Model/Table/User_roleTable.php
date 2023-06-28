<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

class User_roleTable extends Table {

public function initialize(array $config): void {
$this->setTable('ngdrstab_mst_userroles');
$this->setPrimaryKey('id');
}
}
