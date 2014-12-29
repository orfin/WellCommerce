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

namespace WellCommerce\Bundle\CoreBundle\Form\Renderer;

/**
 * Class FormRendererChain
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class FormRendererChain implements FormRendererChainInterface
{
    /**
     * @var array
     */
    private $renderers = [];

    /**
     * Constructor
     *
     * @param array $renderers
     */
    public function __construct(array $renderers)
    {
        foreach ($renderers as $renderer) {
            if ($renderer instanceof FormRendererInterface) {
                $this->renderers[] = $renderer;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function guessRenderer($type)
    {
        foreach ($this->renderers as $renderer) {
            if ($this->checkRendererSupport($renderer, $type)) {
                return $renderer;
            }
        }

        throw new \RuntimeException(sprintf('No matching form renderer found for type "%s"', $type));
    }

    /**
     * Checks whether renderer supports given type
     *
     * @param FormRendererInterface $renderer
     * @param                       $type
     *
     * @return bool
     */
    protected function checkRendererSupport(FormRendererInterface $renderer, $type)
    {
        return $renderer->supports($type);
    }
} 