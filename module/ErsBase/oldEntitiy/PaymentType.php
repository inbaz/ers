<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-zf2inputfilterannotation) on 2015-02-02
 * 21:38:10.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace ErsBase\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * Entity\PaymentType
 *
 * @ORM\Entity()
 * @ORM\Table(name="PaymentType")
 * @ORM\HasLifecycleCallbacks()
 */
class PaymentType implements InputFilterAwareInterface
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
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $ordering;
    
    /**
     * @ORM\Column(name="`name`", type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $logo;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $shortDescription;

    /**
     * @ORM\Column(type="string", length=3000, nullable=true)
     */
    protected $longDescription;

    /**
     * @ORM\Column(type="string", length=3000, nullable=true)
     */
    protected $explanation;
    
    /**
     * @ORM\Column(type="float")
     */
    protected $fixFee = 0;

    /**
     * @ORM\Column(type="float")
     */
    protected $percentageFee = 0;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $activeFrom_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $activeUntil_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $days2pay = 0;
    
    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $type;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $visible;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;
    
    /**
     * @ORM\ManyToOne(targetEntity="Deadline")
     * @ORM\JoinColumn(name="activeFrom_id", referencedColumnName="id", nullable=true)
     */
    protected $activeFrom;

    /**
     * @ORM\ManyToOne(targetEntity="Deadline")
     * @ORM\JoinColumn(name="activeUntil_id", referencedColumnName="id", nullable=true)
     */
    protected $activeUntil;
    
    /**
     * @ORM\OneToMany(targetEntity="Order", mappedBy="paymentType", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="id", referencedColumnName="PaymentType_id")
     */
    protected $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
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
     * @ORM\PreUpdate
     */
    public function PreUpdate()
    {
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
     * @return \Entity\PaymentType
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
     * Set the value of order.
     *
     * @param integer $order
     * @return \Entity\ProductVariant
     */
    public function setOrder($order)
    {
        if($order == 0) {
            $this->ordering = null;
        } else {
            $this->ordering = $order;
        }
        
        return $this;
    }
    public function setOrdering($order)
    {
        return $this->setOrder($order);
    }

    /**
     * Get the value of order.
     *
     * @return integer
     */
    public function getOrder()
    {
        return $this->ordering;
    }
    public function getOrdering()
    {
        return $this->getOrder();
    }

    /**
     * Set the value of name.
     *
     * @param string $name
     * @return \Entity\PaymentType
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
     * Set the value of logo.
     *
     * @param string $logo
     * @return \Entity\PaymentType
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get the value of logo.
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set the value of shortDescription.
     *
     * @param string $shortDescription
     * @return \Entity\PaymentType
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
     * @return \Entity\PaymentType
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
     * Set the value of explanation.
     *
     * @param string $explanation
     * @return \Entity\PaymentType
     */
    public function setExplanation($explanation)
    {
        $this->explanation = $explanation;

        return $this;
    }

    /**
     * Get the value of explanation.
     *
     * @return string
     */
    public function getExplanation()
    {
        return $this->explanation;
    }
    
    /**
     * Set the value of fixFee.
     *
     * @param float $fixFee
     * @return \Entity\PaymentType
     */
    public function setFixFee($fixFee)
    {
        $this->fixFee = $fixFee;

        return $this;
    }

    /**
     * Get the value of fixFee.
     *
     * @return float
     */
    public function getFixFee()
    {
        return $this->fixFee;
    }

    /**
     * Set the value of percentageFee.
     *
     * @param float $percentageFee
     * @return \Entity\PaymentType
     */
    public function setPercentageFee($percentageFee)
    {
        $this->percentageFee = $percentageFee;

        return $this;
    }

    /**
     * Get the value of percentageFee.
     *
     * @return float
     */
    public function getPercentageFee()
    {
        return $this->percentageFee;
    }
    
    /**
     * Calculates fees for this payment type for a given amount
     * 
     * @return float
     */
    public function calcFee($amount) {
        $fixFee = $this->getFixFee();
        $percentageFee = $amount*$this->getPercentageFee()/100;
        return $fixFee+$percentageFee;
    }

    /**
     * Set the value of activeFrom_id.
     *
     * @param integer $id
     * @return \Entity\PaymentType
     */
    public function setActiveFromId($id) {
        $this->activeFrom_id = $id;
        
        return $this;
    }
    
    /**
     * Get the value of activeFrom_id.
     *
     * @return integer
     */
    public function getActiveFromId() {
        return $this->activeFrom_id;
    }
    
    /**
     * Set the value of activeFrom.
     *
     * @param \Entity\Deadline $activeFrom
     * @return \Entity\PaymentType
     */
    public function setActiveFrom(Deadline $activeFrom)
    {
        $this->activeFrom = $activeFrom;

        return $this;
    }

    /**
     * Get the value of activeFrom.
     *
     * @return \Entity\Deadline
     */
    public function getActiveFrom()
    {
        return $this->activeFrom;
    }

    /**
     * Set the value of activeFrom_id.
     *
     * @param integer $id
     * @return \Entity\PaymentType
     */
    public function setActiveUntilId($id) {
        $this->activeUntil_id = $id;
        
        return $this;
    }
    
    /**
     * Get the value of activeUntil_id.
     *
     * @return integer
     */
    public function getActiveUntilId() {
        return $this->activeUntil_id;
    }
    
    /**
     * Set the value of activeUntil.
     *
     * @param \Entity\Deadline $activeUntil
     * @return \Entity\PaymentType
     */
    public function setActiveUntil(Deadline $activeUntil)
    {
        $this->activeUntil = $activeUntil;
     
        return $this;
    }

    /**
     * Get the value of activeUntil.
     *
     * @return \Entity\Deadline
     */
    public function getActiveUntil()
    {
        return $this->activeUntil;
    }

    /**
     * Set the value of days2pay.
     *
     * @param integer $days2pay
     * @return \Entity\PaymentType
     */
    public function setDays2pay($days2pay)
    {
        $this->days2pay = $days2pay;

        return $this;
    }

    /**
     * Get the value of days2pay.
     *
     * @return integer
     */
    public function getDays2pay()
    {
        return $this->days2pay;
    }

    /**
     * Set the value of type.
     *
     * @param string $type
     * @return \Entity\PaymentType
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * Set the value of visible.
     *
     * @param boolean $visible
     * @return \Entity\Product
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get the value of visible.
     *
     * @return boolean
     */
    public function getVisible()
    {
        return $this->visible;
    }
    
    /**
     * Set the value of updated.
     *
     * @param datetime $updated
     * @return \Entity\PaymentType
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
     * @return \Entity\PaymentType
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
     * Add Order entity to collection (one to many).
     *
     * @param \Entity\Order $order
     * @return \Entity\PaymentType
     */
    public function addOrder(Order $order)
    {
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Remove Order entity from collection (one to many).
     *
     * @param \Entity\Order $order
     * @return \Entity\PaymentType
     */
    public function removeOrder(Order $order)
    {
        $this->orders->removeElement($order);

        return $this;
    }

    /**
     * Get Order entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Not used, Only defined to be compatible with InputFilterAwareInterface.
     * 
     * @param \Zend\InputFilter\InputFilterInterface $inputFilter
     * @throws \Exception
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        $this->inputFilter = $inputFilter;
        #throw new \Exception("Not used.");
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
                'filters' => array(
                    array('name' => 'Int'),
                ),
                'validators' => array(),
            ),
            array(
                'name' => 'name',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            array(
                'name' => 'logo',
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
                'name' => 'fixFee',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            array(
                'name' => 'percentageFee',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            array(
                'name' => 'activeFrom',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            array(
                'name' => 'activeUntil',
                'required' => false,
                'filters' => array(),
                'validators' => array(),
            ),
            array(
                'name' => 'days2pay',
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
        $dataFields = array('id', 'ordering', 'name', 'logo', 'shortDescription', 'longDescription', 'explanation', 'fixFee', 'percentageFee', 'activeFrom', 'activeUntil', 'days2pay', 'type', 'visible', 'updated', 'created');
        $relationFields = array();
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
        return array('id', 'ordering', 'name', 'logo', 'shortDescription', 'longDescription', 'explanation', 'fixFee', 'percentageFee', 'activeFrom', 'activeUntil', 'days2pay', 'type', 'visible', 'updated', 'created');
    }
}