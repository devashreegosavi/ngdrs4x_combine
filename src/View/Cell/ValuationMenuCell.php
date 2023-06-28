<?php
// declare(strict_types=1);
namespace App\View\Cell;


use Cake\View\Cell;

class ValuationMenuCell extends Cell {

    //-----------------------------------------------Display Menu of Rule----------------------------------------------
    public function Valrulemenu() {
        // try {
            // $this->autoRender = false;
            $result = $this->fetchTable('ValuationRuleMenu')->find()->order(['mf_serial' => 'ASC'])->toArray();
            // $result = $this->fetchTable('Users')->find()->toArray();
            $this->set('result',$result); 
        // } catch (Exception $ex) {
        //     $this->Session->setFlash('Sorry! Error Getting Data');
        // }
    }

}
