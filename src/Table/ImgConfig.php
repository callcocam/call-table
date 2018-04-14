<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 21/03/2018
 * Time: 06:45
 */

namespace Table\Table;


class ImgConfig
{

    protected $vars = ["img"=>"cover"];

    /**
     * @param array $value
     * @return ImgConfig
     */
    public function add($key,$value){

        $this->vars[$key] = $value;
        return $this;
    }

    public function getConfig(){
        return $this->Img;
    }

    /**
     * @param string $vars
     * @return ImgConfig
     */
    public function setVars( string $vars ): ImgConfig
    {
        $this->vars = $vars;
        return $this;
    }

    /**
     * @return string
     */
    public function getVars(): string
    {
        return $this->vars;
    }

}