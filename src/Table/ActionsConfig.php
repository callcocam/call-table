<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 20/03/2018
 * Time: 19:48
 */

namespace Table\Table;


use Table\Table\Exception\LogicException;

class ActionsConfig
{

    protected $actions = [
        'add' => [
            "label" => "Adicionar",
            "state"=>['',0,1,2,3]
        ],
        'active' => [
            "label" => "Ativar",
            "state"=>['',0,2,3]
        ],
        'inactive' => [
            "label" => "Desabilitar",
            "state"=>['',1,3]
        ],
        "trash" =>[
            "label" => "Enviar p/ Lixeira",
            "state"=>['',0,1,2]
        ] ,
        'trashall' => [
            "label" => "Esvaziar Lixeira",
            "state"=>[3]
        ],
        'csv' => [
            "label" => "Exportar",
            "state"=>['',1]
        ],
        'ajuda' => [
            "label" => "Ajuda",
            "state"=>['',0,1,2,3]
        ]
    ];

    public function add($name,array $button = []){
       $this->actions[$name] = array_merge($this->actions[$name], $button);
       return $this;
    }

    public function getActions(){
        return $this->actions;
    }

    public function getAction($name){
        if (!isset($this->actions[$name])) {
            throw new LogicException("name {$name} not found!");
        }
        return $this->actions[$name];
    }

    public function remove($name){
        if (!isset($this->actions[$name])) {
            throw new LogicException("name {$name} not found!");
        }
        unset($this->actions[$name]);
        return $this;
    }
}