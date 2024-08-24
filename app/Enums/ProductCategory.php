<?php

namespace App\Enums;

enum ProductCategory : int
{
    case ELECTRONIC = 1;
    case CLOTHING = 2;
    case HOME_FURNITURE = 3;
    case BEAUTY_PERSONAL_CARE = 4;
    case SPORT_OUTDOOR = 5;

    /**
     * Shows the proper label after casting
     */
    public function label() : string
    {
        return match($this)
        {
            self::ELECTRONIC => 'Electonics',
            self::CLOTHING => 'Clothing',
            self::HOME_FURNITURE => 'Home & Furnitures',
            self::BEAUTY_PERSONAL_CARE => 'Beauty & Personal Care',
            self::SPORT_OUTDOOR => 'Sports & Outdoors'
        };
    }

    /**
     * Populate select options for categories
     * 
     * @return array
     */
    static function getOptions() {
        $items = [];

        foreach (self::cases() as $case) {
            $items[$case->value] = $case->label();
        }

        return $items;
    }
}