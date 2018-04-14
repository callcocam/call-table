<?php

/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */


namespace Table\Options;

interface PaginatorInterface
{

    /**
     * Get Array of values to set items per page
     * @return array
     */
    public function getValuesOfItemPerPage();

    /**
     *
     * Set Array of values to set items per page
     *
     * @param array $valuesOfItemPerPage
     * @return self
     */
    public function setValuesOfItemPerPage($valuesOfItemPerPage);
}
