<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 19/03/2018
 * Time: 17:45
 */

namespace Table;



class SelectInput extends AbstractElement
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
    protected $class = "form-control %s";
    protected $name;
    private $view;

    /**
     * Array of options
     *
     * @param $Label
     * @param $Value
     * @param $Status
     */
    public function __construct($name,$Label, $Value, $Status)
    {

        $this->statusLabel = $Label;
        $this->statusValue = $Value;
        $this->statusAction = $Status;
        $this->name = $name;
    }


    /**
     * @param $view
     * @return SelectInput
     */
    public function setView( $view )
    {
        $this->view = $view;
        return $this;
    }
    protected function initRendering()
    {

        if($this->statusAction === $this->statusValue):
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

    public function setClass($class){
        $this->class = sprintf($this->class, $class);
    }
}