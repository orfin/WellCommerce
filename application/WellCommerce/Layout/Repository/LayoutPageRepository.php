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
namespace WellCommerce\Layout\Repository;

use WellCommerce\Core\Repository\AbstractRepository;
use WellCommerce\Core\Repository\RepositoryInterface;
use WellCommerce\Layout\Model\LayoutPage;
use WellCommerce\Layout\Model\LayoutPageColumn;
use WellCommerce\Layout\Model\LayoutPageColumnBox;

/**
 * Class LayoutPageAbstractRepository
 *
 * @package WellCommerce\LayoutPage\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutPageRepository extends AbstractRepository implements LayoutPageRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return LayoutPage::with('column', 'column.boxes')->orderBy('name', 'ASC')->get();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return LayoutPage::with('column', 'column.boxes')->findOrFail($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findPagesByThemeId($id)
    {
        return LayoutPageColumn::with('boxes')->where('layout_theme_id', '=', $id)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $this->transaction(function () use ($id) {
            return LayoutPage::destroy($id);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $data, $id = null)
    {
        $this->transaction(function () use ($data, $id) {

            // delete all layout columns
            LayoutPageColumn::where('layout_theme_id', '=', $id)->delete();

            foreach ($data as $pageId => $columnsData) {

                $pageId = substr($pageId, 12);

                foreach ($columnsData['columns_data'] as $column) {
                    // save layout column
                    $layoutPageColumn = LayoutPageColumn::create([
                        'layout_page_id'  => $pageId,
                        'layout_theme_id' => $id,
                        'width'           => $column['width'],
                    ]);

                    // save boxes in layout column
                    if (!empty($column['layout_boxes'])) {
                        foreach ($column['layout_boxes'] as $box) {

                            LayoutPageColumnBox::create([
                                'layout_page_column_id' => $layoutPageColumn->id,
                                'layout_box_id'         => $box['layoutbox'],
                                'span'                  => $box['span'],
                            ]);
                        }
                    }
                }
            }
        });

        $this->getCache()->clearByPrefix('layout_');
    }

    /**
     * {@inheritdoc}
     */
    public function getAllLayoutPageToSelect()
    {
        return $this->all()->toSelect('id', 'name');
    }
}