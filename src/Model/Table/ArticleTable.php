<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;

class ArticleTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_article');
        $this->setPrimaryKey('article_id');
    }
    public function getarticle($lang){
        $getarticlelist = $this->find('list', [
                'keyField' => 'article_id',
                'valueField' => 'article_desc_'.$lang
            ])->where(['display_flag' => 'Y'])
              ->order(['article_desc_en' => 'ASC'])->toArray();
        return $getarticlelist;
    }
    public function fieldlist() {
        
        $fieldlist = array();
        $fieldlist['article']['article_desc_en']['select'] = 'is_required,is_alphanumspacecommaroundbrackets';
        $fieldlist['article']['article_code']['text'] = 'is_required,is_alphaspacedashdotcommacolonroundbrackets';
        $fieldlist['article']['display_order']['text'] = 'is_required,is_numeric';
        $fieldlist['article']['book_number']['text'] = 'is_required,is_alphanumeric';
        return $fieldlist;
    }
}

?>