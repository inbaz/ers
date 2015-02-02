<?php   

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Form;

use Zend\Form\Form;


class ProductPriceForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('ProductPrice');

        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        
        $this->add(array(
            'name' => 'charge',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Charge',
            ),
        ));
        
        $this->add(array(
            'name' => 'limit',
            'type'  => 'Zend\Form\Element\Select',
            'attributes' => array(
                'required' => 'required', 
            ),
            'options' => array(
                'label' => 'Limit',
            ),
        ));
        
        $this->add(array(
            'name' => 'Product_id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary',
            ),
        ));
    }
}