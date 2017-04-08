<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    const TABLE_NAME = 'product';
    const RELATION_VOUCHERS = 'vouchers';

    const MAX_DISCOUNT = 0.6;

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
     * @return Voucher[]
     */
    public function getVouchers()
    {
        return $this->getRelationValue(self::RELATION_VOUCHERS);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return (int) $this->attributes['id'];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->attributes['name'];
    }

    /**
     * @param string $name
     *
     * @return Product
     */
    public function setName(string $name)
    {
        $this->attributes['name'] = $name;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return (float) $this->attributes['price'];
    }

    /**
     * @param float $price
     *
     * @return Product
     */
    public function setPrice(float $price)
    {
        $this->attributes['price'] = $price;

        return $this;
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
     * @return Product
     */
    public function setActive(bool $active)
    {
        $this->attributes['is_active'] = (int) $active;

        return $this;
    }

    /**
     * @return BelongsToMany
     */
    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class);
    }

    /**
     * @return float
     */
    public function getPriceWithDiscount()
    {
        $discountSum = $this->getDiscountSum();
        if ($discountSum > self::MAX_DISCOUNT) {
            $discountSum = self::MAX_DISCOUNT;
        }

        return $this->getPrice() * (1 + $discountSum);
    }

    /**
     * @return float
     */
    private function getDiscountSum()
    {
        $discountSum = 0;
        foreach ($this->getVouchers() as $voucher) {
            if ($voucher->isApplicable()) {
                $discountSum += $voucher->getDiscountValue();
            }
        }

        return $discountSum;
    }
}
