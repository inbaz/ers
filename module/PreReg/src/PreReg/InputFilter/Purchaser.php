<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PreReg\InputFilter;

use Zend\InputFilter\Factory as InputFactory; 
use Zend\InputFilter\InputFilter; 
use Zend\InputFilter\InputFilterAwareInterface; 
use Zend\InputFilter\InputFilterInterface; 

class Purchaser implements InputFilterAwareInterface 
{ 
    protected $inputFilter; 
    protected $em;
    
    public function setEntityManager(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }
    public function getEntityManager() {
        return $this->em;
    }
    
    public function setInputFilter(InputFilterInterface $inputFilter) 
    { 
        throw new \Exception("Not used"); 
    } 
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) 
        { 
            $inputFilter = new InputFilter(); 
            $factory = new InputFactory();             
            
            $inputFilter->add($factory->createInput([ 
                'name' => 'purchaser_id', 
                'required' => true, 
                'filters' => array( 
                    array('name' => 'Int'), 
                ),
                'validators' => array(
                    array(
                        'name' => 'Callback',
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\Callback::INVALID_VALUE => 'To add a new purchaser please set firstname, surname and email.',
                            ),
                            'callback' => function($value, $context=array()) {
                                /*
                                 * If the purchaser_id is not 0 the user adds an 
                                 * already existing participant as purchaser.
                                 */
                                if($context['purchaser_id'] != 0) {
                                    return true;
                                }
                                
                                if($context['firstname'] != '' && $context['surname'] != '' && $context['email'] != '') {
                                    return true;
                                }
                                return false;
                            },
                            
                        ),
                    ),
                ),
            ]));
            
            $inputFilter->add($factory->createInput([ 
                'name' => 'firstname', 
                'required' => false, 
                'filters' => array( 
                    array('name' => 'StripTags'), 
                    array('name' => 'StringTrim'), 
                ), 
                'validators' => array(
                    array(
                        'name' => 'Callback',
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\Callback::INVALID_VALUE => 'The Firstname of the purchaser cannot be empty.',
                            ),
                            'callback' => function($value, $context=array()) {
                                /*
                                 * If the purchaser_id is not 0 the user adds an 
                                 * already existing participant as purchaser.
                                 */
                                if($context['purchaser_id'] != 0) {
                                    return true;
                                }
                                
                                if($value != '') {
                                    return true;
                                }
                                return false;
                            },
                            
                        ),
                    ),
                ), 
            ])); 

            $inputFilter->add($factory->createInput([ 
                'name' => 'surname', 
                'required' => false, 
                'filters' => array( 
                    array('name' => 'StripTags'), 
                    array('name' => 'StringTrim'), 
                ), 
                'validators' => array( 
                    array(
                        'name' => 'Callback',
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\Callback::INVALID_VALUE => 'The Surname of the purchaser cannot be empty.',
                            ),
                            'callback' => function($value, $context=array()) {
                                /*
                                 * If the purchaser_id is not 0 the user adds an 
                                 * already existing participant as purchaser.
                                 */
                                if($context['purchaser_id'] != 0) {
                                    return true;
                                }
                                
                                if($value != '') {
                                    return true;
                                }
                                return false;
                            },
                            
                        ),
                    ),
                ), 
            ])); 

            $inputFilter->add($factory->createInput([ 
                'name' => 'email', 
                'required' => false,
                'filters' => array( 
                    array('name' => 'StripTags'), 
                    array('name' => 'StringTrim'), 
                ), 
                'validators' => array( 
                    array(
                        'name' => 'Callback',
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\Callback::INVALID_VALUE => 'The email address of the purchaser cannot be empty.',
                            ),
                            'callback' => function($value, $context=array()) {
                                /*
                                 * If the purchaser_id is not 0 the user adds an 
                                 * already existing participant as purchaser.
                                 */
                                if($context['purchaser_id'] != 0) {
                                    return true;
                                }
                                
                                if($value != '') {
                                    
                                    return true;
                                }
                                return false;
                            },
                            
                        ),
                    ),
                    array ( 
                        'name' => 'EmailAddress', 
                        'options' => array( 
                            'messages' => array( 
                                'emailAddressInvalidFormat' => 'Email address format is not invalid', 
                            ) 
                        ), 
                    ), 
                    array ( 
                        'name' => 'NotEmpty', 
                        'options' => array( 
                            'messages' => array( 
                                'isEmpty' => '', 
                            ) 
                        ), 
                    ), 
                ), 
            ])); 
 
            $this->inputFilter = $inputFilter; 
        } 
        
        return $this->inputFilter; 
    } 
} 