<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    const TABLE_NAME = 'discount';

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
     * @return Discount
     */
    public function setName(string $name)
    {
        $this->attributes['name'] = $name;

        return $this;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return (float) $this->attributes['value'];
    }

    /**
     * @param float $value
     *
     * @return Discount
     */
    public function setValue(float $value)
    {
        $this->attributes['value'] = $value;

        return $this;
    }
}
