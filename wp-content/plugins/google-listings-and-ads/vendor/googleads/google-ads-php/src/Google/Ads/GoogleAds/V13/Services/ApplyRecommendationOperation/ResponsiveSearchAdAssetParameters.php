<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/ads/googleads/v13/services/recommendation_service.proto

namespace Google\Ads\GoogleAds\V13\Services\ApplyRecommendationOperation;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Parameters to use when applying a responsive search ad asset
 * recommendation.
 *
 * Generated from protobuf message <code>google.ads.googleads.v13.services.ApplyRecommendationOperation.ResponsiveSearchAdAssetParameters</code>
 */
class ResponsiveSearchAdAssetParameters extends \Google\Protobuf\Internal\Message
{
    /**
     * Updated ad. The current ad's content will be replaced.
     *
     * Generated from protobuf field <code>.google.ads.googleads.v13.resources.Ad updated_ad = 1;</code>
     */
    protected $updated_ad = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Ads\GoogleAds\V13\Resources\Ad $updated_ad
     *           Updated ad. The current ad's content will be replaced.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Ads\GoogleAds\V13\Services\RecommendationService::initOnce();
        parent::__construct($data);
    }

    /**
     * Updated ad. The current ad's content will be replaced.
     *
     * Generated from protobuf field <code>.google.ads.googleads.v13.resources.Ad updated_ad = 1;</code>
     * @return \Google\Ads\GoogleAds\V13\Resources\Ad|null
     */
    public function getUpdatedAd()
    {
        return $this->updated_ad;
    }

    public function hasUpdatedAd()
    {
        return isset($this->updated_ad);
    }

    public function clearUpdatedAd()
    {
        unset($this->updated_ad);
    }

    /**
     * Updated ad. The current ad's content will be replaced.
     *
     * Generated from protobuf field <code>.google.ads.googleads.v13.resources.Ad updated_ad = 1;</code>
     * @param \Google\Ads\GoogleAds\V13\Resources\Ad $var
     * @return $this
     */
    public function setUpdatedAd($var)
    {
        GPBUtil::checkMessage($var, \Google\Ads\GoogleAds\V13\Resources\Ad::class);
        $this->updated_ad = $var;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(ResponsiveSearchAdAssetParameters::class, \Google\Ads\GoogleAds\V13\Services\ApplyRecommendationOperation_ResponsiveSearchAdAssetParameters::class);

