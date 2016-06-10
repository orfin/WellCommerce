<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\ContactBundle\Entity;

use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\DoctrineBundle\Entity\IdentifiableEntityTrait;

/**
 * Class ContactTicket
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactTicket implements ContactTicketInterface
{
    use IdentifiableEntityTrait;
    use Timestampable;

    /**
     * @var string
     */
    protected $subject;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $content;


    /**
     * {@inheritdoc}
     */
    public function getSubject() : string
    {
        return $this->subject;
    }

    /**
     * {@inheritdoc}
     */
    public function setSubject(string $subject)
    {
        $this->subject = $subject;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * {@inheritdoc}
     */
    public function getContent() : string
    {
        return $this->content;
    }

    /**
     * {@inheritdoc}
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }
}
