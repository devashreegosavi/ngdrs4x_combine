<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;

class ValuationTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_trn_valuation');
        $this->setPrimaryKey('val_id');
    }

    public function fieldlist($config) {


        if ($config['AdmBlocks']['is_div'] == 'Y') {
            $fieldlist['propertyValuation']['division_id']['select'] = 'is_select_req';
        }
        if ($config['AdmBlocks']['is_dist'] == 'Y') {
            $fieldlist['propertyValuation']['district_id']['select'] = 'is_select_req';
        }
        if ($config['AdmBlocks']['is_subdiv'] == 'Y') {
            $fieldlist['propertyValuation']['subdivision_id']['select'] = 'is_select_req';
        }
        if ($config['AdmBlocks']['is_taluka'] == 'Y') {
            $fieldlist['propertyValuation']['taluka_id']['select'] = 'is_select_req';
        }

        return $fieldlist;
    }

}

?>