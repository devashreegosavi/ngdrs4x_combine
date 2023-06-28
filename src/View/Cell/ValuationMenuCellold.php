<?php
namespace App\View\Cell;

use Cake\View\Cell;

class ValuationMenuCell extends Cell
{
    public function display()
    {
        $unread = $this->fetchTable('Users')->find()->toArray();
        $this->set('unread_count', $unread);
    }
}