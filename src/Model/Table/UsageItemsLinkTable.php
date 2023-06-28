<?php

namespace App\Model\Table;
 
use Cake\ORM\Table;
 

class UsageItemsLinkTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_evalsubrule');
        $this->setPrimaryKey('subrule_id');
    }

    

}

?>