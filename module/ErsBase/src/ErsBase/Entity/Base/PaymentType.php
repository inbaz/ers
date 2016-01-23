<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-mappedsuperclass) on 2016-01-23 09:24:25.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace ErsBase\Entity\Base;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ErsBase\Entity\Base\PaymentType
 *
 * @ORM\MappedSuperclass
 * @ORM\Table(name="payment_type", indexes={@ORM\Index(name="fk_PaymentType_Deadline1_idx", columns={"active_from_id"}), @ORM\Index(name="fk_PaymentType_Deadline2_idx", columns={"active_until_id"})})
 * @ORM\HasLifecycleCallbacks
 */
class PaymentType
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="`position`", type="integer", nullable=true)
     */
    protected $position;

    /**
     * @ORM\Column(name="`name`", type="string", length=45, nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $logo;

    /**
     * @ORM\Column(type="string", length=127, nullable=true)
     */
    protected $short_description;

    /**
     * @ORM\Column(type="string", length=3000, nullable=true)
     */
    protected $long_description;

    /**
     * @ORM\Column(type="string", length=3000, nullable=true)
     */
    protected $explanation;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $fix_fee;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $percentage_fee;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $active_from_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $active_until_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $days2pay;

    /**
     * @ORM\Column(name="`type`", type="string", length=45, nullable=true)
     */
    protected $type;

    /**
     * @ORM\Column(type="boolean", nullable=true)
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
     * @ORM\OneToMany(targetEntity="Order", mappedBy="paymentType")
     * @ORM\JoinColumn(name="id", referencedColumnName="payment_type_id")
     */
    protected $orders;

    /**
     * @ORM\ManyToOne(targetEntity="Deadline", inversedBy="paymentTypeRelatedByActiveFromIds")
     * @ORM\JoinColumn(name="active_from_id", referencedColumnName="id", nullable=true)
     */
    protected $deadlineRelatedByActiveFromId;

    /**
     * @ORM\ManyToOne(targetEntity="Deadline", inversedBy="paymentTypeRelatedByActiveUntilIds")
     * @ORM\JoinColumn(name="active_until_id", referencedColumnName="id", nullable=true)
     */
    protected $deadlineRelatedByActiveUntilId;

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
     * Set the value of id.
     *
     * @param integer $id
     * @return \ErsBase\Entity\Base\PaymentType
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
     * Set the value of position.
     *
     * @param integer $position
     * @return \ErsBase\Entity\Base\PaymentType
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get the value of position.
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set the value of name.
     *
     * @param string $name
     * @return \ErsBase\Entity\Base\PaymentType
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
     * @return \ErsBase\Entity\Base\PaymentType
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
     * Set the value of short_description.
     *
     * @param string $short_description
     * @return \ErsBase\Entity\Base\PaymentType
     */
    public function setShortDescription($short_description)
    {
        $this->short_description = $short_description;

        return $this;
    }

    /**
     * Get the value of short_description.
     *
     * @return string
     */
    public function getShortDescription()
    {
        return $this->short_description;
    }

    /**
     * Set the value of long_description.
     *
     * @param string $long_description
     * @return \ErsBase\Entity\Base\PaymentType
     */
    public function setLongDescription($long_description)
    {
        $this->long_description = $long_description;

        return $this;
    }

    /**
     * Get the value of long_description.
     *
     * @return string
     */
    public function getLongDescription()
    {
        return $this->long_description;
    }

    /**
     * Set the value of explanation.
     *
     * @param string $explanation
     * @return \ErsBase\Entity\Base\PaymentType
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
     * Set the value of fix_fee.
     *
     * @param float $fix_fee
     * @return \ErsBase\Entity\Base\PaymentType
     */
    public function setFixFee($fix_fee)
    {
        $this->fix_fee = $fix_fee;

        return $this;
    }

    /**
     * Get the value of fix_fee.
     *
     * @return float
     */
    public function getFixFee()
    {
        return $this->fix_fee;
    }

    /**
     * Set the value of percentage_fee.
     *
     * @param float $percentage_fee
     * @return \ErsBase\Entity\Base\PaymentType
     */
    public function setPercentageFee($percentage_fee)
    {
        $this->percentage_fee = $percentage_fee;

        return $this;
    }

    /**
     * Get the value of percentage_fee.
     *
     * @return float
     */
    public function getPercentageFee()
    {
        return $this->percentage_fee;
    }

    /**
     * Set the value of active_from_id.
     *
     * @param integer $active_from_id
     * @return \ErsBase\Entity\Base\PaymentType
     */
    public function setActiveFromId($active_from_id)
    {
        $this->active_from_id = $active_from_id;

        return $this;
    }

    /**
     * Get the value of active_from_id.
     *
     * @return integer
     */
    public function getActiveFromId()
    {
        return $this->active_from_id;
    }

    /**
     * Set the value of active_until_id.
     *
     * @param integer $active_until_id
     * @return \ErsBase\Entity\Base\PaymentType
     */
    public function setActiveUntilId($active_until_id)
    {
        $this->active_until_id = $active_until_id;

        return $this;
    }

    /**
     * Get the value of active_until_id.
     *
     * @return integer
     */
    public function getActiveUntilId()
    {
        return $this->active_until_id;
    }

    /**
     * Set the value of days2pay.
     *
     * @param integer $days2pay
     * @return \ErsBase\Entity\Base\PaymentType
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
     * @return \ErsBase\Entity\Base\PaymentType
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
     * @return \ErsBase\Entity\Base\PaymentType
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
     * @param \DateTime $updated
     * @return \ErsBase\Entity\Base\PaymentType
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get the value of updated.
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set the value of created.
     *
     * @param \DateTime $created
     * @return \ErsBase\Entity\Base\PaymentType
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get the value of created.
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Add Order entity to collection (one to many).
     *
     * @param \ErsBase\Entity\Base\Order $order
     * @return \ErsBase\Entity\Base\PaymentType
     */
    public function addOrder(Order $order)
    {
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Remove Order entity from collection (one to many).
     *
     * @param \ErsBase\Entity\Base\Order $order
     * @return \ErsBase\Entity\Base\PaymentType
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
     * Set Deadline entity related by `active_from_id` (many to one).
     *
     * @param \ErsBase\Entity\Base\Deadline $deadline
     * @return \ErsBase\Entity\Base\PaymentType
     */
    public function setDeadlineRelatedByActiveFromId(Deadline $deadline = null)
    {
        $this->deadlineRelatedByActiveFromId = $deadline;

        return $this;
    }

    /**
     * Get Deadline entity related by `active_from_id` (many to one).
     *
     * @return \ErsBase\Entity\Base\Deadline
     */
    public function getDeadlineRelatedByActiveFromId()
    {
        return $this->deadlineRelatedByActiveFromId;
    }

    /**
     * Set Deadline entity related by `active_until_id` (many to one).
     *
     * @param \ErsBase\Entity\Base\Deadline $deadline
     * @return \ErsBase\Entity\Base\PaymentType
     */
    public function setDeadlineRelatedByActiveUntilId(Deadline $deadline = null)
    {
        $this->deadlineRelatedByActiveUntilId = $deadline;

        return $this;
    }

    /**
     * Get Deadline entity related by `active_until_id` (many to one).
     *
     * @return \ErsBase\Entity\Base\Deadline
     */
    public function getDeadlineRelatedByActiveUntilId()
    {
        return $this->deadlineRelatedByActiveUntilId;
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
        $dataFields = array('id', 'position', 'name', 'logo', 'short_description', 'long_description', 'explanation', 'fix_fee', 'percentage_fee', 'active_from_id', 'active_until_id', 'days2pay', 'type', 'visible', 'updated', 'created');
        $relationFields = array('deadline', 'deadline');
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
        return array('id', 'position', 'name', 'logo', 'short_description', 'long_description', 'explanation', 'fix_fee', 'percentage_fee', 'active_from_id', 'active_until_id', 'days2pay', 'type', 'visible', 'updated', 'created');
    }
}