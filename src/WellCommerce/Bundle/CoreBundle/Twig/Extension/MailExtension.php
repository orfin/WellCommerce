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

namespace WellCommerce\Bundle\CoreBundle\Twig\Extension;

use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class MailerCidExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MailExtension extends \Twig_Extension
{
    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * MailExtension constructor.
     *
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('cid', [$this, 'getCid'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'cid';
    }

    /**
     * @param $path
     * @param $filter
     *
     * @return mixed
     */
    public function getCid(\Swift_Message $message, $imagePath)
    {
        $path = $this->kernel->getRootDir() . '/../' . $imagePath;

        return $message->embed(
            \Swift_Image::fromPath($path)
        );
    }
}
