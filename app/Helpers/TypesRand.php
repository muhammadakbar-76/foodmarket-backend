<?php

namespace App\Helpers;

class TypesRand {
    public static function random(){
        $types = ["Fruit", "Meat", "Vegetables", "Junk Food","Snack"];
        return $types[rand(0,4)];
    }
}
?>