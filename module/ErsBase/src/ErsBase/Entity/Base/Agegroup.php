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
 * ErsBase\Entity\Base\Agegroup
 *
 * @ORM\MappedSuperclass
 * @ORM\Table(name="`agegroup`")
 * @ORM\HasLifecycleCallbacks
 */
abstract class Agegroup
{
    /**
     * @ORM\Id
     * @ORM\Column(name="`id`", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="`agegroup`", type="date")
     */
    protected $agegroup;

    /**
     * @ORM\Column(name="`name`", type="string", length=45, nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(name="`price_change`", type="boolean", nullable=true)
     */
    protected $price_change;

    /**
     * @ORM\Column(name="`ticket_change`", type="boolean", nullable=true)
     */
    protected $ticket_change;

    /**
     * @ORM\Column(name="`updated`", type="datetime")
     */
    protected $updated;

    /**
     * @ORM\Column(name="`created`", type="datetime")
     */
    protected $created;

    /**
     * @ORM\OneToMany(targetEntity="ProductPrice", mappedBy="agegroup")
     * @ORM\JoinColumn(name="`id`", referencedColumnName="`Agegroup_id`")
     */
    protected $productPrices;

    public function __construct()
    {
        $this->productPrices = new ArrayCollection();
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
     * @return \ErsBase\Entity\Base\Agegroup
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
     * Set the value of agegroup.
     *
     * @param \DateTime $agegroup
     * @return \ErsBase\Entity\Base\Agegroup
     */
    public function setAgegroup($agegroup)
    {
        $this->agegroup = $agegroup;

        return $this;
    }

    /**
     * Get the value of agegroup.
     *
     * @return \DateTime
     */
    public function getAgegroup()
    {
        return $this->agegroup;
    }

    /**
     * Set the value of name.
     *
     * @param string $name
     * @return \ErsBase\Entity\Base\Agegroup
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
     * Set the value of price_change.
     *
     * @param boolean $price_change
     * @return \ErsBase\Entity\Base\Agegroup
     */
    public function setPriceChange($price_change)
    {
        $this->price_change = $price_change;

        return $this;
    }

    /**
     * Get the value of price_change.
     *
     * @return boolean
     */
    public function getPriceChange()
    {
        return $this->price_change;
    }

    /**
     * Set the value of ticket_change.
     *
     * @param boolean $ticket_change
     * @return \ErsBase\Entity\Base\Agegroup
     */
    public function setTicketChange($ticket_change)
    {
        $this->ticket_change = $ticket_change;

        return $this;
    }

    /**
     * Get the value of ticket_change.
     *
     * @return boolean
     */
    public function getTicketChange()
    {
        return $this->ticket_change;
    }

    /**
     * Set the value of updated.
     *
     * @param \DateTime $updated
     * @return \ErsBase\Entity\Base\Agegroup
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
     * @return \ErsBase\Entity\Base\Agegroup
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
     * Add ProductPrice entity to collection (one to many).
     *
     * @param \ErsBase\Entity\Base\ProductPrice $productPrice
     * @return \ErsBase\Entity\Base\Agegroup
     */
    public function addProductPrice(ProductPrice $productPrice)
    {
        $this->productPrices[] = $productPrice;

        return $this;
    }

    /**
     * Remove ProductPrice entity from collection (one to many).
     *
     * @param \ErsBase\Entity\Base\ProductPrice $productPrice
     * @return \ErsBase\Entity\Base\Agegroup
     */
    public function removeProductPrice(ProductPrice $productPrice)
    {
        $this->productPrices->removeElement($productPrice);

        return $this;
    }

    /**
     * Get ProductPrice entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductPrices()
    {
        return $this->productPrices;
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
        $dataFields = array('id', 'agegroup', 'name', 'price_change', 'ticket_change', 'updated', 'created');
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
        return array('id', 'agegroup', 'name', 'price_change', 'ticket_change', 'updated', 'created');
    }
}