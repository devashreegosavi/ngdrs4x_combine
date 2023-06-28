<?php
namespace App\Model\Table;
use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;

class ValuationRuleTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_evalrule_new');
        $this->setPrimaryKey('evalrule_id');
    }

}

?>