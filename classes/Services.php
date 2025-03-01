<?php

namespace classes;

class Services
{
    public $available = false;
    protected $type ;
    private $price;
    public $taxRate = 0;

    public function __construct()
    {
        $this->available = true;
    }

    public function __destruct()
    {
//        echo "This class '". __CLASS__ ."'was destructed";
    }

    public function all()
    {
        return [
            ['name' => 'Consultation' , 'price' => 500 , 'days' => ['Sun','Mon']],
            ['name' => 'Training' , 'price' => 200 , 'days' => ['Tues','Wed']],
            ['name' => 'Design' , 'price' => 100 , 'days' => ['Thu','Fri']]
        ];
    }

    public function price($price)
    {
        if ($price > 0) {
            return $price + ($this->taxRate * $price);
        }
        return $price;
    }
}