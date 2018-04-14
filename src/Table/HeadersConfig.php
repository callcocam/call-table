<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 20/03/2018
 * Time: 20:31
 */

namespace Table\Table;


use Table\Table\Exception\LogicException;

class HeadersConfig
{

    /**
     * @var array Definition of headers
     */
    protected $defaultHeaders = [];
    public function __construct($defaultHeaders)
    {
        $this->defaultHeaders = $defaultHeaders;
    }

    /**
     * @var array Definition of headers
     */
    protected $headers = [];

    public function add($name,array $header , $position,$join=null){


        $this->headers=[];
        foreach ($this->defaultHeaders as $index => $defaultHeader) {
            $this->headers[$index] = $defaultHeader;
            if($position == $index){
                $this->headers[$name] = $header;
            }
         }
        if($join){
            $this->headers[$name]['join'] = $join;
        }
         $this->defaultHeaders = $this->headers;
        return $this;
    }

    public function getHeaders(){
        if(!$this->headers){
            $this->headers = $this->defaultHeaders;
        }
        return $this->headers;
    }

    public function getHeader($name){
        if (!isset($this->headers[$name])) {
            throw new LogicException("name {$name} not found!");
        }
        return $this->headers[$name];
    }

    public function remove($name){
        if (!isset($this->headers[$name])) {
            throw new LogicException("name {$name} not found!");
        }
        unset($this->headers[$name]);
        return $this;
    }
}