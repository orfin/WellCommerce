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

namespace WellCommerce\Bundle\IntlBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use WellCommerce\Bundle\IntlBundle\ORM\LocaleAwareInterface;

/**
 * DictionaryTranslation
 *
 * @ORM\Table(name="dictionary_translation")
 * @ORM\Entity
 */
class DictionaryTranslation implements LocaleAwareInterface
{
    use Translation;

    /**
     * @var string
     *
     * @ORM\Column(name="translation", type="string", length=255)
     */
    private $translation;

    /**
     * Returns translation ID.
     *
     * @return integer The ID.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTranslation()
    {
        return $this->translation;
    }

    /**
     * @param string $translation
     */
    public function setTranslation($translation)
    {
        $this->translation = $translation;
    }
}

