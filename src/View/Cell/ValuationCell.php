<?php

namespace App\View\Cell;

use Cake\View\Cell;

class ValuationCell extends Cell {

    public function UnitList($params) {
        $lang = $this->request->getSession()->read('Config.language');

        $conditions['UsageCatg.evalrule_id'] = $params['evalrule_id'];
        $conditions['Units.unit_cat_id'] = $params['unit_cat_id'];

        if ($params['single_unit_flag'] == 'Y') {
            $conditions['UnitMapping.usage_param_id'] = $params['usage_param_id'];
        }
        if ($params['districtwise_unit_change_flag'] == 'Y') {
            $conditions['UnitMapping.district_id'] = $params['district_id'];
        } 
        $this->set('UnitList', $this->fetchTable('Units')->find('list', [
                            'keyField' => 'unit_id',
                            'valueField' => 'unit_desc_' . $lang])
                        ->join([
                            'UnitMapping' => [
                                'table' => 'ngdrstab_mst_unit_mapping',
                                'type' => 'INNER',
                                'conditions' => 'UnitMapping.unit_id = Units.unit_id',
                            ],
                            'UsageCatg' => [
                                'table' => 'ngdrstab_mst_usage_category',
                                'type' => 'INNER',
                                'conditions' => ['UsageCatg.usage_main_catg_id = UnitMapping.usage_main_catg_id', 'UsageCatg.usage_sub_catg_id = UnitMapping.usage_sub_catg_id'],
                            ]
                        ])->where($conditions)
                        ->toArray());

        $this->set('name', $params['field_name']);
    }

    public function AreaTypeList($name) {
        $lang = $this->request->getSession()->read('Config.language');
        $this->set('AreaTypeList', $this->fetchTable('AreaType')->find('list', [
                    'keyField' => 'rate_built_area_type_id',
                    'valueField' => 'rate_built_area_type_desc_' . $lang])->toArray());
        $this->set('name', $name);
    }

}
