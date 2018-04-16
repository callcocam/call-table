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
            ->add('post_views', ['tableAlias' => 'p', 'title' => 'Visualisaçõe'], 'post_title')
            ->add('post_tags', ['tableAlias' => 'p', 'title' => 'Visualisaçõe'], 'post_views')
            ->add('post_category', ['tableAlias' => 'p', 'title' => 'Visualisaçõe'], 'post_tags')
            ->add('post_id', ['title' => '#', 'width' => '200', "sortable" => false], 'post_status')
            ->getHeaders();

        $this->config = (new Config())
            ->add('name', 'Lista de Posts')
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

        $this->getHeader('post_cover')->getCell()->addDecorator('img', [
            'vars' => [
                'title' => 'post_title'
            ]
        ]);
//
        $this->getHeader('post_title')->getCell()->addDecorator('link', [
            'path' => 'posts',
            'action' => 'create',
            'vars' => 'post_id'
        ]);

        $this->getHeader('post_tags')->getCell()->addDecorator('callable', array(
            'callable' => function ( $context, $record ) {
                $postTags = null;
                $S = filter_input(INPUT_GET, "s", FILTER_DEFAULT);
                $C = filter_input(INPUT_GET, "cat", FILTER_DEFAULT);
                if ($context):
                    foreach (explode(",", $context) AS $tags):
                        $tag = ltrim(rtrim($tags));
                        $postTags .= "<a class='icon-price-tag radius' title='Artigos marcados com {$tag}' href='dashboard.php?wc=posts/home&s={$S}&cat={$C}&tag=" . urlencode($tag) . "'>{$tag}</a>";
                    endforeach;
                endif;
                return $postTags;
            }
        ));
        $this->getHeader('post_category')->getCell()->addDecorator('callable', array(
            'callable' => function ( $context, $record ) {
                $Read = new \Read();
                extract($record);

                $S = filter_input(INPUT_GET, "s", FILTER_DEFAULT);
                $T = filter_input(INPUT_GET, "tag", FILTER_DEFAULT);
                $Category = null;
                if (!empty($post_category)):
                    $Read->FullRead("SELECT category_id, category_title FROM " . DB_CATEGORIES . " WHERE category_id = :ct", "ct={$post_category}");
                    if ($Read->getResult()):
                        $Category = "<span class='icon-bookmark'><a title='Artigos em {$Read->getResult()[0]['category_title']}' href='dashboard.php?wc=posts/home&s={$S}&cat={$Read->getResult()[0]['category_id']}&tag=" . urlencode($T) . "'>{$Read->getResult()[0]['category_title']}</a></span> ";
                    endif;
                endif;

                if (!empty($post_category_parent)):
                    $Read->FullRead("SELECT category_title, category_id FROM " . DB_CATEGORIES . " WHERE category_id IN({$post_category_parent})");
                    if ($Read->getResult()):
                        foreach ($Read->getResult() as $SubCat):
                            $Category .= "<span class='icon-bookmarks'><a title='Artigos em {$SubCat['category_title']}' href='dashboard.php?wc=posts/home&s={$S}&cat={$SubCat['category_id']}&tag=" . urlencode($T) . "'>{$SubCat['category_title']}</a></span> ";
                        endforeach;
                    endif;
                endif;
                return $Category;
            }
        ));


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
            'id' => 'post_id',
            'campo_status' => 'post_status',
            'callback' => 'Posts',
            'callback_action' => 'manager_status'])->setName("status")
            ->setStatus([0, 1, 2, 3])
            ->add("status");

        $this->buttonConfig->setVars([
            'id' => 'post_id',
            'campo_status' => 'post_status',
            'action' => 'admin/dashboard.php?wc=posts/create&id='])->setName("editar")
            ->add("editar");

        $this->buttonConfig->setVars([
            'id' => 'post_id',
            'campo_status' => 'post_status',
            'callback' => 'Posts',
            'callback_action' => 'delete',
        ])->setName("excluir")
            ->setStatus([0, 1, 2, 3])
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