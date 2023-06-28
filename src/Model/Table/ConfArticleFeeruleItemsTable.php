<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ConfArticleFeeruleItemsTable extends Table
{
    
    public function initialize(array $config): void
    {
        $this->setTable('ngdrstab_conf_article_feerule_items');
        $this->setPrimaryKey('article_rule_item_id');
    }
    
    public function gettrnarticledependentfeild($lang,$article, $token = null){
        if($article=='')
        {
            $article=68;
        }
        if ($token == null ) {
            $villageresult = $this->find()
                ->select(['Distinct ConfArticleFeeruleItems.fee_param_code','ArticleTrnFields.articledepfield_id','ArticleTrnFields.articledepfield_value' ,'ArticleFeeItems.fee_item_desc_'.$lang,'ArticleFeeItems.list_flag','ArticleFeeItems.fee_item_id','ArticleFeeItems.display_order','ArticleFeeItems.is_date'])
                ->join([
                    'ArticleFeeItems' => [
                        'table' => 'ngdrstab_mst_article_fee_items',
                        'type' => 'LEFT OUTER',
                        'conditions' => 'ConfArticleFeeruleItems.fee_param_code = ArticleFeeItems.fee_param_code',
                    ],
                    'ArticleTrnFields' => [
                        'table' => 'ngdrstab_trn_articledepfields',
                        'type' => 'LEFT OUTER',
                        'conditions' => 'ConfArticleFeeruleItems.fee_param_code = ArticleTrnFields.articledepfield_id',
                    ],
                ])
                ->where(['ArticleTrnFields.token_no is NULL','ConfArticleFeeruleItems.level1_flag =' => 'Y','ConfArticleFeeruleItems.article_id' => $article, 'ArticleFeeItems.gen_dis_flag' => 'Y'])
                ->order(['ArticleFeeItems.display_order' => 'ASC'])
                ->toArray();
        }else{
            $villageresult = $this->find()
                ->select(['Distinct ConfArticleFeeruleItems.fee_param_code','ArticleTrnFields.articledepfield_id','ArticleTrnFields.articledepfield_value' ,'ArticleFeeItems.fee_item_desc_'.$lang,'ArticleFeeItems.list_flag','ArticleFeeItems.fee_item_id','ArticleFeeItems.display_order','ArticleFeeItems.is_date'])
                ->join([
                    'ArticleFeeItems' => [
                        'table' => 'ngdrstab_mst_article_fee_items',
                        'type' => 'LEFT OUTER',
                        'conditions' => 'ConfArticleFeeruleItems.fee_param_code = ArticleFeeItems.fee_param_code',
                    ],
                    'ArticleTrnFields' => [
                        'table' => 'ngdrstab_trn_articledepfields',
                        'type' => 'LEFT OUTER',
                        'conditions' => 'ConfArticleFeeruleItems.fee_param_code = ArticleTrnFields.articledepfield_id',
                    ],
                ])
                ->where(['ArticleTrnFields.token_no is NULL','ConfArticleFeeruleItems.level1_flag =' => 'Y','ConfArticleFeeruleItems.article_id' => $article, 'ArticleFeeItems.gen_dis_flag' => 'Y','ArticleTrnFields.token_no' =>$token ])
                ->order(['ArticleFeeItems.display_order' => 'ASC'])
                ->toArray();
        }
        return $villageresult;
    }
}