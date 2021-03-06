<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\InputFilter;

use Zend\InputFilter\Factory as InputFactory; 
use Zend\InputFilter\InputFilter; 
use Zend\InputFilter\InputFilterAwareInterface; 
use Zend\InputFilter\InputFilterInterface; 

class AcceptBuyerChange implements InputFilterAwareInterface 
{ 
    protected $inputFilter; 
    protected $serviceManager;
    
    public function setServiceLocator($serviceManager) {
        $this->sm = $serviceManager;
    }
    
    public function getServiceLocator() {
        return $this->sm;
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
                'name' => 'order_id', 
                'required' => true, 
                'filters' => array( 
                    array("name" => "Int"),
                ), 
                'validators' => array(
                    array ( 
                        'name' => 'Callback', 
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\Callback::INVALID_VALUE => 'It was not possible to find the order to change the buyer for.',
                            ),
                            'callback' => function($value, $context=array()) {
                                # check if order with the id of $value exists
                                if(!is_numeric($value)) {
                                    return false;
                                }
                
                                $entityManager = $this->getServiceLocator()
                                    ->get('Doctrine\ORM\EntityManager');
                                
                                $order = $entityManager->getRepository('ErsBase\Entity\Order')
                                    ->findOneBy(array('id' => $value));
                
                                if($order) {
                                    return true;
                                }
                                return false;
                            },
                            
                        ),
                    ),
                ), 
            ])); 
            
            $inputFilter->add($factory->createInput([ 
                'name' => 'user_id', 
                'required' => true, 
                'filters' => array( 
                    array("name" => "Int"),
                ), 
                'validators' => array(
                    array ( 
                        'name' => 'Callback', 
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\Callback::INVALID_VALUE => 'It was not possible to find the user that should be set as buyer.',
                            ),
                            'callback' => function($value, $context=array()) {
                                # check if user with the id of $value exists
                                if(!is_numeric($value)) {
                                    return false;
                                }
                
                                $entityManager = $this->getServiceLocator()
                                    ->get('Doctrine\ORM\EntityManager');
                                
                                $user = $entityManager->getRepository('ErsBase\Entity\User')
                                    ->findOneBy(array('id' => $value));
                
                                if($user) {
                                    return true;
                                }
                                return false;
                            },
                            
                        ),
                    ),
                ), 
            ])); 

            $inputFilter->add($factory->createInput([ 
                'name' => 'comment', 
                'required' => true, 
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ), 
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                    ),
                ), 
            ])); 
                            
            $this->inputFilter = $inputFilter; 
        } 
        
        return $this->inputFilter; 
    }
} 