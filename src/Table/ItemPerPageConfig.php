<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 20/03/2018
 * Time: 23:42
 */

namespace Table\Table;


use Table\Table\Exception\LogicException;

class ItemPerPageConfig
{
    protected $Items =[5=>5, 10=>10, 20=>20, 50=>50 , 100=>100];
    public function add($value,$label){
        $this->Items[$value] = $label;
        ksort($this->Items);
        return $this;
    }

    public function getItems(){
        return $this->Items;
    }

    public function getItem($value){
        if (!isset($this->Items[$value])) {
            throw new LogicException("name {$value} not found!");
        }
        return $this->Items[$value];
    }

    public function remove($value){
        if (!isset($this->Items[$value])) {
            throw new LogicException("name {$value} not found!");
        }
        unset($this->Items[$value]);
        return $this;
    }
}