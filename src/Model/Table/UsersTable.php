<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class UsersTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_user');
        $this->setPrimaryKey('user_id');
    }

}
