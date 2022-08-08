<?php

namespace DND\OfferManager\Api\Data;

interface HeadbandInterface
{
    CONST ID = 'entity_id';

    CONST TITLE = 'title';

    CONST IS_ACTIVE = 'is_active';

    CONST DESCRIPTION = 'description';

    CONST LINK = 'link';

    CONST SHOW_AT = 'show_at';

    CONST SHOW_UNTIL = 'show_until';

    CONST CATEGORY_IDS = 'category_ids';

    CONST MEDIA = 'media';

    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return bool|null
     */
    public function isActive();

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @return string
     */
    public function getLink();

    /**
     * @return string
     */
    public function getShowAt();

    /**
     * @return string
     */
    public function getShowUntil();

    /**
     * @param $title
     * @return HeadbandInterface
     */
    public function setTitle($title);

    /**
     * @param $active
     * @return HeadbandInterface
     */
    public function setIsActive($active);

    /**
     * @param $description
     * @return HeadbandInterface
     */
    public function setDescription($description);

    /**
     * @param $link
     * @return HeadbandInterface
     */
    public function setLink($link);

    /**
     * @param $showAt
     * @return HeadbandInterface
     */
    public function setShowAt($showAt);

    /**
     * @param $showUntil
     * @return HeadbandInterface
     */
    public function setShowUntil($showUntil);

    /**
     * @param $categoryIds array
     * @return HeadbandInterface
     */
    public function setCategoryIds($categoryIds);

    /**
     * @return array
     */
    public function getCategoryIds();

    /**
     * @param $media
     * @return HeadbandInterface
     */
    public function setMedia($media);
    /**
     * @return string
     */
    public function getMedia();
}
