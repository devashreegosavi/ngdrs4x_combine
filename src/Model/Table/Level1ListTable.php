<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query; 

class Level1ListTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_loc_level_1_prop_list');
        $this->setPrimaryKey('prop_level1_list_id');
    }
	
	 public function getleveldata($prop_level1_list_id, $lang) {

        $Level1listdata = $this
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
                                    'Level1.level_1_id',
                                    'Level1List.prop_level1_list_id',
                                    'Level1List.list_1_desc_' . $lang
                                ]
                        )
                        ->join(
                                [
                                    'Village' => [
                                        'table' => 'ngdrstab_conf_admblock7_village_mapping',
                                        'type' => 'LEFT',
                                        'conditions' => 'Village.village_id = Level1List.village_id',
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
                                    ], //district
//                                            'Div' => [
//                                                'table' => 'ngdrstab_conf_admblock2_division',
//                                                'type' => 'LEFT',
//                                                'conditions' => 'Div.division_id = Rate.prop_unit',
//                                            ]//division
                                    'Level1' => [
                                        'table' => 'ngdrstab_mst_location_levels_1_property',
                                        'type' => 'LEFT',
                                        'conditions' => 'Level1.level_1_id = Level1List.level_1_id',
                                    ]
                        ])
                        ->where(['prop_level1_list_id' => $prop_level1_list_id])->toArray();
       
        $levellistdata = $Level1listdata[0]->toArray();
       
        
        return $levellistdata;
    }

    public function assigndata($levellistdata) {
//pr($levellistdata);
        foreach ($levellistdata as $key1=> $data) {
            //pr($data);
            //pr($key);
            if (is_array($data) && !empty($data)) {
                foreach ($data as $key => $value) {
                //    pr($value);
                    $Edit_request_data[$key] = $value;
                }
            }
            $Edit_request_data[$key1] = $data;
        }
//        pr($Edit_request_data);exit;
        return $Edit_request_data;
    }

    public function fieldlist() {
        $fieldlist['level1list']['list_1_desc_en']['text'] = 'is_required';
        return $fieldlist;
    }

	

}

?>