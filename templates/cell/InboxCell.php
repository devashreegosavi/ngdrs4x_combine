<?php
namespace App\View\Cell;

use Cake\View\Cell;

class InboxCell extends Cell
{
    public function display()
    {
        $unread = $this->fetchTable('Users')->find();
        $this->set('unread_count', $unread->count());
    }
}