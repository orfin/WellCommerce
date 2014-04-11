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
namespace WellCommerce\Plugin\Layout\Repository;

use WellCommerce\Core\Component\Repository\AbstractRepository;
use WellCommerce\Core\Component\Repository\RepositoryInterface;
use WellCommerce\Plugin\Layout\Model\LayoutPage;

/**
 * Class LayoutPageAbstractRepository
 *
 * @package WellCommerce\Plugin\LayoutPage\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutPageRepository extends AbstractRepository implements RepositoryInterface
{

    /**
     * Returns all tax rates
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return LayoutPage::with('column', 'column.box')->orderBy('name')->get();
    }

    /**
     * Returns a single tax rate
     *
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|static
     */
    public function find($id)
    {
        return LayoutPage::with('column', 'column.box')->findOrFail($id);
    }

    /**
     * Deletes layout_theme record by ID
     *
     * @param int $id layout_theme ID to delete
     */
    public function delete($id)
    {
        $this->transaction(function () use ($id) {
            return LayoutPage::destroy($id);
        });
    }

    /**
     * Saves layout_theme
     *
     * @param      $Data
     * @param null $id
     */
    public function save(array $Data, $id = null)
    {
        $this->transaction(function () use ($Data, $id) {

            $layout_theme = LayoutPage::firstOrNew([
                'id' => $id
            ]);

            $layout_theme->discount = $Data['discount'];
            $layout_theme->save();

            foreach ($this->getLanguageIds() as $language) {

                $translation = LayoutPageTranslation::firstOrNew([
                    'layout_theme_id' => $layout_theme->id,
                    'language_id'     => $language
                ]);

                $translation->setTranslationData($Data, $language);
                $translation->save();
            }

        });
    }

    /**
     * Returns array containing values needed to populate the form
     *
     * @param $id
     *
     * @return array
     */
    public function getPopulateData($id)
    {
        return [];
        $layout_themeData = $this->find($id);
        $populateData     = [];
        $accessor         = $this->getPropertyAccessor();
        $languageData     = $layout_themeData->getTranslationData();

        $accessor->setValue($populateData, '[required_data]', [
            'discount'      => $layout_themeData->discount,
            'language_data' => $languageData,
        ]);

        return $populateData;
    }

    public function getAllLayoutPageToSelect()
    {
        return $this->all()->toSelect('id', 'name');
    }
}