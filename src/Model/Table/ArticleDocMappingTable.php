<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;

class ArticleDocMappingTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_article_document_mapping');
        $this->setPrimaryKey('article_doc_map_id');
    }
    
    public function getallrec($article_titlewise_map){
        
        if($article_titlewise_map=='Y')
        {
            $result = $this
            ->find()
            ->select(['ArticleDesc.articledescription_en','ArticleDocMapping.is_required', 'ArticleDocMapping.article_doc_map_id', 'ArticleDocMapping.article_id','ArticleDocMapping.document_id','ArticleDocMapping.id','Article.article_desc_en','UploadDocument.document_name_en'])
            ->join([
                'Article'=>  [
                    'table'      => 'ngdrstab_mst_article',                
                    'type'       => 'INNER',
                    'conditions' => 'ArticleDocMapping.article_id = Article.article_id',
                ],
                'ArticleDesc'=>  [      
                    'table'      => 'ngdrstab_mst_articledescriptiondetail',                
                    'type'       => 'INNER',
                    'conditions' => 'ArticleDocMapping.articledescription_id = ArticleDesc.articledescription_id',
                ],
                'UploadDocument'=>  [      
                    'table'      => 'ngdrstab_mst_upload_document',                
                    'type'       => 'INNER',
                    'conditions' => 'ArticleDocMapping.document_id = UploadDocument.document_id',
                ]
            ])
            ->order(['Article.article_desc_en' => 'ASC','UploadDocument.document_name_en'=>'ASC'])   
            ->toArray();
        }
        else{
            $result = $this
            ->find()
            ->select(['ArticleDocMapping.is_required', 'ArticleDocMapping.article_doc_map_id', 'ArticleDocMapping.article_id','ArticleDocMapping.document_id','ArticleDocMapping.id','Article.article_desc_en','UploadDocument.document_name_en'])
            ->join([
                'Article'=>  [
                    'table'      => 'ngdrstab_mst_article',                
                    'type'       => 'INNER',
                    'conditions' => 'ArticleDocMapping.article_id = Article.article_id',
                ],
                'UploadDocument'=>  [      
                    'table'      => 'ngdrstab_mst_upload_document',                
                    'type'       => 'INNER',
                    'conditions' => 'ArticleDocMapping.document_id = UploadDocument.document_id',
                ]
            ])
            ->order(['Article.article_desc_en' => 'ASC','UploadDocument.document_name_en'=>'ASC'])   
            ->toArray();
        }
        return $result;
    }
    public function fieldlist(){
        $fieldlist = array();
        $fieldlist['articledocumentmap']['article_id']['select'] = 'is_select_req';
        $fieldlist['articledocumentmap']['document_id']['select'] = 'is_select_req';
        
        return $fieldlist;
    }
}

?>