<?php   

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OnsiteReg\Form;

use Zend\Form\Form;


class UndoItem extends Form
{
    public function __construct()
    {
        parent::__construct('UndoItems');
        $this->setAttribute('method', 'post');
        
        $this->add(array( 
            'name' => 'csrf', 
            'type' => 'Zend\Form\Element\Csrf', 
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Confirm',
                'class' => 'btn btn-lg btn-danger',
            ),
        ));
    }
}
