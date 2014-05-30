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
namespace WellCommerce\Plugin\Availability\Repository;

use WellCommerce\Core\Component\Repository\AbstractRepository;
use WellCommerce\Core\Component\Repository\RepositoryInterface;
use WellCommerce\Plugin\Availability\Model\Availability;
use WellCommerce\Plugin\Availability\Model\AvailabilityTranslation;

/**
 * Class AvailabilityAbstractRepository
 *
 * @package WellCommerce\Plugin\Availability\AbstractRepository
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityRepository extends AbstractRepository implements RepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return Availability::with('translation')->get();
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return $this->get('availability.model')->with('translation')->findOrFail($id);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $this->dispatchEvent(AvailabilityRepositoryEvents::PRE_DELETE, [], $id);

        $this->transaction(function () use ($id) {
            $this->find($id)->delete();
        });

        $this->dispatchEvent(AvailabilityRepositoryEvents::POST_DELETE, [], $id);
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $data, $id = null)
    {
        $data = $this->dispatchEvent(AvailabilityRepositoryEvents::PRE_SAVE, $data, $id);

        $this->transaction(function () use ($data, $id) {

            $accessor = $this->getPropertyAccessor();

            $availability = $this->get('availability.model')->firstOrCreate([
                'id' => $id
            ]);

            $availability->update();

            foreach ($this->getLanguageIds() as $language) {

                $translation = AvailabilityTranslation::firstOrCreate([
                    'availability_id' => $availability->id,
                    'language_id'     => $language
                ]);

                $languageData = $accessor->getValue($data, sprintf('[required_data][language_data][%s]', $language));

                $translation->setTranslationData($languageData);
                $translation->update();
            }
        });

        $this->dispatchEvent(AvailabilityRepositoryEvents::POST_SAVE, $data, $id);
    }
}
