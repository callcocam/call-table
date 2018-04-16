<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 13/04/2018
 * Time: 08:42
 */

namespace Table\Model;


use Table\AbstractTable;
use Table\Table\ActionsConfig;
use Table\Table\ButtonsConfig;
use Table\Table\Config;
use Table\Table\HeadersConfig;
use Table\Table\ImgConfig;
use Table\Table\ItemPerPageConfig;
use Table\Table\StatusConfig;


class Cidades extends AbstractTable
{
    protected $defaultHeaders = [
        'cover' => ['tableAlias' => 'p', 'title' => 'Imagem', 'width' => '50', "sortable" => false, "ordering" => 1],
        'status' => ['tableAlias' => 'p', 'title' => 'S', 'width' => 25, "sortable" => false, "order" => 5],
    ];


    public function __construct()
    {

        parent::__construct();

        //tableAlias os campos que realmente estão na tabela do banco
        $this->headers = (new HeadersConfig($this->defaultHeaders))
            ->add('title', ['tableAlias' => 'p', 'title' => 'Name'], 'cover')
            ->add('uf', ['tableAlias' => 'p', 'title' => 'Uf'], 'title')
            ->add('ibge', ['tableAlias' => 'p', 'title' => 'ibge', 'width' => '50'], 'uf')
            ->add('cep', ['tableAlias' => 'p', 'title' => 'Categorias'], 'ibge')
            ->add('cpais', ['tableAlias' => 'p', 'title' => 'Tags'], 'cep')
            ->add('id', ['title' => '#', 'width' => '200', "sortable" => false], 'cpais')
            ->getHeaders();

        $this->config = (new Config())
            ->add('name', 'Cidades')
            ->add('field_date', 'created_at')
            ->add('id', 'id')
            ->add('status', 'status')
            ->getConfigs();

        $this->valuesOfState = (new StatusConfig())->getStatus();

        $this->valuesOfItemPerPage = (new ItemPerPageConfig())->add(10, 10)->getItems();
        //Descomente para imagem
        $this->coverConfig = new ImgConfig();


    }

    public function init()
    {
        $this->buttonConfig = new ButtonsConfig();

        $this->getHeader('cover')->getCell()->addDecorator('img', [
            'vars' => [
                'title' => 'title'
            ]
        ]);
//
        $this->getHeader('title')->getCell()->addDecorator('link', [
            'path' => 'posts',
            'action' => 'create',
            'vars' => 'id'
        ]);

        //$this->getHeader('id')->addDecorator('check');
        //$this->getHeader('id')->getCell()->addDecorator('check');
        $this->getHeader('status')->getCell()->addDecorator('state', [
            'value' => [
                '1' => 'Active',
                '2' => 'Desactive',
                '0' => 'Desactive',
                '3' => 'Trash',
            ],
            'class' => [
                '1' => 'green',
                '2' => 'yellow',
                '0' => 'yellow',
                '3' => 'red',
            ],
        ]);


        $this->buttonConfig->setVars([
            'id' => 'id',
            'campo_status' => 'status',
            'callback' => 'Cidades',
            'callback_action' => 'manager_status'])->setName("status")
            ->setStatus([0, 1, 2, 3])
            ->add("status");

        $this->buttonConfig->setVars([
            'id' => 'id',
            'campo_status' => 'status',
            'action' => 'admin/dashboard.php?wc=cidades/create&id='])->setName("editar")
            ->add("editar");

        $this->buttonConfig->setVars([
            'id' => 'id',
            'campo_status' => 'status',
            'callback' => 'Cidades',
            'callback_action' => 'delete',
        ])->setName("excluir")
            ->setStatus([0, 1, 2, 3])
            ->add("excluir");

        $this->getHeader('id')->getCell()->addDecorator('btn', [
            'params' => $this->getParams(),
            'url' => $this->buttonConfig,
        ]);
    }

    //The filters could also be done with a parametrised query
    protected function initFilters( $query )
    {
        // var_dump($query);
    }

}