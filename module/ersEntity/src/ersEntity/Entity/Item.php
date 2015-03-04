<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-zf2inputfilterannotation) on 2015-02-02
 * 21:38:10.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace ersEntity\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * Entity\Item
 *
 * @ORM\Entity()
 * @ORM\Table(name="Item", indexes={
 *   @ORM\Index(name="fk_Item_Product1_idx", columns={"Product_id"}), 
 *   @ORM\Index(name="fk_Item_Package1_idx", columns={"Package_id"}), 
 *   @ORM\Index(name="fk_Item_Code1_idx", columns={"Code_id"})
 * })
 * @ORM\HasLifecycleCallbacks()
 */
class Item implements InputFilterAwareInterface
{
    /**
     * Instance of InputFilterInterface.
     *
     * @var InputFilter
     */
    private $inputFilter;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     *
     * @var int
     * variable to keep an id which is only used while this entity is hold in 
     * a session container.
     */
    protected $session_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $Product_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $Package_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $Code_id;

    /**
     * @ORM\Column(name="`name`", type="string", length=45, nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    protected $shortDescription;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $longDescription;

    /**
     * @ORM\Column(type="string", length=45)
     */
    protected $price;

    /**
     * @ORM\Column(type="string", length=45)
     */
    protected $amount;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    protected $info;

    /**
     * @ORM\Column(name="`status`", type="string", nullable=true)
     */
    protected $status;
    
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $personalized;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\OneToMany(targetEntity="ItemVariant", mappedBy="item")
     * @ORM\JoinColumn(name="id", referencedColumnName="Item_id")
     */
    protected $itemVariants;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="items")
     * @ORM\JoinColumn(name="Product_id", referencedColumnName="id", nullable=true)
     */
    protected $product;

    /**
     * @ORM\ManyToOne(targetEntity="Package", inversedBy="items")
     * @ORM\JoinColumns({@ORM\JoinColumn(name="Package_id", referencedColumnName="id")
     * })
     */
    protected $package;

    /**
     * @ORM\OneToOne(targetEntity="Code", inversedBy="item", cascade={"persist"})
     * @ORM\JoinColumn(name="Code_id", referencedColumnName="id")
     */
    protected $code;

    public function __construct()
    {
        $this->session_id = null;
        $this->itemVariants = new ArrayCollection();
    }
    
    /**
     * @ORM\PrePersist
     */
    public function PrePersist()
    {
        if(!isset($this->created)) {
            $this->created = new \DateTime();
        }
        $this->updated = new \DateTime();
    }
    
    /**
     * Set id of this object to null if it's cloned
     */
    public function __clone() {
        $this->id = null;
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \Entity\Item
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Get session_id
     * 
     * @return int
     */
    public function getSessionId()
    {
        return $this->session_id;
    }
    
    /**
     * Set session_id.
     *
     * @param int $id
     *
     * @return void
     */
    public function setSessionId($id) {
        $this->session_id = $id;
    }

    /**
     * Set the value of Product_id.
     *
     * @param integer $Product_id
     * @return \Entity\Item
     */
    public function setProductId($Product_id)
    {
        $this->Product_id = $Product_id;

        return $this;
    }

    /**
     * Get the value of Product_id.
     *
     * @return integer
     */
    public function getProductId()
    {
        return $this->Product_id;
    }

    /**
     * Set the value of Package_id.
     *
     * @param integer $Package_id
     * @return \Entity\Item
     */
    public function setPackageId($Package_id)
    {
        $this->Package_id = $Package_id;

        return $this;
    }

    /**
     * Get the value of Package_id.
     *
     * @return integer
     */
    public function getPackageId()
    {
        return $this->Package_id;
    }

    /**
     * Set the value of Code_id.
     *
     * @param integer $Code_id
     * @return \Entity\Item
     */
    public function setCodeId($Code_id)
    {
        $this->Code_id = $Code_id;

        return $this;
    }

    /**
     * Get the value of Code_id.
     *
     * @return integer
     */
    public function getCodeId()
    {
        return $this->Code_id;
    }

    /**
     * Set the value of name.
     *
     * @param string $name
     * @return \Entity\Item
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of shortDescription.
     *
     * @param string $shortDescription
     * @return \Entity\Item
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * Get the value of shortDescription.
     *
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * Set the value of longDescription.
     *
     * @param string $longDescription
     * @return \Entity\Item
     */
    public function setLongDescription($longDescription)
    {
        $this->longDescription = $longDescription;

        return $this;
    }

    /**
     * Get the value of longDescription.
     *
     * @return string
     */
    public function getLongDescription()
    {
        return $this->longDescription;
    }

    /**
     * Set the value of price.
     *
     * @param string $price
     * @return \Entity\Item
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of price.
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of amount.
     *
     * @param string $amount
     * @return \Entity\Item
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the value of amount.
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of info.
     *
     * @param string $info
     * @return \Entity\Item
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Get the value of info.
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set the value of status.
     *
     * @param string $status
     * @return \Entity\Item
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of personalized.
     *
     * @param boolean $personalized
     * @return \Entity\Product
     */
    public function setPersonalized($personalized)
    {
        $this->personalized = $personalized;
        
        return $this;
    }

    /**
     * Get the value of personalized.
     *
     * @return boolean
     */
    public function getPersonalized()
    {
        return $this->personalized;
    }
    
    /**
     * Set the value of updated.
     *
     * @param datetime $updated
     * @return \Entity\Item
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get the value of updated.
     *
     * @return datetime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set the value of created.
     *
     * @param datetime $created
     * @return \Entity\Item
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get the value of created.
     *
     * @return datetime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Add ItemVariant entity to collection (one to many).
     *
     * @param \Entity\ItemVariant $itemVariant
     * @return \Entity\Item
     */
    public function addItemVariant(ItemVariant $itemVariant)
    {
        $this->itemVariants[] = $itemVariant;

        return $this;
    }

    /**
     * Remove ItemVariant entity from collection (one to many).
     *
     * @param \Entity\ItemVariant $itemVariant
     * @return \Entity\Item
     */
    public function removeItemVariant(ItemVariant $itemVariant)
    {
        $this->itemVariants->removeElement($itemVariant);

        return $this;
    }

    /**
     * Get ItemVariant entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItemVariants()
    {
        return $this->itemVariants;
    }

    /**
     * Set Product entity (many to one).
     *
     * @param \Entity\Product $product
     * @return \Entity\Item
     */
    public function setProduct(Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get Product entity (many to one).
     *
     * @return \Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set Package entity (many to one).
     *
     * @param \Entity\Package $package
     * @return \Entity\Item
     */
    public function setPackage(Package $package = null)
    {
        $this->package = $package;

        return $this;
    }

    /**
     * Get Package entity (many to one).
     *
     * @return \Entity\Package
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * Set Code entity (one to one).
     *
     * @param \Entity\Code $code
     * @return \Entity\Item
     */
    public function setCode(Code $code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get Code entity (one to one).
     *
     * @return \Entity\Code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Not used, Only defined to be compatible with InputFilterAwareInterface.
     * 
     * @param \Zend\InputFilter\InputFilterInterface $inputFilter
     * @throws \Exception
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used.");
    }

    /**
     * Return a for this entity configured input filter instance.
     *
     * @return InputFilterInterface
     */
    public function getInputFilter()
    {
        if ($this->inputFilter instanceof InputFilterInterface) {
            return $this->inputFilter;
        }
        $factory = new InputFactory();
        $filters = array(
            array(
                'name' => 'id',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
            ),
            array(
                'name' => 'Product_id',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            array(
                'name' => 'Package_id',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
            ),
            array(
                'name' => 'Code_id',
                'required' => true,
                'filters' => array(),
                'validators' => array(),
            ),
            array(
                'name' => 'name',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            array(
                'name' => 'shortDescription',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            array(
                'name' => 'longDescription',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            array(
                'name' => 'price',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            array(
                'name' => 'amount',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            array(
                'name' => 'info',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            array(
                'name' => 'status',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            array(
                'name' => 'updated',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            array(
                'name' => 'created',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
        );
        $this->inputFilter = $factory->createInputFilter($filters);

        return $this->inputFilter;
    }

    /**
     * Populate entity with the given data.
     * The set* method will be used to set the data.
     *
     * @param array $data
     * @return boolean
     */
    public function populate(array $data = array())
    {
        foreach ($data as $field => $value) {
            $setter = sprintf('set%s', ucfirst(
                str_replace(' ', '', ucwords(str_replace('_', ' ', $field)))
            ));
            if (method_exists($this, $setter)) {
                $this->{$setter}($value);
            }
        }

        return true;
    }

    /**
     * Return a array with all fields and data.
     * Default the relations will be ignored.
     * 
     * @param array $fields
     * @return array
     */
    public function getArrayCopy(array $fields = array())
    {
        $dataFields = array('id', 'session_id', 'Product_id', 'Package_id', 'Code_id', 'name', 'shortDescription', 'longDescription', 'price', 'amount', 'info', 'status', 'personalized', 'updated', 'created');
        $relationFields = array('product', 'package', 'code');
        $copiedFields = array();
        foreach ($relationFields as $relationField) {
            $map = null;
            if (array_key_exists($relationField, $fields)) {
                $map = $fields[$relationField];
                $fields[] = $relationField;
                unset($fields[$relationField]);
            }
            if (!in_array($relationField, $fields)) {
                continue;
            }
            $getter = sprintf('get%s', ucfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $relationField)))));
            $relationEntity = $this->{$getter}();
            $copiedFields[$relationField] = (!is_null($map))
                ? $relationEntity->getArrayCopy($map)
                : $relationEntity->getArrayCopy();
            $fields = array_diff($fields, array($relationField));
        }
        foreach ($dataFields as $dataField) {
            if (!in_array($dataField, $fields) && !empty($fields)) {
                continue;
            }
            $getter = sprintf('get%s', ucfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $dataField)))));
            $copiedFields[$dataField] = $this->{$getter}();
        }

        return $copiedFields;
    }

    public function __sleep()
    {
        return array('id', 'session_id', 'Product_id', 'Package_id', 'Code_id', 'name', 'shortDescription', 'longDescription', 'price', 'amount', 'info', 'status', 'personalized', 'updated', 'created');
    }
}