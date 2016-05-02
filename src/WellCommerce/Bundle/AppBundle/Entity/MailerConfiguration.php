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

namespace WellCommerce\Bundle\AppBundle\Entity;

/**
 * Class MailerConfiguration
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MailerConfiguration
{
    /**
     * @var string
     */
    protected $from;
    
    /**
     * @var string
     */
    protected $host;
    
    /**
     * @var int
     */
    protected $port;
    
    /**
     * @var string
     */
    protected $user;
    
    /**
     * @var string
     */
    protected $pass;
    
    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }
    
    /**
     * @param string $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }
    
    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }
    
    /**
     * @param mixed $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }
    
    /**
     * @return mixed
     */
    public function getPort()
    {
        return $this->port;
    }
    
    /**
     * @param mixed $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }
    
    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
    
    /**
     * @return mixed
     */
    public function getPass()
    {
        return $this->pass;
    }
    
    /**
     * @param mixed $pass
     */
    public function setPass($pass)
    {
        $this->pass = $pass;
    }
}
