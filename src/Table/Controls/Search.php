<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 20/03/2018
 * Time: 12:14
 */

namespace Table\Table\Controls;


use Table\AbstractElement;

class Search extends AbstractElement
{
    private $quickSearch = "";
    private $view;

    /**
     * Array of options
     *
     * @param $quickSearch
     */
    public function __construct($quickSearch)
    {

        $this->quickSearch = $quickSearch;
    }

    /**
     * @param $view
     * @return Search
     */
    public function setView( $view )
    {
        $this->view = $view;
        return $this;
    }

    protected function initRendering()
    {

    }

    /**
     * Rendering header element
     *
     * @return string
     */
    public function render()
    {
        $this->initRendering();

        return $this->view->render("/table/search",[
            'quickSearch' => $this->quickSearch
        ]);
    }
}