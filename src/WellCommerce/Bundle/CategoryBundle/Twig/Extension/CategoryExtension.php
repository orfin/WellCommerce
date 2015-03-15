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
namespace WellCommerce\Bundle\CategoryBundle\Twig\Extension;

use Symfony\Component\HttpFoundation\RequestStack;
use WellCommerce\Bundle\CategoryBundle\Provider\CategoryProviderInterface;
use WellCommerce\Bundle\DataSetBundle\Conditions\Condition\Eq;
use WellCommerce\Bundle\DataSetBundle\Conditions\ConditionsCollection;

/**
 * Class CategoryExtension
 *
 * @package WellCommerce\Bundle\CategoryBundle\Twig\Extension
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryExtension extends \Twig_Extension
{
    /**
     * @var CategoryProviderInterface
     */
    protected $provider;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * Constructor
     *
     * @param CategoryProviderInterface $provider
     * @param RequestStack              $requestStack
     */
    public function __construct(CategoryProviderInterface $provider, RequestStack $requestStack)
    {
        $this->provider     = $provider;
        $this->requestStack = $requestStack;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('categoriesTree', [$this, 'getCategoriesTree'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * Returns categories tree
     *
     * @param int    $limit
     * @param string $orderBy
     * @param string $orderDir
     *
     * @return mixed
     */
    public function getCategoriesTree(
        $limit = CategoryProviderInterface::CATEGORY_TREE_LIMIT,
        $orderBy = CategoryProviderInterface::CATEGORY_ORDER_BY,
        $orderDir = CategoryProviderInterface::CATEGORY_ORDER_DIR
    ) {

        $params = [
            'limit'      => $limit,
            'order_by'   => $orderBy,
            'order_dir'  => $orderDir,
            'conditions' => $this->getTreeConditions()
        ];

        return $this->provider->getCategoriesTree($params);
    }

    private function getTreeConditions()
    {
        $session    = $this->requestStack->getCurrentRequest()->getSession();
        $activeShop = $session->get('global/shop');
        $conditions = new ConditionsCollection();
        $conditions->add(new Eq('shop', $activeShop['id']));

        return $conditions;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'category';
    }
}
