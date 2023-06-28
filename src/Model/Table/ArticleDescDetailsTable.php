<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ArticleDescDetailsTable extends Table
{
    
    public function initialize(array $config): void
    {
        $this->setTable('ngdrstab_mst_articledescriptiondetail');
        $this->setPrimaryKey('articledescription_id');
    }
    public function fieldlist() {
        
        $fieldlist = array();
        $fieldlist['document_title']['article_id']['select'] = 'is_select_req';
        $fieldlist['document_title']['articledescription_en']['text'] = 'is_required,is_alphanumspacecommaroundbrackets';
        $fieldlist['document_title']['book_number']['text'] = 'is_alphanumeric';
        //$fieldlist['document_title']['articledescription_ll']['text'] = 'unicoderequired_rule_ll';
        
        return $fieldlist;
    }
}