<?php

/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Table\Decorator\Row;

use Table\Decorator\AbstractDecorator;
use Table\Decorator\DataAccessInterface;

abstract class AbstractRowDecorator extends AbstractDecorator implements DataAccessInterface
{

    /**
     * Row object
     * @var \Table\Row
     */
    protected $row;

    /**
     *
     * @return \Table\Row
     */
    public function getRow()
    {
        return $this->row;
    }

    /**
     *
     * @param \Table\Row $row
     * @return $this
     */
    public function setRow($row)
    {
        $this->row = $row;
        return $this;
    }

    /**
     * Get actual row
     * @return array
     */
    public function getActualRow()
    {
        return $this->getRow()->getActualRow();
    }
}
