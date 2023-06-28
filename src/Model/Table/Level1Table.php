<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

class Level1Table extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_location_levels_1_property');
        $this->setPrimaryKey('level_1_id');
    }
	
	
	 public function getleveldata($level_1_id, $lang) {

        $Level1data = $this
                        ->find()
                        ->select(
                                [
                                    'Village.village_id', //Village
                                    'landtype.developed_land_types_id', //landtype
                                    'corptype.corp_id', //corporation
                                    'Village.circle_id', //Circle from village as its optional
//                                            'cir.circle_id', //circle
                                    'Taluka.taluka_id', //Taluka
                                    'Taluka.subdivision_id', //Subdivision from taluka as its optional
//                                            'sdiv.subdivision_id', //Subdivision
                                    'District.district_id', //District
                                    'District.division_id', //Division from district table as its optional
//                                            'Div.division_id' //Division
                                    'level_1_desc_' . $lang, 'latitude', 'longitude','level_1_id'
                                ]
                        )
                        ->join(
                                [
                                    'Village' => [
                                        'table' => 'ngdrstab_conf_admblock7_village_mapping',
                                        'type' => 'LEFT',
                                        'conditions' => 'Village.village_id = Level1.village_id',
                                    ], //Village
                                    'landtype' => [
                                        'table' => 'ngdrstab_mst_developed_land_types',
                                        'type' => 'LEFT',
                                        'conditions' => 'landtype.developed_land_types_id = Village.developed_land_types_id',
                                    ], //landtype
                                    'corptype' => [
                                        'table' => 'ngdrstab_conf_admblock_local_governingbody_list',
                                        'type' => 'LEFT',
                                        'conditions' => 'corptype.corp_id = Village.corp_id',
                                    ], //LGB
//                                            'cir' => [
//                                                'table' => 'ngdrstab_conf_admblock6_circle',
//                                                'type' => 'LEFT',
//                                                'conditions' => 'cir.circle_id = Village.circle_id',
//                                            ], //circle
                                    'Taluka' => [
                                        'table' => 'ngdrstab_conf_admblock5_taluka',
                                        'type' => 'LEFT',
                                        'conditions' => 'Taluka.taluka_id = Village.taluka_id',
                                    ], //taluka
//                                            'sdiv' => [
//                                                'table' => 'ngdrstab_conf_admblock4_subdivision',
//                                                'type' => 'LEFT',
//                                                'conditions' => 'sdiv.subdivision_id = Rate.level1_list_id',
//                                            ], //subdivision
//                                            
                                    'District' => [
                                        'table' => 'ngdrstab_conf_admblock3_district',
                                        'type' => 'LEFT',
                                        'conditions' => 'District.district_id = Taluka.district_id',
                                    ] //district
//                                            'Div' => [
//                                                'table' => 'ngdrstab_conf_admblock2_division',
//                                                'type' => 'LEFT',
//                                                'conditions' => 'Div.division_id = Rate.prop_unit',
//                                            ]//division
                        ])
                        ->where(['level_1_id' => $level_1_id])->toArray();

        $leveldata = $Level1data[0]->toArray();
        return $leveldata;
    }

    public function assigndata($leveldata) {

        foreach ($leveldata as $key => $data) {
            if (is_array($data) && !empty($data)) {
                foreach ($data as $key => $value) {
                    $Edit_request_data[$key] = $value;
                }
            }
            $Edit_request_data[$key] = $data;
        }
        return $Edit_request_data;
    }

    public function fieldlist() {
        
        $fieldlist['level1']['level_1_desc_en']['text'] = 'is_required';
        $fieldlist['level1']['latitude']['text'] = 'is_required';
        $fieldlist['level1']['longitude']['text'] = 'is_required';
        return $fieldlist;
    }

	

}

?>