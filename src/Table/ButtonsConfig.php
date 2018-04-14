<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 21/03/2018
 * Time: 00:00
 */

namespace Table\Table;


class ButtonsConfig
{

    protected $name;
    protected $vars = ['id'=>'id','campo_status'=>'status'];
    protected $status = [1];
    protected $btn = [];



    /**
     * @param $name
     * @return ButtonsConfig
     */
    public function add($name){
        $this->btn[$name] = [
            'status' => $this->getStatus(),
            'vars' => $this->getVars()
        ];
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return ButtonsConfig
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return array
     */
    public function getVars()
    {
        return $this->vars;
    }

    /**
     * @param string $vars
     * @return ButtonsConfig
     */
    public function setVars( $vars)
    {
        $this->vars = $vars;
        return $this;
    }

    /**
     * @return array
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param array $status
     * @return ButtonsConfig
     */
    public function setStatus(array $status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return array
     */
    public function getBtn()
    {
        return $this->btn;
    }


}