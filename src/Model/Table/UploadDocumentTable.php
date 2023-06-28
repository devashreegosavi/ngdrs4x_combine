<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

class UploadDocumentTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_upload_document');
        $this->setPrimaryKey('document_id');
    }
	
    public function getdoclist(){
        
        $getresult = $this->find()
                    ->order(['document_name_en' => 'ASC'])
                    ->toArray();        
       
        return $getresult;    
    }
    public function fieldlist($languagelist) {
        $fieldlist = array();
        $fieldlist['upload_document']['document_name_en']['text'] = 'is_required,is_alphanumspacedashdotslashroundbrackets';
        $fieldlist['upload_document']['file_size']['text'] = 'is_numeric';
        
        return $fieldlist;
    }
    
    public function getuploaddoc($lang){
        $getuploaddoclist = $this->find('list', [
                'keyField' => 'document_id',
                'valueField' => 'document_name_'.$lang
            ])->order(['document_name_'.$lang => 'ASC'])->toArray();
        return $getuploaddoclist;
    }

}

?>