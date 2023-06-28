<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;



class ApisController extends AppController
{
     
     public function beforeFilter(\Cake\Event\EventInterface $event) {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['test']);
  
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
       // $this->Authentication->addUnauthenticatedActions(['organizationLogin']);
//        $session = $this->request->getSession();
//        $session->renew();
    }
    /**
     * 
     * @param var the parameter 
     */
    public function test()
    {   

        pr($this->request->getData());
        pr($this->request->getHeader('User-Agent'));
         pr($this->request->getHeader('User-Agent'));
          pr($this->request->getHeader('Accept'));
        exit;
        
    }
    
    
    
}
