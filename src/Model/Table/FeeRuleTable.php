<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;

class FeeRuleTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_article_fee_rule');
        $this->setPrimaryKey('fee_rule_id');
    }
    
    public function fieldlist() {    
        $fieldlist['FeeRule']['finyear_id']['select'] = 'is_select_req'; 
        $fieldlist['FeeRule']['effective_date']['text'] = 'is_required';
        $fieldlist['FeeRule']['reference_no']['text'] = 'is_alphanumspacecommasqrroundbrackets';
        $fieldlist['FeeRule']['article_id']['select'] = 'is_select_req';        
        $fieldlist['FeeRule']['fee_rule_desc_en']['text'] = 'is_required,is_alphanumericspace,is_maxlength100';       
        return $fieldlist;
    }
}

?>