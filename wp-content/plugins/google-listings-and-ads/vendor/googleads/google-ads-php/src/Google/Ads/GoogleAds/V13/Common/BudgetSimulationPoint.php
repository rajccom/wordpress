<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/ads/googleads/v13/common/simulation.proto

namespace Google\Ads\GoogleAds\V13\Common;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Projected metrics for a specific budget amount.
 *
 * Generated from protobuf message <code>google.ads.googleads.v13.common.BudgetSimulationPoint</code>
 */
class BudgetSimulationPoint extends \Google\Protobuf\Internal\Message
{
    /**
     * The simulated budget upon which projected metrics are based.
     *
     * Generated from protobuf field <code>int64 budget_amount_micros = 1;</code>
     */
    protected $budget_amount_micros = 0;
    /**
     * Projected required daily cpc bid ceiling that the advertiser must set to
     * realize this simulation, in micros of the advertiser currency.
     * Only campaigns with the Target Spend bidding strategy support this field.
     *
     * Generated from protobuf field <code>int64 required_cpc_bid_ceiling_micros = 2;</code>
     */
    protected $required_cpc_bid_ceiling_micros = 0;
    /**
     * Projected number of biddable conversions.
     *
     * Generated from protobuf field <code>double biddable_conversions = 3;</code>
     */
    protected $biddable_conversions = 0.0;
    /**
     * Projected total value of biddable conversions.
     *
     * Generated from protobuf field <code>double biddable_conversions_value = 4;</code>
     */
    protected $biddable_conversions_value = 0.0;
    /**
     * Projected number of clicks.
     *
     * Generated from protobuf field <code>int64 clicks = 5;</code>
     */
    protected $clicks = 0;
    /**
     * Projected cost in micros.
     *
     * Generated from protobuf field <code>int64 cost_micros = 6;</code>
     */
    protected $cost_micros = 0;
    /**
     * Projected number of impressions.
     *
     * Generated from protobuf field <code>int64 impressions = 7;</code>
     */
    protected $impressions = 0;
    /**
     * Projected number of top slot impressions.
     * Only search advertising channel type supports this field.
     *
     * Generated from protobuf field <code>int64 top_slot_impressions = 8;</code>
     */
    protected $top_slot_impressions = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int|string $budget_amount_micros
     *           The simulated budget upon which projected metrics are based.
     *     @type int|string $required_cpc_bid_ceiling_micros
     *           Projected required daily cpc bid ceiling that the advertiser must set to
     *           realize this simulation, in micros of the advertiser currency.
     *           Only campaigns with the Target Spend bidding strategy support this field.
     *     @type float $biddable_conversions
     *           Projected number of biddable conversions.
     *     @type float $biddable_conversions_value
     *           Projected total value of biddable conversions.
     *     @type int|string $clicks
     *           Projected number of clicks.
     *     @type int|string $cost_micros
     *           Projected cost in micros.
     *     @type int|string $impressions
     *           Projected number of impressions.
     *     @type int|string $top_slot_impressions
     *           Projected number of top slot impressions.
     *           Only search advertising channel type supports this field.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Ads\GoogleAds\V13\Common\Simulation::initOnce();
        parent::__construct($data);
    }

    /**
     * The simulated budget upon which projected metrics are based.
     *
     * Generated from protobuf field <code>int64 budget_amount_micros = 1;</code>
     * @return int|string
     */
    public function getBudgetAmountMicros()
    {
        return $this->budget_amount_micros;
    }

    /**
     * The simulated budget upon which projected metrics are based.
     *
     * Generated from protobuf field <code>int64 budget_amount_micros = 1;</code>
     * @param int|string $var
     * @return $this
     */
    public function setBudgetAmountMicros($var)
    {
        GPBUtil::checkInt64($var);
        $this->budget_amount_micros = $var;

        return $this;
    }

    /**
     * Projected required daily cpc bid ceiling that the advertiser must set to
     * realize this simulation, in micros of the advertiser currency.
     * Only campaigns with the Target Spend bidding strategy support this field.
     *
     * Generated from protobuf field <code>int64 required_cpc_bid_ceiling_micros = 2;</code>
     * @return int|string
     */
    public function getRequiredCpcBidCeilingMicros()
    {
        return $this->required_cpc_bid_ceiling_micros;
    }

    /**
     * Projected required daily cpc bid ceiling that the advertiser must set to
     * realize this simulation, in micros of the advertiser currency.
     * Only campaigns with the Target Spend bidding strategy support this field.
     *
     * Generated from protobuf field <code>int64 required_cpc_bid_ceiling_micros = 2;</code>
     * @param int|string $var
     * @return $this
     */
    public function setRequiredCpcBidCeilingMicros($var)
    {
        GPBUtil::checkInt64($var);
        $this->required_cpc_bid_ceiling_micros = $var;

        return $this;
    }

    /**
     * Projected number of biddable conversions.
     *
     * Generated from protobuf field <code>double biddable_conversions = 3;</code>
     * @return float
     */
    public function getBiddableConversions()
    {
        return $this->biddable_conversions;
    }

    /**
     * Projected number of biddable conversions.
     *
     * Generated from protobuf field <code>double biddable_conversions = 3;</code>
     * @param float $var
     * @return $this
     */
    public function setBiddableConversions($var)
    {
        GPBUtil::checkDouble($var);
        $this->biddable_conversions = $var;

        return $this;
    }

    /**
     * Projected total value of biddable conversions.
     *
     * Generated from protobuf field <code>double biddable_conversions_value = 4;</code>
     * @return float
     */
    public function getBiddableConversionsValue()
    {
        return $this->biddable_conversions_value;
    }

    /**
     * Projected total value of biddable conversions.
     *
     * Generated from protobuf field <code>double biddable_conversions_value = 4;</code>
     * @param float $var
     * @return $this
     */
    public function setBiddableConversionsValue($var)
    {
        GPBUtil::checkDouble($var);
        $this->biddable_conversions_value = $var;

        return $this;
    }

    /**
     * Projected number of clicks.
     *
     * Generated from protobuf field <code>int64 clicks = 5;</code>
     * @return int|string
     */
    public function getClicks()
    {
        return $this->clicks;
    }

    /**
     * Projected number of clicks.
     *
     * Generated from protobuf field <code>int64 clicks = 5;</code>
     * @param int|string $var
     * @return $this
     */
    public function setClicks($var)
    {
        GPBUtil::checkInt64($var);
        $this->clicks = $var;

        return $this;
    }

    /**
     * Projected cost in micros.
     *
     * Generated from protobuf field <code>int64 cost_micros = 6;</code>
     * @return int|string
     */
    public function getCostMicros()
    {
        return $this->cost_micros;
    }

    /**
     * Projected cost in micros.
     *
     * Generated from protobuf field <code>int64 cost_micros = 6;</code>
     * @param int|string $var
     * @return $this
     */
    public function setCostMicros($var)
    {
        GPBUtil::checkInt64($var);
        $this->cost_micros = $var;

        return $this;
    }

    /**
     * Projected number of impressions.
     *
     * Generated from protobuf field <code>int64 impressions = 7;</code>
     * @return int|string
     */
    public function getImpressions()
    {
        return $this->impressions;
    }

    /**
     * Projected number of impressions.
     *
     * Generated from protobuf field <code>int64 impressions = 7;</code>
     * @param int|string $var
     * @return $this
     */
    public function setImpressions($var)
    {
        GPBUtil::checkInt64($var);
        $this->impressions = $var;

        return $this;
    }

    /**
     * Projected number of top slot impressions.
     * Only search advertising channel type supports this field.
     *
     * Generated from protobuf field <code>int64 top_slot_impressions = 8;</code>
     * @return int|string
     */
    public function getTopSlotImpressions()
    {
        return $this->top_slot_impressions;
    }

    /**
     * Projected number of top slot impressions.
     * Only search advertising channel type supports this field.
     *
     * Generated from protobuf field <code>int64 top_slot_impressions = 8;</code>
     * @param int|string $var
     * @return $this
     */
    public function setTopSlotImpressions($var)
    {
        GPBUtil::checkInt64($var);
        $this->top_slot_impressions = $var;

        return $this;
    }

}

