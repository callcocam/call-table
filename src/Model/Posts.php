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


class Posts extends AbstractTable
{
    protected $defaultHeaders = [
        'post_cover' => ['tableAlias' => 'p', 'title' => 'Imagem', 'width' => '50', "sortable" => false, "ordering" => 1],
        'post_status' => ['tableAlias' => 'p', 'title' => 'Active', 'width' => 150, "sortable" => false, "order" => 5],
    ];


    public function __construct()
    {

        parent::__construct();

        $this->headers = (new HeadersConfig($this->defaultHeaders))
            ->add('post_title', ['tableAlias' => 'p', 'title' => 'Name'], 'post_cover')
            ->add('post_subtitle', ['tableAlias' => 'p', 'title' => 'Sub Titulo'], 'post_title')
            ->add('post_id', [ 'title' => '#', 'width' => '200', "sortable" => false ], 'post_status')
            ->getHeaders();

        $this->config = (new Config())
            ->add('name', 'Lista de makes')
            ->add('field_date', 'post_date')
            ->add('id', 'post_id')
            ->add('status', 'post_status')
            ->getConfigs();

        $this->valuesOfState = (new StatusConfig())->getStatus();

        $this->valuesOfItemPerPage = (new ItemPerPageConfig())->add(10, 10)->getItems();
        //Descomente para imagem
       $this->coverConfig = new ImgConfig();


    }

    public function init()
    {
        $this->buttonConfig = new ButtonsConfig();

        $this->getHeader('post_cover')->getCell()->addDecorator('img',[
            'vars'=>[
                'title'=>'post_title'
            ]
        ]);
//
        $this->getHeader('post_title')->getCell()->addDecorator('link', [
            'path'=>'posts',
            'action'=>'create',
            'vars' => 'post_id'
        ]);

//        $this->getHeader('coluna')->getCell()->addDecorator('callable', array(
//            'callable' => function ( $context, $record ) {
//                return $context ou $record->getColuna();
//            }
//        ));


        //$this->getHeader('post_id')->addDecorator('check');
        //$this->getHeader('post_id')->getCell()->addDecorator('check');
        $this->getHeader('post_status')->getCell()->addDecorator('state', [
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
            'id'=>'post_id',
            'campo_status'=>'post_status',
            'callback'=>'Posts',
            'callback_action'=>'manager_status'])->setName("status")
            ->setStatus([0,1,2,3])
            ->add("status");

        $this->buttonConfig->setVars([
            'id'=>'post_id',
            'campo_status'=>'post_status',
            'action'=>'admin/dashboard.php?wc=posts/create&id='])->setName("editar")
            ->add("editar");

        $this->buttonConfig->setVars([
            'id'=>'post_id',
            'campo_status'=>'post_status',
            'callback'=>'Posts',
            'callback_action'=>'delete',
        ])->setName("excluir")
            ->setStatus([0,1,2,3])
            ->add("excluir");

        $this->getHeader('post_id')->getCell()->addDecorator('btn', [
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