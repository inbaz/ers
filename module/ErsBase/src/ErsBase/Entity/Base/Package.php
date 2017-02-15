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
 * ErsBase\Entity\Base\Package
 *
 * @ORM\MappedSuperclass
 * @ORM\Table(name="`package`", indexes={@ORM\Index(name="fk_Package_User1_idx", columns={"`participant_id`"}), @ORM\Index(name="fk_package_package1_idx", columns={"`transferred_package_id`"}), @ORM\Index(name="fk_package_order1_idx", columns={"`order_id`"}), @ORM\Index(name="fk_package_status1_idx", columns={"`status_id`"}), @ORM\Index(name="fk_package_code1_idx", columns={"`code_id`"}), @ORM\Index(name="fk_package_currency1_idx", columns={"`currency_id`"})})
 * @ORM\HasLifecycleCallbacks
 */
abstract class Package
{
    /**
     * @ORM\Id
     * @ORM\Column(name="`id`", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="`code_id`", type="integer")
     */
    protected $code_id;

    /**
     * @ORM\Column(name="`status_id`", type="integer")
     */
    protected $status_id;

    /**
     * @ORM\Column(name="`order_id`", type="integer")
     */
    protected $order_id;

    /**
     * @ORM\Column(name="`participant_id`", type="integer")
     */
    protected $participant_id;

    /**
     * @ORM\Column(name="`transferred_package_id`", type="integer", nullable=true)
     */
    protected $transferred_package_id;

    /**
     * @ORM\Column(name="`ticket_status`", type="string", length=45, nullable=true)
     */
    protected $ticket_status;

    /**
     * @ORM\Column(name="`comment`", type="text", nullable=true)
     */
    protected $comment;

    /**
     * @ORM\Column(name="`currency_id`", type="integer")
     */
    protected $currency_id;

    /**
     * @ORM\Column(name="`updated`", type="datetime")
     */
    protected $updated;

    /**
     * @ORM\Column(name="`created`", type="datetime")
     */
    protected $created;

    /**
     * @ORM\OneToMany(targetEntity="Item", mappedBy="package", cascade={"persist", "merge"})
     * @ORM\JoinColumn(name="`id`", referencedColumnName="`Package_id`")
     */
    protected $items;

    /**
     * @ORM\OneToMany(targetEntity="Log", mappedBy="package")
     * @ORM\JoinColumn(name="`id`", referencedColumnName="`package_id`")
     */
    protected $logs;

    /**
     * @ORM\OneToOne(targetEntity="Code", inversedBy="package", cascade={"persist", "merge"})
     * @ORM\JoinColumn(name="`code_id`", referencedColumnName="`id`")
     */
    protected $code;

    /**
     * @ORM\ManyToOne(targetEntity="Status", inversedBy="packages", cascade={"persist", "merge"})
     * @ORM\JoinColumn(name="`status_id`", referencedColumnName="`id`")
     */
    protected $status;

    /**
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="packages", cascade={"persist", "merge"})
     * @ORM\JoinColumn(name="`order_id`", referencedColumnName="`id`")
     */
    protected $order;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="packages", cascade={"persist", "merge"})
     * @ORM\JoinColumn(name="`participant_id`", referencedColumnName="`id`")
     */
    protected $user;

    /**
     * @ORM\OneToOne(targetEntity="Package")
     * @ORM\JoinColumn(name="`transferred_package_id`", referencedColumnName="`id`", nullable=true)
     */
    protected $package;

    /**
     * @ORM\ManyToOne(targetEntity="Currency", inversedBy="packages")
     * @ORM\JoinColumn(name="`currency_id`", referencedColumnName="`id`")
     */
    protected $currency;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->logs = new ArrayCollection();
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
     * @return \ErsBase\Entity\Base\Package
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
     * Set the value of code_id.
     *
     * @param integer $code_id
     * @return \ErsBase\Entity\Base\Package
     */
    public function setCodeId($code_id)
    {
        $this->code_id = $code_id;

        return $this;
    }

    /**
     * Get the value of code_id.
     *
     * @return integer
     */
    public function getCodeId()
    {
        return $this->code_id;
    }

    /**
     * Set the value of status_id.
     *
     * @param integer $status_id
     * @return \ErsBase\Entity\Base\Package
     */
    public function setStatusId($status_id)
    {
        $this->status_id = $status_id;

        return $this;
    }

    /**
     * Get the value of status_id.
     *
     * @return integer
     */
    public function getStatusId()
    {
        return $this->status_id;
    }

    /**
     * Set the value of order_id.
     *
     * @param integer $order_id
     * @return \ErsBase\Entity\Base\Package
     */
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;

        return $this;
    }

    /**
     * Get the value of order_id.
     *
     * @return integer
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * Set the value of participant_id.
     *
     * @param integer $participant_id
     * @return \ErsBase\Entity\Base\Package
     */
    public function setParticipantId($participant_id)
    {
        $this->participant_id = $participant_id;

        return $this;
    }

    /**
     * Get the value of participant_id.
     *
     * @return integer
     */
    public function getParticipantId()
    {
        return $this->participant_id;
    }

    /**
     * Set the value of transferred_package_id.
     *
     * @param integer $transferred_package_id
     * @return \ErsBase\Entity\Base\Package
     */
    public function setTransferredPackageId($transferred_package_id)
    {
        $this->transferred_package_id = $transferred_package_id;

        return $this;
    }

    /**
     * Get the value of transferred_package_id.
     *
     * @return integer
     */
    public function getTransferredPackageId()
    {
        return $this->transferred_package_id;
    }

    /**
     * Set the value of ticket_status.
     *
     * @param string $ticket_status
     * @return \ErsBase\Entity\Base\Package
     */
    public function setTicketStatus($ticket_status)
    {
        $this->ticket_status = $ticket_status;

        return $this;
    }

    /**
     * Get the value of ticket_status.
     *
     * @return string
     */
    public function getTicketStatus()
    {
        return $this->ticket_status;
    }

    /**
     * Set the value of comment.
     *
     * @param string $comment
     * @return \ErsBase\Entity\Base\Package
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get the value of comment.
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set the value of currency_id.
     *
     * @param integer $currency_id
     * @return \ErsBase\Entity\Base\Package
     */
    public function setCurrencyId($currency_id)
    {
        $this->currency_id = $currency_id;

        return $this;
    }

    /**
     * Get the value of currency_id.
     *
     * @return integer
     */
    public function getCurrencyId()
    {
        return $this->currency_id;
    }

    /**
     * Set the value of updated.
     *
     * @param \DateTime $updated
     * @return \ErsBase\Entity\Base\Package
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
     * @return \ErsBase\Entity\Base\Package
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
     * @return \ErsBase\Entity\Base\Package
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
     * @return \ErsBase\Entity\Base\Package
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
     * Add Log entity to collection (one to many).
     *
     * @param \ErsBase\Entity\Base\Log $log
     * @return \ErsBase\Entity\Base\Package
     */
    public function addLog(Log $log)
    {
        $this->logs[] = $log;

        return $this;
    }

    /**
     * Remove Log entity from collection (one to many).
     *
     * @param \ErsBase\Entity\Base\Log $log
     * @return \ErsBase\Entity\Base\Package
     */
    public function removeLog(Log $log)
    {
        $this->logs->removeElement($log);

        return $this;
    }

    /**
     * Get Log entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * Set Code entity (one to one).
     *
     * @param \ErsBase\Entity\Base\Code $code
     * @return \ErsBase\Entity\Base\Package
     */
    public function setCode(Code $code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get Code entity (one to one).
     *
     * @return \ErsBase\Entity\Base\Code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set Status entity (many to one).
     *
     * @param \ErsBase\Entity\Base\Status $status
     * @return \ErsBase\Entity\Base\Package
     */
    public function setStatus(Status $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get Status entity (many to one).
     *
     * @return \ErsBase\Entity\Base\Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set Order entity (many to one).
     *
     * @param \ErsBase\Entity\Base\Order $order
     * @return \ErsBase\Entity\Base\Package
     */
    public function setOrder(Order $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get Order entity (many to one).
     *
     * @return \ErsBase\Entity\Base\Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set User entity (many to one).
     *
     * @param \ErsBase\Entity\Base\User $user
     * @return \ErsBase\Entity\Base\Package
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get User entity (many to one).
     *
     * @return \ErsBase\Entity\Base\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set Package entity (one to one).
     *
     * @param \ErsBase\Entity\Base\Package $package
     * @return \ErsBase\Entity\Base\Package
     */
    public function setPackage(Package $package)
    {
        $this->package = $package;

        return $this;
    }

    /**
     * Get Package entity (one to one).
     *
     * @return \ErsBase\Entity\Base\Package
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * Set Currency entity (many to one).
     *
     * @param \ErsBase\Entity\Base\Currency $currency
     * @return \ErsBase\Entity\Base\Package
     */
    public function setCurrency(Currency $currency = null)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get Currency entity (many to one).
     *
     * @return \ErsBase\Entity\Base\Currency
     */
    public function getCurrency()
    {
        return $this->currency;
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
        $dataFields = array('id', 'code_id', 'status_id', 'order_id', 'participant_id', 'transferred_package_id', 'ticket_status', 'comment', 'currency_id', 'updated', 'created');
        $relationFields = array('user', 'package', 'order', 'status', 'code', 'currency');
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
        return array('id', 'code_id', 'status_id', 'order_id', 'participant_id', 'transferred_package_id', 'ticket_status', 'comment', 'currency_id', 'updated', 'created');
    }
}