<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class IdentificationFieldsTable extends Table
{
    
    public function initialize(array $config): void
    {
        $this->setTable('ngdrstab_mst_identifire_fields');
        $this->setPrimaryKey('id');
    }
 
    public function fieldlist($lang, $village_id = NULL) {

        $identifierfields = $this->find('all')
        ->where(['display_flag' => 'Y'])
        ->toArray(); 

        //pr($witnessfields);
        foreach ($identifierfields as $field) {

            if ($field['is_list'] == 'N') {
                if (!empty($field['vrule_en'])) {
                    $returnfieldlist['identifier_fields'][$field['field_id_name_en']]['text'] = $field['vrule_en'];
                }
            }
            else if($field['is_list'] == 'Y'){
                if (!empty($field['vrule_en'])){
                    $returnfieldlist['identifier_fields'][$field['field_id_name_en']]['select'] = $field['vrule_en'];
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