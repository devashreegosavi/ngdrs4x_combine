<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class GeneralinformationTable extends Table
{
    
    public function initialize(array $config): void
    {
        $this->setTable('ngdrstab_trn_generalinformation');
        $this->setPrimaryKey('general_info_id');
    }
    
    
    public function fieldlist() {
        $fieldlist['generalinfoEntry']['article_id']['select'] = 'is_select_req'; 
        $fieldlist['generalinfoEntry']['no_of_pages']['text'] = 'is_required';    
        return $fieldlist;
    }
}