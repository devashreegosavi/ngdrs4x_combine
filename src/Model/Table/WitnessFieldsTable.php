<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class WitnessFieldsTable extends Table
{
    
    public function initialize(array $config): void
    {
        $this->setTable('ngdrstab_mst_witness_fields');
        $this->setPrimaryKey('field_id');
    }
    public function fieldlist($lang, $village_id = NULL) {

        $witnessfields = $this->find('all')
        ->where(['display_flag' => 'Y'])
        ->order(['order_data' => 'ASC'])
        ->toArray(); 

        //pr($witnessfields);
        foreach ($witnessfields as $field) {

            if ($field['is_list'] == 'N') {
                if (!empty($field['vrule_en'])) {
                    $returnfieldlist['witness_fields'][$field['field_id_name_en']]['text'] = $field['vrule_en'];
                }
            }
            else if($field['is_list'] == 'Y'){
                if (!empty($field['vrule_en'])){
                    $returnfieldlist['witness_fields'][$field['field_id_name_en']]['select'] = $field['vrule_en'];
                }
            }
        }
        //pr($returnfieldlist);exit;
        /*$fieldlist1 = array();
            foreach ($returnfieldlist as $key => $value) {
                if (isset($key) && $key != '') {

                    $fieldlist1[$key] = $value;
                }
            }
        pr($fieldlist1);exit;*/

        /// behavioral fields validation remaining

        return $returnfieldlist;   

    }
}