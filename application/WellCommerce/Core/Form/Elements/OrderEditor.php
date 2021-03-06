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

namespace WellCommerce\Core\Form\Elements;

/**
 * Class OrderEditor
 *
 * @package WellCommerce\Core\Form\Elements
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderEditor extends Select implements ElementInterface
{
    public $datagrid;
    protected $_jsFunction;

    public function __construct($attributes)
    {
        parent::__construct($attributes);
        $this->_jsFunction               = 'LoadProducts_' . $this->_id;
        $this->attributes['jsfunction'] = 'xajax_' . $this->_jsFunction;
        App::getRegistry()->xajax->registerFunction(array(
            $this->_jsFunction,
            $this,
            'loadProducts'
        ));
        $this->attributes['load_category_children'] = App::getRegistry()->xajaxInterface->registerFunction(array(
            'LoadCategoryChildren_' . $this->_id,
            $this,
            'loadCategoryChildren'
        ));
        $this->attributes['datagrid_filter']        = $this->getDatagridfilterData();
    }

    protected function prepareAttributesJs()
    {
        $attributes = Array(
            $this->formatAttributeJs('name', 'sName'),
            $this->formatAttributeJs('label', 'sLabel'),
            $this->formatAttributeJs('comment', 'sComment'),
            $this->formatAttributeJs('error', 'sError'),
            $this->formatAttributeJs('on_change', 'fOnChange', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('on_before_change', 'fOnBeforeChange', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('jsfunction', 'fLoadProducts', ElementInterface::TYPE_FUNCTION),
            $this->formatAttributeJs('datagrid_filter', 'ofilterData', ElementInterface::TYPE_OBJECT),
            $this->formatAttributeJs('load_category_children', 'fLoadCategoryChildren', ElementInterface::TYPE_FUNCTION),
            $this->formatRepeatableJs(),
            $this->formatRulesJs(),
            $this->formatDependencyJs(),
            $this->formatDefaultsJs()
        );

        return $attributes;
    }

    public function loadCategoryChildren($request)
    {
        return Array(
            'aoItems' => $this->getCategories($request['parentId'])
        );
    }

    protected function getCategories($parent = 0)
    {
        $categories = App::getModel('category')->getChildCategories($parent);
        usort($categories, Array(
            $this,
            'sortCategories'
        ));

        return $categories;
    }

    protected function sortCategories($a, $b)
    {
        return $a['weight'] - $b['weight'];
    }

    public function loadProducts($request, $processFunction)
    {
        return $this->getDatagrid()->getData($request, $processFunction);
    }

    public function getDatagrid()
    {
        if (($this->datagrid == null) || !($this->datagrid instanceof DatagridModel)) {
            $this->datagrid = App::getModel(get_class($this) . '/datagrid');
            $this->initDatagrid($this->datagrid);
        }

        return $this->datagrid;
    }

    public function getDatagridfilterData()
    {
        return $this->getDatagrid()->getfilterData();
    }

    public function processVariants($productId)
    {
        if (!isset($this->attributes['clientgroupid'])) {
            $this->attributes['clientgroupid'] = 0;
        }
        if (!isset($this->attributes['currencyid'])) {
            $this->attributes['currencyid'] = 0;
        }
        $rawVariants
                  = (App::getModel('product/product')->getAttributeCombinationsForProduct($productId, $this->attributes['clientgroupid'], $this->attributes['currencyid']));
        $variants = Array();

        $variants[] = Array(
            'id'      => '',
            'caption' => Translation::get('TXT_CHOOSE_VARIANT'),
            'price'   => ''
        );
        foreach ($rawVariants as $variant) {
            $caption = Array();
            foreach ($variant['attributes'] as $attribute) {
                $caption[] = str_replace('"', '\'', $attribute['name']);
            }
            $variants[] = Array(
                'id'      => $variant['id'],
                'caption' => implode(', ', $caption),
                'options' => Array(
                    'price'  => $variant['price'],
                    'stock'  => $variant['qty'],
                    'weight' => $variant['weight'],
                    'ean'    => $variant['symbol'],
                    'thumb'  => App::getModel('product')->getThumbPathForId($variant['photoid'])
                )
            );
        }

        return json_encode($variants);
    }

    public function processSellprice($sellprice)
    {
        return $sellprice;
    }

    protected function initDatagrid($datagrid)
    {
        $datagrid->setTableData('product', Array(
            'idproduct'          => Array(
                'source' => 'P.idproduct'
            ),
            'name'               => Array(
                'source'                => 'PT.name',
                'prepareForAutosuggest' => true
            ),
            'categoryname'       => Array(
                'source' => 'CT.name'
            ),
            'ean'                => Array(
                'source' => 'P.ean'
            ),
            'categoryid'         => Array(
                'source'         => 'PC.categoryid',
                'prepareForTree' => true,
                'first_level'    => $this->getCategories()
            ),
            'ancestorcategoryid' => Array(
                'source' => 'CP.ancestorcategoryid'
            ),
            'categoriesname'     => Array(
                'source' => 'GROUP_CONCAT(DISTINCT SUBSTRING(CONCAT(\' \', CT.name), 1))',
                'filter' => 'having'
            ),
            'sellprice'          => Array(
                'source' => 'ROUND(P.sellprice, 4)'
            ),
            'sellprice_gross'    => Array(
                'source' => 'ROUND(P.sellprice * (1 + V.value / 100), 2)'
            ),
            'weight'             => Array(
                'source' => 'P.weight'
            ),
            'barcode'            => Array(
                'source'                => 'P.barcode',
                'prepareForAutosuggest' => true
            ),
            'buyprice'           => Array(
                'source' => 'P.buyprice'
            ),
            'producer'           => Array(
                'source'           => 'PRT.name',
                'prepareForSelect' => true
            ),
            'vat'                => Array(
                'source'           => 'CONCAT(V.value, \'%\')',
                'prepareForSelect' => true
            ),
            'stock'              => Array(
                'source' => 'stock'
            ),
            'variant__options'   => Array(
                'source'          => 'P.idproduct',
                'processFunction' => Array(
                    $this,
                    'processVariants'
                )
            ),
            'thumb'              => Array(
                'source'          => 'PP.photoid',
                'processFunction' => Array(
                    App::getModel('product'),
                    'getThumbPathForId'
                )
            )
        ));
        $datagrid->setFrom('
			product P
			LEFT JOIN producttranslation PT ON P.idproduct = PT.productid AND PT.languageid = :languageid
			LEFT JOIN productcategory PC ON PC.productid = P.idproduct
			LEFT JOIN productphoto PP ON PP.productid = P.idproduct AND PP.mainphoto = 1
			LEFT JOIN viewcategory VC ON VC.categoryid = PC.categoryid
			LEFT JOIN category C ON C.idcategory = PC.categoryid
			LEFT JOIN categorypath CP ON C.idcategory = CP.categoryid
			LEFT JOIN categorytranslation CT ON C.idcategory = CT.categoryid AND CT.languageid = :languageid
			LEFT JOIN `producer` R ON P.producerid = R.idproducer
			LEFT JOIN producertranslation PRT ON P.producerid = PRT.producerid AND PRT.languageid = :languageid
			LEFT JOIN `vat` V ON P.vatid = V.idvat
		');

        $datagrid->setGroupBy('
			P.idproduct
		');

        if (isset($this->attributes['viewid'])) {
            $datagrid->setAdditionalWhere("
				IF(PC.categoryid IS NOT NULL, VC.viewid = :view, 1)
			");

            $datagrid->setSQLParams(Array(
                'view' => $this->attributes['viewid']
            ));
        }
    }
}