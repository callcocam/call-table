<?php

/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Table\Decorator;

interface DataAccessInterface
{
    /**
     * Interface dedicated for Cells and Rows decorators,
     *
     * used to retrieve actual row in rendering process
     * Header decorators are not taken into consideration
     *
     * @return mixed
     */
    public function getActualRow();
}
