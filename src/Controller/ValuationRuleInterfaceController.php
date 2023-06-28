<?php

namespace App\Controller;

use Cake\View\Cell;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Datasource\ConnectionManager;
use Cake\Http\ServerRequest;

class ValuationRuleInterfaceController extends AppController {

//Landing page of valuation rule
    public function rulelist() {
        try {

            $lang = $this->request->getSession()->read('Config.language');
            $this->set('lang', $lang);
            $NGDRSErrorCode = $this->fetchTable('NGDRSErrorCode')->NGDRSErrorCodelistdata($lang);
            $errorlistdata = $this->getTableLocator()->get('NGDRSErrorCode');
            $this->set('errorlistdata', $errorlistdata);
            $fieldlist = $this->fetchTable('Level1List')->fieldlist(); //Validation set in function
            $this->set('fieldlistmultiform', $fieldlist);
            $this->set('result_codes', $this->getvalidationruleset($fieldlist, TRUE));
            $ValuationRuleList = $this->fetchTable('ValuationRule')->find()->all();
            $this->set('ValuationRuleList', $ValuationRuleList);
        } catch (Exception $ex) {
            pr($ex);
            exit;
            echo $ex->getTraceAsString();
        }
    }

    public function valrule() {
        
    }

    public function valuationRule() {
        try {
            $lang = $this->request->getSession()->read('Config.language');
            $FinyearList = $this->fetchTable('FinYear')->FinYearListdata($lang);
            $MainCatglist = $this->fetchTable('UsageMainCategory')->UsageMainCategoryListdata($lang);
            $subcatlist = array();
            $Result = $this->fetchTable('UsageCategory')->find()->all();
            $Developmentlandtype = $this->fetchTable('DevelopLandType')->Developmentlandtypelistdata($lang);
            $Districtdata = $this->fetchTable('District')->Districtlistdata($lang);
            $MainLanguagedata = $this->fetchTable('MainLanguage')->MainLanguagelistdata($lang);
            $fieldlist = $this->fetchTable('EvalRule')->fieldlist($MainLanguagedata); //Validation set in function
            $this->set('fieldlistmultiform', $fieldlist);
            $this->set('result_codes', $this->getvalidationruleset($fieldlist, TRUE));
            $EvalRule = $this->fetchTable('EvalRule')->newEmptyEntity();
            $this->set(array('lang' => $lang, 'Result' => $Result, 'subcatlist' => $subcatlist, 'MainCatglist' => $MainCatglist, 'FinyearList' => $FinyearList, 'MainLanguagedata' => $MainLanguagedata, 'EvalRule' => $EvalRule, 'Developmentlandtype' => $Developmentlandtype, 'Districtdata' => $Districtdata));
            if ($this->request->is('post') || $this->request->is('put')) {
                $request_data = $this->request->getData();
                $errarr = $this->validatedata($request_data, $fieldlist['valuation_rule']); //Server side validation
                if ($this->ValidationError($errarr)) {
                    // pr($request_data);
                    $EvalRuledata = $this->fetchTable('EvalRule')->patchEntity($EvalRule, $request_data);
                    //   pr($EvalRuledata->toArray());
                    //  exit;
                    if ($this->fetchTable('EvalRule')->save($EvalRuledata)) {
                        $insertedId = $EvalRuledata->evalrule_id;
                        if (isset($insertedId) && is_numeric($insertedId)) {
                            $EvalRuleMapping = $this->getTableLocator()->get('EvalRuleMapping');
                            $EvalRuleMappingcloneData = [
                                'evalrule_id' => $insertedId,
                                'district_id' => $request_data['district_id'][0],
                            ];
                            $EvalRuleMappingclone = $EvalRuleMapping->newEntity($EvalRuleMappingcloneData);
                            $EvalRuleMappingDtypes = $this->getTableLocator()->get('EvalRuleMappingDtypes');
                            $EvalRuleMappingDtypescloneData = [
                                'evalrule_id' => $insertedId,
                                'developlandtype_id' => $request_data['developlandtype_id'][0],
                            ];
                            $EvalRuleMappingDtypesclone = $EvalRuleMappingDtypes->newEntity($EvalRuleMappingDtypescloneData);
                            if ($EvalRuleMapping->save($EvalRuleMappingclone) && $EvalRuleMappingDtypes->save($EvalRuleMappingDtypesclone)) {
                                $this->Flash->success(__('The Rule mapping and Rule mapping dtypes has been saved.'));
                                return $this->redirect('/ValuationRuleInterface/valuationRule');
                            }
                        }

                        

                        $this->Flash->success(__('Valuation Rule added  successfully.'));
                        return $this->redirect('/ValuationRuleInterface/valuationRule');
                    }
                    $this->Flash->error(__('Failed.'));
                }
                $this->Flash->error(__(' failed.'));
            }
        } catch (Exception $exc) {
            pr($exc);
            exit;
            echo $exc->getTraceAsString();
        }
    }

    public function getsubcatlist() {
        try {
            $lang = $this->request->getSession()->read('Config.language');
            $data = $this->request->getData();
            $usage_main_catg_id = $data['usage_main_catg_id'];
            if (is_numeric($usage_main_catg_id)) {
                $subcatlist = $this->fetchTable('UsageSubCategory')
                                ->find('list', [
                                    'keyField' => 'usage_sub_catg_id',
                                    'valueField' => 'usage_sub_catg_desc_' . $lang])
                                ->join(
                                        [
                                            'Usagelink' => [
                                                'table' => 'ngdrstab_mst_usage_category',
                                                'type' => 'LEFT',
                                                'conditions' => 'Usagelink.usage_sub_catg_id = UsageSubCategory.usage_sub_catg_id',
                                            ]
                                ])
                                ->where(['usage_main_catg_id' => $usage_main_catg_id])->toArray();
                echo json_encode($subcatlist);
                exit;
            }
        } catch (Exception $exc) {
            pr($exc);
            exit;
            echo $exc->getTraceAsString();
        }
    }

//valrule_itemlinkage.ctp
    public function valruleItemlinkage() {
        $lang = $this->request->getSession()->read('Config.language');
        $ItemList = $this->fetchTable('ItemList')->newEmptyEntity();
        $InputItemList = $this->fetchTable('ItemList')->InputItemListdata($lang);
        $OutputItemList = $this->fetchTable('ItemList')->OutputItemListdata($lang);
        $MainLanguagedata = $this->fetchTable('MainLanguage')->MainLanguagelistdata($lang);
        //pr($MainLanguagedata->toArray());exit;
        $fieldlist = $this->fetchTable('ItemLinkage')->fieldlist($MainLanguagedata);
        $this->set(array('InputItemList' => $InputItemList, 'OutputItemList' => $OutputItemList, 'ItemList' => $ItemList));
        if ($this->request->is('post') || $this->request->is('put')) {
            $request_data = $this->request->getData();

            // $errarr = $this->validatedata($request_data, $fieldlist['valrule_itemlinkage']); //Server side validation
            //     if ($this->ValidationError($errarr)) {
            //  if ($this->fetchTable('ItemLinkage')->save($EvalRuledata)) {
            //  }
            //   }
        }
    }

//valrule_subrule.ctp
    public function valruleSubrule() {
        try {

            $lang = $this->request->getSession()->read('Config.language');
            $OutputItemList = $this->fetchTable('ItemList')->OutputItemListdata($lang);
            $ValSubrule = $this->fetchTable('ValSubrule')->newEmptyEntity();
            $this->set(array('OutputItemList' => $OutputItemList, 'ValSubrule' => $ValSubrule));
        } catch (Exception $ex) {
            echo $ex->getTraceAsString();
        }
    }

    
    
    
}

?>