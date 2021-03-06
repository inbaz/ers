<?php   

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Form;

use Zend\Form\Form;


class ProductVariantValue extends Form
{
    public function __construct()
    {
        parent::__construct('ProductVariantValue');

        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'position',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control form-element',
            ),
            'options' => array(
                'label' => 'Position',
                'label_attributes' => array(
                    'class'  => 'media-object',
                ),
            ),
        ));
        $this->add(array(
            'name' => 'value',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control form-element',
            ),
            'options' => array(
                'label' => 'Value',
                'label_attributes' => array(
                    'class'  => 'media-object',
                ),
            ),
        ));
        
        $this->add(array(
            'type' => 'checkbox',
            'name' => 'visible',
            'attributes' => array(
                'class' => 'checkbox',
            ),
            'options' => array(
                'label' => 'Visible',
                'label_attributes' => array(
                    'class'  => 'media-object',
                ),
            ),
        ));
        
        $this->add(array(
            'type' => 'checkbox',
            'name' => 'disabled',
            'attributes' => array(
                'class' => 'checkbox',
            ),
            'options' => array(
                'label' => 'Disabled',
                'label_attributes' => array(
                    'class'  => 'media-object',
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'ProductVariant_id',
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