<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Model\Entity;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\Db\Sql\Where;

#class Product extends Entity {
class Product2 extends ServiceLocatorAwareEntity {
    protected $id;
    protected $order;
    protected $Tax_id;
    protected $name;
    protected $shortDescription;
    protected $longDescription;
    protected $personalized;
    protected $variants;
    protected $price;
    protected $prices;
    
    protected $inputFilter;


    public function __construct(array $options = null) {
        parent::__construct($options);
    }
    
    public function __sleep() {
        return array(
            'id',
            'order',
            'Tax_id',
            'name',
            'shortDescription',
            'longDescription',
            'personalized',
            'variants',
            'price',
            'prices',
            'updated',
            'created',
        );
    }
    
    public function exchangeArray($data)
    {
        foreach($data as $k => $v) {
            if(property_exists(get_class($this), $k)) {
                $this->$k = $v;
            } else {
                if($k == 'Product_id') {
                    $this->id = $v;
                    continue;
                }
                error_log('ERROR: I do not know what to do with '.$k.' ('.$v.')');
            }
        }
        parent::exchangeArray($data);
    }
    
    public function isPersonalized() {
        if($this->personalized == 1) {
            return true;
        } else {
            return false;
        }
    }


    public function setVariants($data) {
        
        #foreach($data as $variant) {
        #    $this->addVariantValue($variant['name'], $variant['value']);
        #}
        $this->variants = $data;
    }
    
    public function getVariants() {
        return $this->variants;
    }
    
    public function setPrice(ProductPrice $Price) {
        $this->price = $Price;
    }
    
    public function getPrice() {
        return $this->price;
    }
    
    public function setPrices($Prices) {
        $this->prices = $Prices;
    }
    
    public function getPrices() {
        return $this->prices;
    }
    
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'name',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'displayName',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'Tax_id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'Digits',
                    ),
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}