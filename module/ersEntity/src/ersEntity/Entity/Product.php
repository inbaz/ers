<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ersEntity\Entity;
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

/** 
 * @ORM\Entity 
 * @ORM\HasLifecycleCallbacks()
 */
class Product {
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    protected $id;

    /** @ORM\Column(type="integer", nullable=true) */
    protected $ordering;
    
    /** @ORM\Column(type="integer") */
    protected $Tax_id;

    /** @ORM\Column(type="string", length=32) */
    protected $name;
    
    /** @ORM\Column(type="string", length=100) */
    protected $shortDescription;
    
    /** @ORM\Column(type="string", length=1000) */
    protected $longDescription;
    
    /** @ORM\Column(type="boolean") */
    protected $personalized;
    
    /** @ORM\Column(type="boolean") */
    protected $active = 1;
    
    /** @ORM\Column(type="datetime") */
    protected $modified;
    
    /** @ORM\Column(type="datetime") */
    protected $created;
    
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function PrePersist()
    {
        $this->setCreated(new \DateTime());
        $this->setModified(new \DateTime());
    }
    
    // other variables
    
    /**
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="subProducts")
     **/
    private $inProducts;

    /**
     * @ORM\ManyToMany(targetEntity="Product", inversedBy="inProducts")
     * @ORM\JoinTable(name="ProductPackage",
     *      joinColumns={@ORM\JoinColumn(name="Product_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="SubProduct_id", referencedColumnName="id")}
     *      )
     **/
    private $subProducts;
    
    /**
     * @ORM\OneToMany(targetEntity="ProductVariant", mappedBy="product")
     **/
    protected $variants;
    
    /**
     * @ORM\OneToMany(targetEntity="ProductPrice", mappedBy="product")
     **/
    protected $prices;
    
    /**
     * @ORM\ManyToOne(targetEntity="Tax", inversedBy="products")
     * @ORM\JoinColumn(name="Tax_id", referencedColumnName="id")
     **/
    private $tax;
    
    protected $price;
    
    protected $inputFilter;
    
    
    public function __construct() {
        $this->variants = array();
        $this->prices = array();
    }
    
    public function __clone() {
        $this->setId(null);
    }
    
    public function exchangeArray($data)
    {
        foreach($data as $k => $v) {
            if(property_exists(get_class($this), $k)) {
                $this->$k = $v;
            } else {
                /*if($k == 'Product_id') {
                    error_log(get_class().': set Product_id to id');
                    $this->id = $v;
                    continue;
                }*/
                error_log('ERROR: I do not know what to do with '.$k.' ('.$v.')');
            }
        }
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
    // getters/setters
    
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }
    
    public function setCreated($datetime) {
        if(!isset($this->created)) {
            $this->created = $datetime;
        }
    }
    public function setModified($datetime) {
        $this->modified = $datetime;
    }
    
    public function getOrder() {
        return $this->ordering;
    }
    public function setOrder($order) {
        $this->ordering = $order;
    }
    
    public function getTaxId() {
        return $this->Tax_id;
    }
    public function setTaxId($id) {
        $this->Tax_id = $id;
    }
    
    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        $this->name = $name;
    }
    
    public function getShortDescription() {
        return $this->shortDescription;
    }
    public function setShortDescription($desc) {
        $this->shortDescription = $desc;
    }
    
    public function getLongDescription() {
        return $this->longDescription;
    }
    public function setLongDescription($desc) {
        $this->longDescription = $desc;
    }
    
    public function isPersonalized() {
        if($this->personalized == 1) {
            return true;
        } else {
            return false;
        }
    }
    public function setPersonalized($personalized) {
        switch($personalized) {
            case 1:
            case 'yes':
            case 'y':
            case 'Y':
                $this->personalized = 1;
                break;
            case 0:
            case 'no':
            case 'n':
            case 'N':
                $this->personalized = 0;
                break;
        }
    }
    
    public function isActive() {
        if($this->active == 1) {
            return true;
        } else {
            return false;
        }
    }
    public function setActive($active) {
        switch($active) {
            case 1:
            case 'yes':
            case 'y':
            case 'Y':
                $this->active = 1;
                break;
            case 0:
            case 'no':
            case 'n':
            case 'N':
                $this->active = 0;
                break;
        }
    }
    
    public function getVariants() {
        return $this->variants;
    }
    public function setVariants($variants) {
        foreach($variants as $variant) {
            $this->addVariant($variant);
        }
    }
    public function addVariant(ProductVariant $variant) {
        $this->variants[] = $variant;
    } 
    
    public function getPrices() {
        return $this->prices;
    }
    public function setPrices($prices) {
        foreach($prices as $price) {
            $this->addPrice($price);
        }
    }
    public function addPrice(ProductPrice $price) {
        $this->prices[] = $price;
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
                'name'     => 'shortDescription',
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
                'name'     => 'longDescription',
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