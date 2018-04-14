<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 20/03/2018
 * Time: 20:31
 */

namespace Table\Table;


use Table\Table\Exception\LogicException;

class Config
{

    protected $config =[
        'id' => 'id',
        'name' => 'Lisa Tables',
        'showPagination' => true,
        'showQuickSearch' => true,
        'showItemPerPage' => true,
        'showDateFilters' => true,
    ];
    public function add($name,$config){
        $this->config[$name] = $config;
        return $this;
    }

    public function getConfigs(){
        return $this->config;
    }

    public function getConfig($name){
        if (!isset($this->config[$name])) {
            throw new LogicException("name {$name} not found!");
        }
        return $this->config[$name];
    }

    public function remove($name){
        if (!isset($this->config[$name])) {
            throw new LogicException("name {$name} not found!");
        }
        unset($this->config[$name]);
        return $this;
    }
}