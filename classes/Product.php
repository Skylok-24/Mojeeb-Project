<?php

namespace classes;

class Product extends Services
{
    public function all()
    {
        return [
            ['name' => 'Phone' , 'price' => 500 ],
            ['name' => 'Mouse' , 'price' => 50 ],
            ['name' => 'Keyboard' , 'price' => 100 ],
        ];
    }
}