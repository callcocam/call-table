<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 19/03/2018
 * Time: 14:29
 */

namespace Table\Table\Controls;



use Table\AbstractElement;

class Actions extends AbstractElement
{

  /**
     * Table of options
     *
     * @var array
     */
    protected $options = [];

    private $status;

    protected $actionState;

    private $view;

    private $name;


    /**
     * Array of options
     *
     * @param string $name
     * @param array $options
     * @param $status
     */
    public function __construct( $name, $options = [], $status )
    {
        $this->name = $name;
        $this->setOptions($options);
        $this->status = $status;
    }

    /**
     * Set options like title, width, order
     *
     * @param array $options
     * @return $this
     */
    public function setOptions( $options )
    {
        $this->actionState = (isset($options['state'])) ? $options['state'] : [];
       return $this;
    }

    /**
     * @param $view
     * @return Actions
     */
    public function setView( $view )
    {
        $this->view = $view;
        return $this;
    }
    /**
     * Init header (like asc, desc, column name )
     */
    protected function initRendering( $gerarBtn )
    {


    }
    /**
     * Rendering header element
     *
     * @return string
     */
    public function render(  )
    {
        $gerarBtn = false;
        foreach ($this->actionState as $item) {
            if ($item == $this->status) {
                $gerarBtn = true;
            }
        }
        if ($gerarBtn):
            $this->initRendering($gerarBtn);
            return $this->view->render(sprintf("/table/actions/actions-%s",$this->name),[
                'router'=>$this->getTable()->getRoute()
            ]);
        endif;
        return "";
    }
}