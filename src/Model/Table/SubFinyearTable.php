<?php

namespace App\Model\Table;

use Cake\ORM\Table;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SubFinyearTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_finyear_sub');
        $this->setPrimaryKey('sub_finyear_id');
    }

}