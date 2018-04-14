<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 14/04/2018
 * Time: 00:14
 */

namespace Table\Drivers;


class Select extends Where
{
    protected $driver;

    public function setDriver( DriverStrategy $driver )
    {
        $this->driver = $driver;
        return $this;
    }

    protected function getDriver(): DriverStrategy
    {
        return $this->driver;
    }

    public function save()
    {
        $this->getDriver()
            ->save($this)
            ->exec();
    }

    public function findAll($field = "*", array $conditions = [] )
    {

        return $this->getDriver()
            ->where($this->where)
            ->where($this->between)
            ->concat($this->concat)
            ->like($this->like)
            ->setOrder($this->order)
            ->setLimit($this->limit)
            ->setOffset($this->offset)
            ->select($field)
            ->bind($conditions)
            ->exec()
            ->all();
    }

    public function findFirst( $id )
    {
        return $this->getDriver()
            ->select(['id' => $id])
            ->exec()
            ->first();
    }

    public function count($field, array $conditions = [] )
    {
        $Result = $this->getDriver()
            ->where($this->where)
            ->where($this->between)
            ->concat($this->concat)
            ->like($this->like)
            ->count($field)
            ->bind($conditions)
            ->exec()
            ->first();
        if(isset($Result['total'])):
            return $Result['total'];
        endif;
        return 0;
    }

    public function delete()
    {
        $this->getDriver()
            ->delete(['id' => $this->id])
            ->exec();
    }


}