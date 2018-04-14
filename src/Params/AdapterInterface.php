<?php

/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Table\Params;

interface AdapterInterface
{

    /**
     * Get page
     *
     * @return int
     */
    public function getPage();

    /**
     * Get order
     *
     * @return string
     */
    public function getOrder();

    /**
     * Get Item count per page
     *
     * @return int
     */
    public function getItemCountPerPage();

    /**
     * Get column name to order
     *
     * @return string | null
     */
    public function getColumn();

    /**
     * Get offset
     *
     * @return int
     */
    public function getOffset();

    /**
     * Get quick search
     *
     * @return string
     */
    public function getQuickSearch();

    /**
     * @param $status
     * @return AdapterDataTablesold
     */
    public function setStatus($status);


    /**
     * Get status
     *
     * @return mixed
     */
    public function getStatus();

    /**
     * Get status
     *
     * @return mixed
     */
    public function getStartDate();

    /**
     * Get status
     *
     * @return mixed
     */
    public function getEndDate();
}
