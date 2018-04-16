<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 20/03/2018
 * Time: 23:39
 */

namespace Table\Table;


use Table\Table\Exception\LogicException;

class StatusConfig
{
   // protected $status =["" => 'All', 1 => 'Active', 2 => 'Inactive', 3 => 'Trash'];
    protected $status =["" => 'All', 1 => 'Publicados'];
    public function add($name,$config){
        $this->status[$name] = $config;
        return $this;
    }

    public function getStatus(){
        return $this->status;
    }

    public function getStatu($name){
        if (!isset($this->status[$name])) {
            throw new LogicException("name {$name} not found!");
        }
        return $this->status[$name];
    }

    public function remove($name){
        if (!isset($this->status[$name])) {
            throw new LogicException("name {$name} not found!");
        }
        unset($this->status[$name]);
        return $this;
    }
}