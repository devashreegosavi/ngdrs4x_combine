<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;

class ArticleDepFieldsTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_trn_articledepfields');
        $this->setPrimaryKey('id');
    }
   
    public function savedependent_field($lang,$gen_add,$Selectedtoken,$fields,$usertype){
        
    }
}

?>