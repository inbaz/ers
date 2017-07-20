<?php

/**
 * Auto generated by MySQL Workbench Schema Exporter.
 * Version 2.1.6-dev (doctrine2-realentity) on 2017-07-19 21:48:42.
 * Goto https://github.com/johmue/mysql-workbench-schema-exporter for more
 * information.
 */

namespace ErsBase\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ErsBase\Entity\MailqHasUser
 *
 * @ORM\Entity()
 * @ORM\Table(name="`mailq_has_user`", indexes={@ORM\Index(name="fk_mailq_has_user_user4_idx", columns={"`user_id`"}), @ORM\Index(name="fk_mailq_has_user_mailq4_idx", columns={"`mailq_id`"})})
 */
class MailqHasUser extends Base\MailqHasUser
{
    public function __construct()
    {
        parent::__construct();
    }

    public function setTo() {
        $this->setType('to');
    }
    
    public function setCc() {
        $this->setType('cc');
    }
    
    public function setBcc() {
        $this->setType('bcc');
    }
}