<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-mappedsuperclass) on 2017-02-13 17:32:13.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace ErsBase\Entity\Base;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ErsBase\Entity\Base\Status
 *
 * @ORM\MappedSuperclass
 * @ORM\Table(name="`status`")
 */
abstract class Status
{
    /**
     * @ORM\Id
     * @ORM\Column(name="`id`", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="`position`", type="integer", nullable=true)
     */
    protected $position;

    /**
     * @ORM\Column(name="`active`", type="boolean")
     */
    protected $active;

    /**
     * @ORM\Column(name="`value`", type="string", length=45, nullable=true)
     */
    protected $value;

    /**
     * @ORM\Column(name="`description`", type="string", length=3000, nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(name="`updated`", type="datetime", nullable=true)
     */
    protected $updated;

    /**
     * @ORM\Column(name="`created`", type="datetime", nullable=true)
     */
    protected $created;

    /**
     * @ORM\OneToMany(targetEntity="Item", mappedBy="status", cascade={"persist", "merge"})
     * @ORM\JoinColumn(name="`id`", referencedColumnName="`status_id`")
     */
    protected $items;

    /**
     * @ORM\OneToMany(targetEntity="Order", mappedBy="status", cascade={"persist", "merge"})
     * @ORM\JoinColumn(name="`id`", referencedColumnName="`status_id`")
     */
    protected $orders;

    /**
     * @ORM\OneToMany(targetEntity="Package", mappedBy="status", cascade={"persist", "merge"})
     * @ORM\JoinColumn(name="`id`", referencedColumnName="`status_id`")
     */
    protected $packages;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->packages = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \ErsBase\Entity\Base\Status
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
     * @return \ErsBase\Entity\Base\Status
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
     * Set the value of active.
     *
     * @param boolean $active
     * @return \ErsBase\Entity\Base\Status
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get the value of active.
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set the value of value.
     *
     * @param string $value
     * @return \ErsBase\Entity\Base\Status
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of value.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of description.
     *
     * @param string $description
     * @return \ErsBase\Entity\Base\Status
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of updated.
     *
     * @param \DateTime $updated
     * @return \ErsBase\Entity\Base\Status
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
     * @return \ErsBase\Entity\Base\Status
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
     * Add Item entity to collection (one to many).
     *
     * @param \ErsBase\Entity\Base\Item $item
     * @return \ErsBase\Entity\Base\Status
     */
    public function addItem(Item $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove Item entity from collection (one to many).
     *
     * @param \ErsBase\Entity\Base\Item $item
     * @return \ErsBase\Entity\Base\Status
     */
    public function removeItem(Item $item)
    {
        $this->items->removeElement($item);

        return $this;
    }

    /**
     * Get Item entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Add Order entity to collection (one to many).
     *
     * @param \ErsBase\Entity\Base\Order $order
     * @return \ErsBase\Entity\Base\Status
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
     * @return \ErsBase\Entity\Base\Status
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
     * Add Package entity to collection (one to many).
     *
     * @param \ErsBase\Entity\Base\Package $package
     * @return \ErsBase\Entity\Base\Status
     */
    public function addPackage(Package $package)
    {
        $this->packages[] = $package;

        return $this;
    }

    /**
     * Remove Package entity from collection (one to many).
     *
     * @param \ErsBase\Entity\Base\Package $package
     * @return \ErsBase\Entity\Base\Status
     */
    public function removePackage(Package $package)
    {
        $this->packages->removeElement($package);

        return $this;
    }

    /**
     * Get Package entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPackages()
    {
        return $this->packages;
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
        $dataFields = array('id', 'position', 'active', 'value', 'description', 'updated', 'created');
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
        return array('id', 'position', 'active', 'value', 'description', 'updated', 'created');
    }
}