<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 14/04/2018
 * Time: 00:13
 */

namespace Table\Drivers;


use Table\Select;

interface DriverStrategy
{

//    public function save(Model $data);
//    public function insert(Model $data);
//
//    public function update( Model $data );;
    public function select(array $data = []);
//    public function delete(array $data);
    public function exec(string $query = null);
    public function first();
    public function all();

}