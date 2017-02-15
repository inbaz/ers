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
 * ErsBase\Entity\Base\BankAccountCsv
 *
 * @ORM\MappedSuperclass
 * @ORM\Table(name="`bank_account_csv`", indexes={@ORM\Index(name="fk_bank_account_csv_payment_type1_idx", columns={"`payment_type_id`"})})
 * @ORM\HasLifecycleCallbacks
 */
abstract class BankAccountCsv
{
    /**
     * @ORM\Id
     * @ORM\Column(name="`id`", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="`payment_type_id`", type="integer")
     */
    protected $payment_type_id;

    /**
     * @ORM\Column(name="`csv_file`", type="string", length=1000, nullable=true)
     */
    protected $csv_file;

    /**
     * @ORM\Column(name="`updated`", type="datetime")
     */
    protected $updated;

    /**
     * @ORM\Column(name="`created`", type="datetime")
     */
    protected $created;

    /**
     * @ORM\OneToMany(targetEntity="BankStatement", mappedBy="bankAccountCsv")
     * @ORM\JoinColumn(name="`id`", referencedColumnName="`bank_account_csv_id`")
     */
    protected $bankStatements;

    /**
     * @ORM\ManyToOne(targetEntity="PaymentType", inversedBy="bankAccountCsvs")
     * @ORM\JoinColumn(name="`payment_type_id`", referencedColumnName="`id`")
     */
    protected $paymentType;

    public function __construct()
    {
        $this->bankStatements = new ArrayCollection();
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
     * @return \ErsBase\Entity\Base\BankAccountCsv
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
     * Set the value of payment_type_id.
     *
     * @param integer $payment_type_id
     * @return \ErsBase\Entity\Base\BankAccountCsv
     */
    public function setPaymentTypeId($payment_type_id)
    {
        $this->payment_type_id = $payment_type_id;

        return $this;
    }

    /**
     * Get the value of payment_type_id.
     *
     * @return integer
     */
    public function getPaymentTypeId()
    {
        return $this->payment_type_id;
    }

    /**
     * Set the value of csv_file.
     *
     * @param string $csv_file
     * @return \ErsBase\Entity\Base\BankAccountCsv
     */
    public function setCsvFile($csv_file)
    {
        $this->csv_file = $csv_file;

        return $this;
    }

    /**
     * Get the value of csv_file.
     *
     * @return string
     */
    public function getCsvFile()
    {
        return $this->csv_file;
    }

    /**
     * Set the value of updated.
     *
     * @param \DateTime $updated
     * @return \ErsBase\Entity\Base\BankAccountCsv
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
     * @return \ErsBase\Entity\Base\BankAccountCsv
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
     * Add BankStatement entity to collection (one to many).
     *
     * @param \ErsBase\Entity\Base\BankStatement $bankStatement
     * @return \ErsBase\Entity\Base\BankAccountCsv
     */
    public function addBankStatement(BankStatement $bankStatement)
    {
        $this->bankStatements[] = $bankStatement;

        return $this;
    }

    /**
     * Remove BankStatement entity from collection (one to many).
     *
     * @param \ErsBase\Entity\Base\BankStatement $bankStatement
     * @return \ErsBase\Entity\Base\BankAccountCsv
     */
    public function removeBankStatement(BankStatement $bankStatement)
    {
        $this->bankStatements->removeElement($bankStatement);

        return $this;
    }

    /**
     * Get BankStatement entity collection (one to many).
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBankStatements()
    {
        return $this->bankStatements;
    }

    /**
     * Set PaymentType entity (many to one).
     *
     * @param \ErsBase\Entity\Base\PaymentType $paymentType
     * @return \ErsBase\Entity\Base\BankAccountCsv
     */
    public function setPaymentType(PaymentType $paymentType = null)
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * Get PaymentType entity (many to one).
     *
     * @return \ErsBase\Entity\Base\PaymentType
     */
    public function getPaymentType()
    {
        return $this->paymentType;
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
        $dataFields = array('id', 'payment_type_id', 'csv_file', 'updated', 'created');
        $relationFields = array('paymentType');
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
        return array('id', 'payment_type_id', 'csv_file', 'updated', 'created');
    }
}