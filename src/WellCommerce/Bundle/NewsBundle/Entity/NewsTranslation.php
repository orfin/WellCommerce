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

namespace WellCommerce\Bundle\NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * NewsTranslation
 *
 * @ORM\Table(name="news_translation")
 * @ORM\Entity
 */
class NewsTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @var string
     *
     * @ORM\Column(name="topic", type="string", length=255)
     */
    private $topic;

    /**
     * @var string
     *
     * @ORM\Column(name="summary", type="text")
     */
    private $summary;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="seo", type="string", length=255)
     */
    private $seo;

    /**
     * @var string
     *
     * @ORM\Column(name="keywordTitle", type="string", length=255)
     */
    private $keywordTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="keyword", type="string", length=255)
     */
    private $keyword;

    /**
     * @var string
     *
     * @ORM\Column(name="keywordDescription", type="string", length=255)
     */
    private $keywordDescription;

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $keyword
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;
    }

    /**
     * @return string
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * @param string $keywordDescription
     */
    public function setKeywordDescription($keywordDescription)
    {
        $this->keywordDescription = $keywordDescription;
    }

    /**
     * @return string
     */
    public function getKeywordDescription()
    {
        return $this->keywordDescription;
    }

    /**
     * @param string $keywordTitle
     */
    public function setKeywordTitle($keywordTitle)
    {
        $this->keywordTitle = $keywordTitle;
    }

    /**
     * @return string
     */
    public function getKeywordTitle()
    {
        return $this->keywordTitle;
    }

    /**
     * @param string $seo
     */
    public function setSeo($seo)
    {
        $this->seo = $seo;
    }

    /**
     * @return string
     */
    public function getSeo()
    {
        return $this->seo;
    }

    /**
     * @param string $summary
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

    /**
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @param string $topic
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;
    }

    /**
     * @return string
     */
    public function getTopic()
    {
        return $this->topic;
    }


}

