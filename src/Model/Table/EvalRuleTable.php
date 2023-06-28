<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;

class EvalRuleTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_evalrule_new');
        $this->setPrimaryKey('evalrule_id');
    }

    public function fieldlist($MainLanguagedata) {
        $fieldlist['valuation_rule']['fin_year']['select'] = 'is_required';
        $fieldlist['valuation_rule']['effective_date']['select'] = 'is_required';
        $fieldlist['valuation_rule']['reference_no']['text'] = 'is_required';
        $fieldlist['valuation_rule']['usage_main_catg_id']['select'] = 'is_required';
        $fieldlist['valuation_rule']['usage_sub_catg_id']['select'] = 'is_required';
        $fieldlist['valuation_rule']['evalrule_desc_en']['text'] = 'is_required';
        $fieldlist['valuation_rule']['location_dependency_flag']['select'] = 'is_required';
 //       $fieldlist['valuation_rule']['district_id']['checkbox'] = 'is_required';
        foreach ($MainLanguagedata as $languagecode) {
            if ($languagecode['language_code'] == 'en') {
                $fieldlist['valuation_rule']['evalrule_desc_' . $languagecode['language_code']]['text'] = 'is_required,is_alphaspace,is_maxlength50';
            } else {
                $fieldlist['valuation_rule']['evalrule_desc_' . $languagecode['language_code']]['text'] = "unicode_rule_" . $languagecode['language_code'] . ',maxlength_unicode_0to50';
            }
        }
        $fieldlist['valuation_rule']['additional_rate_flag']['select'] = 'is_required';
        $fieldlist['valuation_rule']['additional1_rate_flag']['select'] = 'is_required';
        $fieldlist['valuation_rule']['rate_compare_flag']['select'] = 'is_required';
        $fieldlist['valuation_rule']['contsruction_type_flag']['select'] = 'is_required';
        $fieldlist['valuation_rule']['depreciation_flag']['select'] = 'is_required';
        $fieldlist['valuation_rule']['road_vicinity_flag']['select'] = 'is_required';
        $fieldlist['valuation_rule']['user_defined_dependency1_flag']['select'] = 'is_required';
        $fieldlist['valuation_rule']['user_defined_dependency2_flag']['select'] = 'is_required';
        $fieldlist['valuation_rule']['add_usage_main_catg_id']['select'] = 'is_required';
        $fieldlist['valuation_rule']['add_usage_sub_catg_id']['select'] = 'is_required';
        $fieldlist['valuation_rule']['add1_usage_main_catg_id']['select'] = 'is_required';
        $fieldlist['valuation_rule']['add1_usage_sub_catg_id']['select'] = 'is_required';
        $fieldlist['valuation_rule']['cmp_usage_main_catg_id']['select'] = 'is_required';
        $fieldlist['valuation_rule']['cmp_usage_sub_catg_id']['select'] = 'is_required';
     //   $fieldlist['valuation_rule']['developlandtype_id']['checkbox'] = 'is_required';
        return $fieldlist;
    }

}

?>