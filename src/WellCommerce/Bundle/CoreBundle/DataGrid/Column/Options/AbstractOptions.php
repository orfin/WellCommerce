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

namespace WellCommerce\Bundle\CoreBundle\DataGrid\Column\Options;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Zend\Json\Expr;
use Zend\Json\Json;

/**
 * Class AbstractOptions
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractOptions
{
    protected $options;

    public function __construct(array $options = [])
    {
        $optionsResolver = new OptionsResolver();
        $this->configureOptions($optionsResolver);
        $this->options = $optionsResolver->resolve($options);
    }

    abstract protected function configureOptions(OptionsResolver $resolver);

    public function __toString()
    {
        $data = [];
        foreach ($this->options as $key => $value) {
            $data[$key] = $this->getValue($value);
        }

        return Json::encode($data, false, ['enableJsonExprFinder' => true]);
    }

    private function getValue($value)
    {
        if (is_array($value) || is_bool($value)) {
            return $value;
        }

        return new Expr($value);
    }
}
