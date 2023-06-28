<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ValuationController extends AppController {

    var $base_path = WWW_ROOT;

    public function get_valuation_config() {
        try {
            if (file_exists($this->base_path . 'files/valuation-config.json')) {
                $file = new File($this->base_path . 'files/valuation-config.json');
            } else {
                $file = new File($this->base_path . 'files/valuation-config.json', true, 0755);
            }
            $json = $file->read();
            $json2array = json_decode($json, TRUE);
            if (!isset($json2array['AdmBlocks']) || empty($json2array['AdmBlocks'])) {
                $AdmBlocks = $this->fetchTable('AdmBlocks')
                        ->find()
                        ->select(['is_div', 'is_dist', 'is_subdiv', 'is_taluka', 'is_circle', 'is_village'])
                        ->toArray();
                if (!empty($AdmBlocks)) {
                    $json2array['AdmBlocks'] = $AdmBlocks[0]->toArray();
                }
            }

            if (!isset($json2array['RegConfig']) || empty($json2array['RegConfig'])) {
                $regconf_attr = $this->fetchTable('RegConfig')->find('list',
                                        [
                                            'keyField' => 'reginfo_id',
                                            'valueField' => 'info_value']
                                )
                                ->where(['reginfo_id IN' => ['Property Atrribute' => 601, 'Prohibition' => 602, 'View Rate(RR2)' => 6030], 'is_boolean' => 'Y', 'conf_bool_value' => 'Y'])->toArray();
                $json2array['RegConfig'] = $regconf_attr;
            }
            if (!isset($json2array['AttributeDetails']) || empty($json2array['AttributeDetails'])) {
                $json2array['AttributeDetails'] = $this->fetchTable('AttributeParameter')
                                ->find()
                                ->where(['display_flag =' => 'Y'])->toArray();
            }


            //write to json file
            $file->write(json_encode($json2array));
            $file->close();
            return $json2array;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function _setValuationData($json2array) {
        try {
            $user_id = $this->request->getSession()->read('Auth.user_id');

            if (file_exists($this->base_path . 'files/' . $user_id . '_valuation.json')) {
                $file = new File($this->base_path . 'files/' . $user_id . '_valuation.json');
            } else {
                $file = new File($this->base_path . 'files/' . $user_id . '_valuation.json', true, 0755);
            }
            //write to json file
            $file->write(json_encode($json2array));
            $file->close();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function _getValuationData() {
        try {
            $user_id = $this->request->getSession()->read('Auth.user_id');

            if (file_exists($this->base_path . 'files/' . $user_id . '_valuation.json')) {
                $file = new File($this->base_path . 'files/' . $user_id . '_valuation.json');
            } else {
                $file = new File($this->base_path . 'files/' . $user_id . '_valuation.json', true, 0755);
            }
            $json = $file->read();
            $file->close();
            $json2array = json_decode($json, TRUE);

            return $json2array;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function valuation_initialize($config) {
        try {
            $this->_setValuationData(array());
            $lang = $this->request->getSession()->read('Config.language');

            $Division_List = $District_List = $Subdivision_List = $Taluka_List = $Circle_List = $Village_List = $Dtypes_List = $Corp_List = $Level1_Data = $Level1List = array();

            if ($config['AdmBlocks']['is_div'] == 'Y') {
                $Division_List = $this->fetchTable('Division')->find('list', [
                            'keyField' => 'division_id',
                            'valueField' => 'division_name_' . $lang
                        ])->toArray();
            } else if ($config['AdmBlocks']['is_div'] == 'N' && $config['AdmBlocks']['is_dist'] == 'Y') {
                $District_List = $this->fetchTable('District')->find('list', [
                            'keyField' => 'district_id',
                            'valueField' => 'district_name_' . $lang
                        ])->toArray();
            }

            $json2array['AttributeParameter'] = $PropertyAttributes = $this->fetchTable('AttributeParameter')
                            ->find('list', [
                                'keyField' => 'attribute_id',
                                'valueField' => 'attribute_name_' . $lang])
                            ->where(['display_flag =' => 'Y'])->toArray();

            $json2array['UsageMain'] = $UsageMain = $this->fetchTable('UsageMainCategory')
                            ->find('list', [
                                'keyField' => 'usage_main_catg_id',
                                'valueField' => 'usage_main_catg_desc_' . $lang])
                            ->join([
                                'UsageCategory' => [
                                    'table' => 'ngdrstab_mst_usage_category',
                                    'type' => 'INNER',
                                    'conditions' => 'UsageCategory.usage_main_catg_id = UsageMainCategory.usage_main_catg_id',
                                ]
                            ])
                            ->where(['UsageCategory.evalrule_id IS NOT ' => NULL])->toArray();

            $json2array['Ctype'] = $this->fetchTable('ConstructionType')
                               ->find('list', [
                                'keyField' => 'construction_type_id',
                                'valueField' => 'construction_type_desc_' . $lang])
                             
                            ->order(['ConstructionType.construction_type_desc_'.$lang.' ASC ' ])->toArray();
            
            $json2array['Dtype'] = $this->fetchTable('DepreciationType')
                               ->find('list', [
                                'keyField' => 'deprication_type_id',
                                'valueField' => 'deprication_type_desc_' . $lang])
                             
                            ->order(['DepreciationType.deprication_type_desc_'.$lang.' ASC ' ])->toArray();
            
             $json2array['RType'] = $this->fetchTable('RoadVicinity')
                               ->find('list', [
                                'keyField' => 'road_vicinity_id',
                                'valueField' => 'road_vicinity_desc_' . $lang])                             
                            ->order(['RoadVicinity.road_vicinity_desc_'.$lang.' ASC ' ])->toArray();
             
             $json2array['UDD1'] = $this->fetchTable('UserDefinedDependency1')
                               ->find('list', [
                                'keyField' => 'user_defined_dependency1_id',
                                'valueField' => 'user_defined_dependency1_desc_' . $lang])                             
                            ->order(['UserDefinedDependency1.user_defined_dependency1_desc_'.$lang.' ASC ' ])->toArray();
            
             $json2array['UDD2'] = $this->fetchTable('UserDefinedDependency2')
                               ->find('list', [
                                'keyField' => 'user_defined_dependency2_id',
                                'valueField' => 'user_defined_dependency2_desc_' . $lang])                             
                            ->order(['UserDefinedDependency2.user_defined_dependency2_desc_'.$lang.' ASC ' ])->toArray();
            
            
             $json2array['UsageSub'] = $UsageSub = $this->fetchTable('UsageSubCategory')
                            ->find()
                            ->select(['UsageCategory.usage_main_catg_id', 'usage_sub_catg_id', 'usage_sub_catg_desc_' . $lang])
                            ->join([
                                'UsageCategory' => [
                                    'table' => 'ngdrstab_mst_usage_category',
                                    'type' => 'INNER',
                                    'conditions' => 'UsageCategory.usage_sub_catg_id = UsageSubCategory.usage_sub_catg_id',
                                ]
                            ])
                            ->where(['UsageCategory.evalrule_id IS NOT ' => NULL])->toArray();
            

            $json2array['EvalRule'] = $EvalRule = $this->_getValuationRuleList(array(), $json2array);

            $this->set(compact('config', 'lang', 'Division_List', 'District_List', 'Subdivision_List', 'Taluka_List', 'Village_List', 'Circle_List', 'Dtypes_List', 'Corp_List', 'Level1_Data', 'Level1List', 'PropertyAttributes', 'UsageMain', 'UsageSub', 'EvalRule'));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            exit;
        }
    }

    public function getDistrictsByDivision() {
        try {
            $lang = $this->request->getSession()->read('Config.language');
            $data = $this->request->getData();
            $divisionid = $data['division_id'];
            if (is_numeric($divisionid)) {
                $result['district'] = $this->fetchTable('District')
                                ->find('list', [
                                    'keyField' => 'district_id',
                                    'valueField' => 'district_name_' . $lang])
                                ->where(['division_id =' => $divisionid])->toArray();

                $json2array = $this->_getValuationData();
                $json2array['Form_Data']['division_id'] = $divisionid;
                $json2array['district'] = $result['district'];
                $this->_setValuationData($json2array);

                echo json_encode($result);
                exit;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSubdivisionTalukaByDistrict() {
        try {
            $lang = $this->request->getSession()->read('Config.language');
            $data = $this->request->getData();
            $district_id = $data['district_id'];
            $json2array = $this->_getValuationData();
            if (is_numeric($district_id)) {
                $config = $this->get_valuation_config();
                //pr($config);
                if ($config['AdmBlocks']['is_subdiv'] == 'Y') {
                    $result['subdivision'] = $this->fetchTable('Subdivision')
                                    ->find('list', [
                                        'keyField' => 'subdivision_id',
                                        'valueField' => 'subdivision_name_' . $lang])
                                    ->where(['district_id =' => $district_id])->toArray();
                    $json2array['subdivision'] = $result['subdivision'];
                } else if ($config['AdmBlocks']['is_taluka'] == 'Y') {
                    $result['taluka'] = $this->fetchTable('Taluka')
                                    ->find('list', [
                                        'keyField' => 'taluka_id',
                                        'valueField' => 'taluka_name_' . $lang])
                                    ->where(['district_id =' => $district_id])->toArray();
                    $json2array['taluka'] = $result['taluka'];
                }

                $json2array['Form_Data']['district_id'] = $district_id;
                $this->_setValuationData($json2array);

                echo json_encode($result);
                exit;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTalukaBySubdivision() {
        try {
            $lang = $this->request->getSession()->read('Config.language');
            $data = $this->request->getData();
            $subdivision_id = $data['subdivision_id'];
            if (is_numeric($subdivision_id)) {

                $result['taluka'] = $this->fetchTable('Taluka')
                                ->find('list', [
                                    'keyField' => 'taluka_id',
                                    'valueField' => 'taluka_name_' . $lang])
                                ->where(['subdivision_id =' => $subdivision_id])->toArray();

                $json2array = $this->_getValuationData();
                $json2array['Form_Data']['subdivision_id'] = $subdivision_id;
                $json2array['taluka'] = $result['taluka'];
                $this->_setValuationData($json2array);

                echo json_encode($result);
                exit;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getCircleVillageByTaluka() {
        try {
            $lang = $this->request->getSession()->read('Config.language');
            $data = $this->request->getData();
            $taluka_id = $data['taluka_id'];
            $json2array = $this->_getValuationData();
            if (is_numeric($taluka_id)) {

                $config = $this->get_valuation_config();
                //pr($config);
                if ($config['AdmBlocks']['is_circle'] == 'Y') {
                    $result['circle'] = $this->fetchTable('Circle')
                                    ->find('list', [
                                        'keyField' => 'circle_id',
                                        'valueField' => 'circle_name_' . $lang])
                                    ->where(['taluka_id =' => $taluka_id])->toArray();
                    $json2array['circle'] = $result['circle'];
                } else if ($config['AdmBlocks']['is_village'] == 'Y') {
                    $result['village'] = $this->fetchTable('Village')
                                    ->find('list', [
                                        'keyField' => 'village_id',
                                        'valueField' => 'village_name_' . $lang])
                                    ->where(['taluka_id =' => $taluka_id])->toArray();
                    $json2array['village'] = $result['village'];
                }
                $json2array['Form_Data']['taluka_id'] = $taluka_id;
                $this->_setValuationData($json2array);

                echo json_encode($result);
                exit;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getVillageByCircle() {
        try {
            $lang = $this->request->getSession()->read('Config.language');
            $data = $this->request->getData();
            $circle_id = $data['circle_id'];
            if (is_numeric($circle_id)) {
                $result['village'] = $this->fetchTable('Village')
                                ->find('list', [
                                    'keyField' => 'village_id',
                                    'valueField' => 'village_name_' . $lang])
                                ->where(['circle_id =' => $circle_id])->toArray();
                $json2array = $this->_getValuationData();
                $json2array['Form_Data']['circle_id'] = $circle_id;
                $json2array['village'] = $result['village'];
                $this->_setValuationData($json2array);

                echo json_encode($result);
                exit;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getLevel1ByVillage() {
        try {
            $lang = $this->request->getSession()->read('Config.language');
            $data = $this->request->getData();
            $village_id = $data['village_id'];
            if (is_numeric($village_id)) {
                $result['level1'] = $this->fetchTable('Level1')
                                ->find('list', [
                                    'keyField' => 'level_1_id',
                                    'valueField' => 'level_1_desc_' . $lang])
                                ->where(['village_id =' => $village_id])->toArray();

                $result['dtypes'] = $this->fetchTable('DevelopLandType')
                                ->find('list', [
                                    'keyField' => 'developed_land_types_id',
                                    'valueField' => 'developed_land_types_desc_' . $lang])
                                ->join([
                                    'village' => [
                                        'table' => 'ngdrstab_conf_admblock7_village_mapping',
                                        'type' => 'INNER',
                                        'conditions' => 'village.developed_land_types_id = DevelopLandType.developed_land_types_id',
                                    ]
                                ])
                                ->where(['village.village_id =' => $village_id])->toArray();

                $result['corp'] = $this->fetchTable('LocalGovBodyList')
                                ->find('list', [
                                    'keyField' => 'corp_id',
                                    'valueField' => 'governingbody_name_' . $lang])
                                ->join([
                                    'village' => [
                                        'table' => 'ngdrstab_conf_admblock7_village_mapping',
                                        'type' => 'INNER',
                                        'conditions' => 'village.corp_id = LocalGovBodyList.corp_id',
                                    ]
                                ])
                                ->where(['village.village_id =' => $village_id])->toArray();

                $json2array = $this->_getValuationData();
                $json2array['Form_Data']['village_id'] = $village_id;
                $json2array['dtypes'] = $result['dtypes'];
                $json2array['corp'] = $result['corp'];
                $json2array['level1'] = $result['level1'];
                $this->_setValuationData($json2array);

                echo json_encode($result);
                exit;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getLevel1ListByLevel1() {
        try {
            $lang = $this->request->getSession()->read('Config.language');
            $data = $this->request->getData();
            $level_1_id = $data['level_1_id'];
            if (is_numeric($level_1_id)) {
                $result['L1_List'] = $this->fetchTable('Level1List')
                                ->find('list', [
                                    'keyField' => 'prop_level1_list_id',
                                    'valueField' => 'list_1_desc_' . $lang])
                                ->where(['level_1_id =' => $level_1_id])->toArray();

                $json2array = $this->_getValuationData();
                $json2array['Form_Data']['level_1_id'] = $level_1_id;
                $json2array['L1_List'] = $result['L1_List'];
                $this->_setValuationData($json2array);

                echo json_encode($result);
                exit;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getAllRates() {
        try {
            $lang = $this->request->getSession()->read('Config.language');
            $response['Error'] = '';
            $data = $this->request->getData();

            if (!isset($data['valuation_as_on_date'])) {
                $data['valuation_as_on_date'] = date('d-m-Y');
            }
            $data = $this->add_finyear_details($data);
//            pr($data);

            if (is_numeric($data['village_id'])) {
                $VillageMapping = $this->fetchTable('Village')->find()
                                ->select(['developed_land_types_id', 'valutation_zone_id', 'ulb_type_id'])
                                ->where(['village_id' => $data['village_id']])->toArray();
                if (!empty($VillageMapping)) {
                    $VillageMapping = $VillageMapping[0]->toArray();
                    if ($data['rate_type'] == 'RRR') {
                        $rate_type = 'Y';
                    } else {
                        $rate_type = 'N';
                    }
                    $rate_selection_rules = $this->fetchTable('RateSearch')->find()
                                    ->where(['developed_land_types_id' => $VillageMapping['developed_land_types_id']])->toArray();

                    foreach ($rate_selection_rules as $searchrule) {
                        $options = array();
                        $options['ready_reckoner_rate_flag'] = $rate_type;
                        $options['finyear_id'] = $data['finyear_id'];
                        $options['sub_finyear_id'] = $data['sub_finyear_id'];

                        $searchrule['RateSearch'] = $searchrule->toArray();
                        if ($searchrule['RateSearch']['division_id'] == 'Y' && isset($data['division_id']) && is_numeric($data['division_id'])) {
                            $options['rate.division_id'] = $data['division_id'];
                        }
                        if ($searchrule['RateSearch']['district_id'] == 'Y' && isset($data['district_id']) && is_numeric($data['district_id'])) {
                            $options['rate.district_id'] = $data['district_id'];
                        }
                        if ($searchrule['RateSearch']['subdivision_id'] == 'Y' && isset($data['subdivision_id']) && is_numeric($data['subdivision_id'])) {
                            $options['rate.subdivision_id'] = $data['subdivision_id'];
                        }
                        if ($searchrule['RateSearch']['taluka_id'] == 'Y' && isset($data['taluka_id']) && is_numeric($data['taluka_id'])) {
                            $options['rate.taluka_id'] = $data['taluka_id'];
                        }
                        if ($searchrule['RateSearch']['circle_id'] == 'Y' && isset($data['circle_id']) && is_numeric($data['circle_id'])) {
                            $options['rate.circle_id'] = $data['circle_id'];
                        }
                        if ($searchrule['RateSearch']['village_id'] == 'Y' && isset($data['village_id']) && is_numeric($data['village_id'])) {
                            $options['rate.village_id'] = $data['village_id'];
                            if (isset($data['level_1_id']) && is_numeric($data['level_1_id'])) {
                                $options['rate.level1_id'] = $data['level_1_id'];
                            }
                            if (isset($data['prop_level1_list_id']) && is_numeric($data['prop_level1_list_id'])) {
                                $options['rate.level1_list_id'] = $data['prop_level1_list_id'];
                            }
                        }
                        if ($searchrule['RateSearch']['valutation_zone_id'] == 'Y') {
                            $options['rate.valutation_zone_id'] = $VillageMapping['valutation_zone_id'];
                        }
                        if ($searchrule['RateSearch']['ulb_type_id'] == 'Y') {
                            $options['rate.ulb_type_id'] = $VillageMapping['ulb_type_id'];
                        }
                        if ($searchrule['RateSearch']['construction_type_id'] == 'Y' && isset($data['construction_type_id']) && is_numeric($data['construction_type_id'])) {
                            $options['rate.construction_type_id'] = $data['construction_type_id'];
                        }
                        if ($searchrule['RateSearch']['road_vicinity_id'] == 'Y' && isset($data['road_vicinity_id']) && is_numeric($data['road_vicinity_id'])) {
                            $options['rate.road_vicinity_id'] = $data['road_vicinity_id'];
                        }
                        if ($searchrule['RateSearch']['user_defined_dependency1_id'] == 'Y' && isset($data['user_defined_dependency1_id']) && is_numeric($data['user_defined_dependency1_id'])) {
                            $options['rate.user_defined_dependency1_id'] = $data['user_defined_dependency1_id'];
                        }
                        if ($searchrule['RateSearch']['user_defined_dependency2_id'] == 'Y' && isset($data['user_defined_dependency2_id']) && is_numeric($data['user_defined_dependency2_id'])) {
                            $options['rate.user_defined_dependency2_id'] = $data['user_defined_dependency2_id'];
                        }

                        $rates = $this->fetchTable('Rate')
                                        ->find()
                                        ->select(
                                                [
                                                    'rate.prop_rate', 'Unit.unit_desc_' . $lang,
                                                    'SubCatg.usage_sub_catg_desc_' . $lang,
                                                    'L1.level_1_desc_' . $lang,
                                                    'L1_List.list_1_desc_' . $lang,
                                                    'Zone.valuation_zone_desc_' . $lang,
                                                    'SubZone.from_desc_' . $lang,
                                                    'SubZone.to_desc_' . $lang,
                                                    'UlbClass.class_description_' . $lang,
                                                    'Ctype.construction_type_desc_' . $lang,
                                                    'Udd1.user_defined_dependency1_desc_' . $lang,
                                                    'Udd2.user_defined_dependency2_desc_' . $lang
                                                ]
                                        )
                                        ->join([
                                            'Unit' => [
                                                'table' => 'ngdrstab_mst_unit',
                                                'type' => 'LEFT',
                                                'conditions' => 'Unit.unit_id = Rate.prop_unit',
                                            ],
                                            'L1' => [
                                                'table' => 'ngdrstab_mst_location_levels_1_property',
                                                'type' => 'LEFT',
                                                'conditions' => 'L1.level_1_id = Rate.level1_id',
                                            ],
                                            'L1_List' => [
                                                'table' => 'ngdrstab_mst_loc_level_1_prop_list',
                                                'type' => 'LEFT',
                                                'conditions' => 'L1_List.prop_level1_list_id = Rate.level1_list_id',
                                            ],
                                            'SubCatg' => [
                                                'table' => 'ngdrstab_mst_usage_sub_category',
                                                'type' => 'LEFT',
                                                'conditions' => 'SubCatg.usage_sub_catg_id = Rate.usage_sub_catg_id',
                                            ],
                                            'Zone' => [
                                                'table' => 'ngdrstab_mst_valuation_zone',
                                                'type' => 'LEFT',
                                                'conditions' => 'Zone.valutation_zone_id = Rate.valutation_zone_id',
                                            ],
                                            'SubZone' => [
                                                'table' => 'ngdrstab_mst_valuation_subzone',
                                                'type' => 'LEFT',
                                                'conditions' => ['SubZone.valutation_subzone_id = Rate.valutation_subzone_id', 'subzone.usage_main_catg_id=rate.usage_main_catg_id', 'subzone.usage_sub_catg_id=rate.usage_sub_catg_id'],
                                            ],
                                            'Ctype' => [
                                                'table' => 'ngdrstab_mst_construction_type',
                                                'type' => 'LEFT',
                                                'conditions' => 'Ctype.construction_type_id = Rate.construction_type_id',
                                            ],
                                            'Udd1' => [
                                                'table' => 'ngdrstab_mst_user_def_depe1',
                                                'type' => 'LEFT',
                                                'conditions' => 'Udd1.user_defined_dependency1_id = Rate.user_defined_dependency1_id',
                                            ],
                                            'Udd2' => [
                                                'table' => 'ngdrstab_mst_user_def_depe2',
                                                'type' => 'LEFT',
                                                'conditions' => 'Udd2.user_defined_dependency2_id = Rate.user_defined_dependency2_id',
                                            ],
                                            'UlbClass' => [
                                                'table' => 'ngdrstab_conf_admblock_local_governingbody',
                                                'type' => 'LEFT',
                                                'conditions' => 'UlbClass.ulb_type_id = Rate.ulb_type_id',
                                            ]
                                        ])
                                        ->where($options)->toArray();
                        $response['allrates'][$searchrule->search_id] = $rates;
                        break;
                    }

                    $response['allfields']['Rate'] = true;
                    $response['allfields']['SubCatg'] = true;
                    $response['allfields']['Unit'] = true;
                    foreach ($response['allrates'] as $key => $value) {
                        foreach ($value as $key1 => $value1) {
                            $value1 = $value1->toArray();
                            if (!empty($value1['Ctype']['contruction_type_desc_' . $lang])) {
                                $response['allfields']['Ctype'] = true;
                            }
                            if (!empty($value1['Udd1']['user_defined_dependency1_desc_' . $lang])) {
                                $response['allfields']['Udd1'] = true;
                            }
                            if (!empty($value1['Udd2']['user_defined_dependency1_desc_' . $lang])) {
                                $response['allfields']['Udd2'] = true;
                            }
                            if (!empty($value1['L1']['level_1_desc_' . $lang])) {
                                $response['allfields']['L1'] = true;
                            }
                            if (!empty($value1['L1_List']['list_1_desc_' . $lang])) {
                                $response['allfields']['L1_List'] = true;
                            }
                            if (!empty($value1['L1_List']['list_1_desc_' . $lang])) {
                                $response['allfields']['L1_List'] = true;
                            }
                            if (!empty($value1['Zone']['valuation_zone_desc_' . $lang])) {
                                $response['allfields']['Zone'] = true;
                            }
                            if (!empty($value1['SubZone']['from_desc_' . $lang])) {
                                $response['allfields']['SubZone'] = true;
                            }
                            if (!empty($value1['UlbClass']['class_description_' . $lang])) {
                                $response['allfields']['UlbClass'] = true;
                            }
                        }
                    }
                } else {
                    $response['Error'] = 'Village Details Not Found';
                }
            } else {
                $response['Error'] = 'Village Not Selected';
            }
            echo json_encode($response);
            exit;
        } catch (Exception $ex) {
            echo $exc->getTraceAsString();
        }
    }

    public function add_finyear_details($param) {
        $subfinyear = $this->fetchTable('SubFinyear')
                ->find()
                ->select(['finyear_id', 'sub_finyear_id'])
                ->where(['valid_from <= ' => date('Y-m-d', strtotime($param['valuation_as_on_date'])), 'valid_to >= ' => date('Y-m-d', strtotime($param['valuation_as_on_date']))])
                ->toArray();
        if (!empty($subfinyear)) {
            $param['sub_finyear_id'] = $subfinyear['0']->sub_finyear_id;
            $param['finyear_id'] = $subfinyear['0']->finyear_id;
        } else {
            $param['sub_finyear_id'] = 0;
            $param['finyear_id'] = 0;
        }
        return $param;
    }

    public function getAttributeConfig() {
        try {
            $lang = $this->request->getSession()->read('Config.language');
            $response = array();
            $config = $this->get_valuation_config();
            $data = $this->request->getData();
            foreach ($config['AttributeDetails'] as $record) {
                if ($record['attribute_id'] == $data['attribute_id']) {
                    if (!empty($record['hissa1_en'])) {
                        $response['is_subpart_1_flag'] = true;
                        $response['subpart_1_desc'] = $record['hissa1_' . $lang];
                    } else {
                        $response['is_subpart_1_flag'] = false;
                    }
                    if (!empty($record['hissa2_en'])) {
                        $response['is_subpart_2_flag'] = true;
                        $response['subpart_2_desc'] = $record['hissa2_' . $lang];
                    } else {
                        $response['is_subpart_2_flag'] = false;
                    }

                    $response['is_master_flag'] = true;
                }
            }
            echo json_encode($response);
            exit;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function addPropertyAttribute() {
        $lang = $this->request->getSession()->read('Config.language');

        $data = $this->request->getData();
        $config = $this->get_valuation_config();
        $json2array = $this->_getValuationData();
        $response['Error'] = '';
        if (@$data['action'] == 'remove') {
            if ($data['type'] == 'S') {
                if (isset($json2array['prop_attributes_seller'][$data['attribute_index_id']])) {
                    unset($json2array['prop_attributes_seller'][$data['attribute_index_id']]);
                }
                $prop_attributes = $json2array['prop_attributes_seller'];
            }if ($data['type'] == 'P') {
                if (isset($json2array['prop_attributes_pur'][$data['attribute_index_id']])) {
                    unset($json2array['prop_attributes_pur'][$data['attribute_index_id']]);
                }
                $prop_attributes = $json2array['prop_attributes_pur'];
            }
        } else {
            if ($data['type'] == 'S') {
                if (isset($json2array['prop_attributes_seller'])) {
                    $prop_attributes = $json2array['prop_attributes_seller'];
                } else {
                    $prop_attributes = array();
                }
                if (isset($config['RegConfig'][601])) {
                    foreach ($prop_attributes as $key => $value) {
                        if ($data['attribute_id'] == $value['attribute_id']) {
                            unset($prop_attributes[$key]);
                        }
                    }
                }

                array_push($prop_attributes, array('attribute_id' => $data['attribute_id'], 'attribute_value' => $data['attribute_value'], 'attribute_value1' => $data['attribute_value1'], 'attribute_value2' => $data['attribute_value2']));
                $json2array['prop_attributes_seller'] = $prop_attributes;
            } else if ($data['type'] == 'P') {
                if (isset($json2array['prop_attributes_pur'])) {
                    $prop_attributes = $json2array['prop_attributes_pur'];
                } else {
                    $prop_attributes = array();
                }
                if (!empty($regconf_attr)) {
                    foreach ($prop_attributes as $key => $value) {
                        if ($data['attribute_id'] == $value['attribute_id']) {
                            unset($prop_attributes[$key]);
                        }
                    }
                }
                array_push($prop_attributes, array('attribute_id' => $data['attribute_id'], 'attribute_value' => $data['attribute_value'], 'attribute_value1' => $data['attribute_value1'], 'attribute_value2' => $data['attribute_value2']));
                $json2array['prop_attributes_pur'] = $prop_attributes;
            }
        }

        $this->_setValuationData($json2array);
        $this->set('prop_attributes', $prop_attributes);
        $this->set('AttributeDetails', $config['AttributeDetails']);
        $this->set('lang', $lang);
    }

    public function usageFilter() {
        $data = $this->request->getData();
        $json2array = $this->_getValuationData();
        echo json_encode($this->_getValuationRuleList($data, $json2array));
        exit;
    }

    public function _getValuationRuleList($data, $json2array) {
        $lang = $this->request->getSession()->read('Config.language');
        $conditions['display_flag'] = 'Y';
        if (isset($data['usage_main_id']) && is_numeric($data['usage_main_id'])) {
            $conditions['UsageCategory.usage_main_catg_id ='] = $data['usage_main_id'];
        }
        if (isset($data['usage_sub_id']) && is_numeric($data['usage_sub_id'])) {
            $conditions['UsageCategory.usage_sub_catg_id ='] = $data['usage_sub_id'];
        }
        if (isset($json2array['dtypes']) && is_numeric(key($json2array['dtypes']))) {
            // pr(key($json2array['dtypes']));   
        }

        if (isset($json2array['Form_Data']['district_id'])) {
            $mappingrules = $this->fetchTable('EvalruleMapping')->find('list', [
                                'keyField' => 'evalrule_id',
                                'valueField' => 'evalrule_id'])
                            ->where(['district_id =' => $json2array['Form_Data']['district_id']])->toArray();
        } else {
            $mappingrules = array();
        }

        $common_rule = $this->fetchTable('ValuationRule')->find("list",
                        [
                            'keyField' => 'evalrule_id',
                            'valueField' => 'evalrule_id'
                ])->where(['location_dependency_flag =' => 'N'])->toArray();

        $rules_ids = array_merge($mappingrules, $common_rule);

        $conditions['ValuationRule.evalrule_id IN'] = $rules_ids;

        $valuation_rule = $this->fetchTable('ValuationRule')->find("list",
                                [
                                    'keyField' => 'evalrule_id',
                                    'valueField' => 'evalrule_desc_' . $lang
                        ])
                        ->join([
                            'UsageCategory' => [
                                'table' => 'ngdrstab_mst_usage_category',
                                'type' => 'INNER',
                                'conditions' => 'UsageCategory.evalrule_id = ValuationRule.evalrule_id',
                            ]
                        ])
                        ->where(
                                $conditions
                        )->toArray();

        return $valuation_rule;
    }

    public function ruleChangeEvent() {
        $lang = $this->request->getSession()->read('Config.language');
        $data = $this->request->getData();
        $rules = explode(',', $data['evalrule_ids']);
        $ValuationRule = $this->fetchTable('ValuationRule')->find()
                        ->select(
                                [
                                    'ValuationRule.evalrule_id',
                                    'ValuationRule.evalrule_desc_' . $lang,
                                    'UsageCatg.contsruction_type_flag',
                                    'UsageCatg.depreciation_flag',
                                    'UsageCatg.road_vicinity_flag',
                                    'UsageCatg.user_defined_dependency1_flag',
                                    'UsageCatg.user_defined_dependency2_flag',
                                    'UsageCatg.usage_main_catg_id',
                                    'UsageCatg.usage_sub_catg_id',
                                    'ValuationRule.cmp_usage_main_catg_id',
                                    'ValuationRule.cmp_usage_sub_catg_id',
                                    'ValuationRule.add_usage_main_catg_id',
                                    'ValuationRule.add_usage_sub_catg_id',
                                    'ValuationRule.add1_usage_main_catg_id',
                                    'ValuationRule.add1_usage_sub_catg_id'
                        ])
                        ->join([
                            'UsageCatg' => [
                                'table' => 'ngdrstab_mst_usage_category',
                                'type' => 'INNER',
                                'conditions' => 'UsageCatg.evalrule_id = ValuationRule.evalrule_id',
                            ]
                        ])
                        ->where(['ValuationRule.evalrule_id IN ' => $rules])->toArray();

        $ValuationSubRule = $this->fetchTable('ValSubrule')->find()
                        ->select(
                                [
                                    'output_item_id',
                                    'ItemList.usage_param_desc_' . $lang,
                                    'ValSubrule.evalsubrule_cond1',
                                    'ValSubrule.evalsubrule_formula1',
                                    'ValSubrule.evalsubrule_cond2',
                                    'ValSubrule.evalsubrule_formula2',
                                    'ValSubrule.evalsubrule_cond3',
                                    'ValSubrule.evalsubrule_formula3',
                                    'ValSubrule.evalsubrule_cond4',
                                    'ValSubrule.evalsubrule_formula4',
                                    'ValSubrule.evalsubrule_cond5',
                                    'ValSubrule.evalsubrule_formula5',
                                    'max_value_condition_flag',
                                    'max_value_formula',
                                    'rate_revision_flag',
                                    'rate_revision_formula1',
                                    'rate_revision_formula2',
                                    'rate_revision_formula3',
                                    'rate_revision_formula4',
                                    'rate_revision_formula5',
                                    'min_value',
                                    'max_value'
                        ])
                        ->join([
                            'ItemList' => [
                                'table' => 'ngdrstab_mst_usage_items_list',
                                'type' => 'INNER',
                                'conditions' => 'ItemList.usage_param_id = ValSubrule.output_item_id',
                            ]
                        ])
                        ->where(['evalrule_id IN ' => $rules])->toArray();

        $ValuationRuleFields = $this->fetchTable('ItemList')->find()
                        ->select(
                                [
                                    'ItemList.usage_param_id',
                                    'ItemList.usage_param_desc_' . $lang,
                                    'ItemList.usage_param_code',
                                    'ItemList.area_field_flag',
                                    'ItemList.is_list_field_flag',
                                    'ItemList.item_rate_flag',
                                    'ItemList.area_type_flag',
                                    'ItemList.is_input_hidden',
                                    'ItemList.is_string',
                                    'ItemList.single_unit_flag',
                                    'ItemLink.evalrule_id',
                                    'ItemList.unit_cat_id',
                                    'ItemList.districtwise_unit_change_flag'
                        ])->join([
                    'ItemLink' => [
                        'table' => 'ngdrstab_mst_usage_lnk_category',
                        'type' => 'INNER',
                        'conditions' => 'ItemLink.usage_param_id = ItemList.usage_param_id',
                    ]
                ])->where(['ItemLink.evalrule_id IN ' => $rules])->toArray();

        $json2array = $this->_getValuationData();
        
        
        
        $json2array['ValuationRule'] = $ValuationRule;
        $json2array['ValuationSubRule'] = $ValuationSubRule;
        $json2array['ValuationRuleFields'] = $ValuationRuleFields;
        $this->_setValuationData($json2array);
        $this->set('json2array', $json2array);
        $this->set('lang', $lang);
    }

    //Un used
    public function districtApi() {

        pr($this->request->getData());

        pr($this->request->getHeader('Auth'));
        exit;
    }

    public function _propertyValuation(){
         pr($this->request->getData());
                
                
                exit;
    }
}
