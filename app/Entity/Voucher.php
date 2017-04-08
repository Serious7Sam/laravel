<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Voucher extends Model
{
    const TABLE_NAME = 'voucher';
    const RELATION_DISCOUNT = 'discount';

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = self::TABLE_NAME;
        $this->timestamps = false;
    }

    /**
     * @return Discount
     */
    public function getDiscount()
    {
        return $this->getRelationValue(self::RELATION_DISCOUNT);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return (int) $this->attributes['id'];
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return \DateTime::createFromFormat('Y-m-d', $this->attributes['start_date']);
    }

    /**
     * @param \DateTime $startDate
     *
     * @return $this
     */
    public function setStartDate(\DateTime $startDate)
    {
        $this->attributes['start_date'] = $startDate->format('Y-m-d');

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return \DateTime::createFromFormat('Y-m-d', $this->attributes['end_date']);
    }

    /**
     * @param \DateTime $endDate
     *
     * @return $this
     */
    public function setEndDate(\DateTime $endDate)
    {
        $this->attributes['end_date'] = $endDate->format('Y-m-d');

        return $this;
    }

    /**
     * @return BelongsTo
     */
    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return (bool) $this->attributes['is_active'];
    }

    /**
     * @param bool $active
     *
     * @return Voucher
     */
    public function setActive(bool $active)
    {
        $this->attributes['is_active'] = (int) $active;

        return $this;
    }

    /**
     * @return float
     */
    public function getDiscountValue()
    {
        return $this->getDiscount()->getValue();
    }

    /**
     * @return bool
     */
    public function isApplicable()
    {
        if (!$this->isActive()) {
            return false;
        }

        $now = new \DateTime();

        return $now >= $this->getStartDate() && $now <= $this->getEndDate();
    }
}
