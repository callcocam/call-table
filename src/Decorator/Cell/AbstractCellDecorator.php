<?php

/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Table\Decorator\Cell;

use Table\Decorator\AbstractDecorator;
use Table\Decorator\DataAccessInterface;

abstract class AbstractCellDecorator extends AbstractDecorator implements DataAccessInterface
{

    /**
     * Get view
      */
    protected $view;
    /**
     * Get cell object
      */
    protected $cell;

    /**
      */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @param ViewModel $view
     * @return AbstractCellDecorator
     */
    public function setView( $view ): AbstractCellDecorator
    {
        $this->view = $view;
        return $this;
    }


    /**
     *
     * @return \Table\Cell
     */
    public function getCell()
    {
        return $this->cell;
    }

    /**
     *
     * @param \Table\Cell $cell
     * @return $this
     */
    public function setCell($cell)
    {
        $this->cell = $cell;
        return $this;
    }


    /**
     * Actual row data
     *
     * @return array
     */
    public function getActualRow()
    {
        return $this->getCell()->getActualRow();
    }
}
