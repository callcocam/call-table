<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 20/03/2018
 * Time: 13:12
 */

namespace Table\Table\Controls;



use Table\AbstractElement;

class DateFilters extends AbstractElement
{
    protected $dateSearch ='Buscar Por Data';
    protected $start='';
    protected $end='';
    protected $end_date;
    protected $dateFormatLong;
    private $view;

    /**
     * Array of options
     *
     * @param $start_date
     * @param $end_date
     */
    public function __construct($start_date, $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    /**
     * @param $view
     * @return DateFilters
     */
    public function setView( $view )
    {
        $this->view = $view;
        return $this;
    }
    /**
     * Init header (like asc, desc, column name )
     */

    /**
     *
     */
    protected function initRendering()
    {
         if(!empty($this->start_date) && !empty($this->start_date)):
            $start_date = date_create($this->start_date);
            $end_date = date_create($this->end_date);
            $this->start  = date_format($start_date, 'd/m/Y');
            $this->end  = date_format($end_date, 'd/m/Y');
            $this->dateSearch  = '-';
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
        return $this->view->render("/table/date-time-piker",[
            'start' => $this->start,
            'end' => $this->end,
            'dateSearch' => $this->dateSearch,
        ]);
    }
}