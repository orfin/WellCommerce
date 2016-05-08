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
 * Class MailExtension
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class MailExtension extends \Twig_Extension
{
    /**
     * @var KernelInterface
     */
    private $kernel;

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
            new \Twig_SimpleFunction('cid', [$this, 'getCidPath'], ['is_safe' => ['html']]),
        ];
    }

    public function getName()
    {
        return 'cid';
    }

    public function getCidPath(\Swift_Message $message, string $imagePath) : string
    {
        $path = $this->kernel->getRootDir() . '/../' . $imagePath;

        return $message->embed(
            \Swift_Image::fromPath($path)
        );
    }
}
