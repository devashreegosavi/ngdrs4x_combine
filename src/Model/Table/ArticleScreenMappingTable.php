<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ArticleScreenMappingTable extends Table
{
    
    public function initialize(array $config): void
    {
        $this->setTable('ngdrstab_mst_article_screen_mapping');
        $this->setPrimaryKey('id');
    }
    public function getallartscreenrec(){
        $result = $this
        ->find()
        ->select(['ArticleScreenMapping.article_id','ArticleScreenMapping.minorfun_id','ArticleScreenMapping.id','Article.article_desc_en','MinorFunction.function_desc_en'])
        ->join([
            'Article'=>  [
                'table'      => 'ngdrstab_mst_article',                
                'type'       => 'INNER',
                'conditions' => 'ArticleScreenMapping.article_id = Article.article_id',
            ],
            'MinorFunction'=>  [      
                'table'      => 'ngdrstab_mst_minorfunctions',                
                'type'       => 'INNER',
                'conditions' => 'ArticleScreenMapping.minorfun_id = MinorFunction.minor_id',
            ]
        ])
        ->order(['Article.article_desc_en' => 'ASC','MinorFunction.function_desc_en'=>'ASC'])   
        ->toArray();
        return $result;
    }
    public function fieldlist(){
        $fieldlist = array();
        $fieldlist['articlescreenmap']['article_id']['select'] = 'is_select_req';
        $fieldlist['articlescreenmap']['minor_id']['select'] = 'is_select_req';
        
        return $fieldlist;
    }
}