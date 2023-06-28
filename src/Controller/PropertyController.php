<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PropertyController extends ValuationController {

    public function propertyValuation() {
        $config = $this->get_valuation_config();

        $fieldlist = $this->fetchTable('Valuation')->fieldlist($config);
        $this->set('fieldlistmultiform', $fieldlist = $this->fetchTable('Valuation')->fieldlist($config));
        $this->set('result_codes', $this->getvalidationruleset($fieldlist, TRUE));

        if ($this->request->is('post')) {
            $errarr = $this->validatedata($this->request->getData(), $fieldlist['propertyValuation']);
            if ($this->ValidationError($errarr)) {
               $this->_propertyValuation();
            }
        }
        //get required initial data for valuation form
        $this->valuation_initialize($config);
    }

   

}
