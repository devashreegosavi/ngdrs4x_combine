<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query; 
class DistrictTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_conf_admblock3_district');
        $this->setPrimaryKey('district_id');
    }
	
	  public function Districtlistdata($lang) {
        $Districtdata = $this->find('list', [
                    'keyField' => 'district_id',
                    'valueField' => 'district_name_' . $lang
                ])->toArray();
        return $Districtdata;
    }
	

}

?>