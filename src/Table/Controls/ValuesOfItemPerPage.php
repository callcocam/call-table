<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 19/03/2018
 * Time: 22:36
 */

namespace Table\Table\Controls;



use Table\AbstractElement;

class ValuesOfItemPerPage extends AbstractElement
{
    /**
     * @var label do option
     */
    protected $statusLabel;
    /**
     * @var $statusAction estado do status ex 1,2,3
     */
    protected $statusAction;

    /**
     * @var string selected
     */
    protected $statusSelect = "";
    /**
     * @var $statusValue value option
     */
    protected $statusValue;
    /**
     * @var string $class
     */
    protected $class = "itemPerPage form-control input-lg";

    private $view;

    /**
     * Array of options
     *
     * @param $Value
     * @param $Label
     * @param $Status
     * @throws \Exception
     */
    public function __construct($Value, $Label,$Status)
    {

        $this->statusAction = $Status;
        $this->statusLabel = $Label;
        $this->statusValue = $Value;
    }

    /**
     * @param $view
     * @return ValuesOfItemPerPage
     */
    public function setView( $view )
    {
        $this->view = $view;
        return $this;
    }


    protected function initRendering()
    {
        if((int)$this->statusAction === (int)$this->statusValue):
            $this->statusSelect = "selected";
        endif;

    }

    /**
     * Rendering header element
     *
     * @return string
     */
    public function render()
    {
        $this->initRendering();
        return $this->view->render("/table/option",[
            'statusSelect' => $this->statusSelect,
            'statusValue' => $this->statusValue,
            'statusLabel' => $this->statusLabel,
        ]);
      }

    public function getClass(){
        return $this->class;
    }

}