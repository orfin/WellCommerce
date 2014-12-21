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

namespace WellCommerce\Bundle\IntlBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\Timestampable\TimestampableTrait;

/**
 * Class Currency
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class Currency
{
    use TimestampableTrait;
    use ORMBehaviors\Blameable\Blameable;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $code;

    /**
     * Returns primary key
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns currency code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Sets currency code
     *
     * @param $code
     *
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;
    }
}

