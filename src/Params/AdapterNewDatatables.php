<?php

/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Table\Params;

use Table\Exception\InvalidArgumentException;
use Table\Params\AbstractAdapter;
use Table\Params\AdapterInterface;
use Table\Table\Exception;

class AdapterNewDatatables extends AbstractAdapter implements
    AdapterInterface
{

    /**
     *
     * @var \ArrayObject
     */
    protected $object;

    /**
     *
     * @var int
     */
    protected $page;

    /**
     *
     * @var string
     */
    protected $order;

    /**
     *
     * @var string
     */
    protected $column;

    /**
     *
     * @var int
     */
    protected $itemCountPerPage;

    /**
     * Quick search
     * @var string
     */
    protected $quickSearch;

    const DEFAULT_PAGE = 1;
    const DEFAULT_ORDER = 'asc';
    const DEFAULT_ITEM_COUNT_PER_PAGE = 2;

    public function __construct($object)
    {
        if ($object instanceof \ArrayObject) {
            $this->object = $object;
        } else {
            throw new InvalidArgumentException('parameter must be instance of ArrayObject');
        }
    }

    /**
     * Init method
     */
    public function init()
    {
        $array = $this->object->toArray();

        $this->page = (isset($array['start'])) ? ($array['start'] / $array['length'] + 1) : self::DEFAULT_PAGE;


        if (isset($array['order'][0]['column'])) {
            $headers = $this->getTable()->getHeaders();
            $slice = array_slice($headers, $array['order'][0]['column'], 1);
            $this->column = key($slice);
        }
        $this->order = (isset($array['order'][0]['dir'])) ? $array['order'][0]['dir'] : self::DEFAULT_ORDER;
        $this->itemCountPerPage = (isset($array['start'])) ? $array['length'] : 20;
        $this->quickSearch = (isset($array['columns']['search']['value'])) ? $array['columns']['search']['value'] : '';
    }

    /**
     * Get page
     *
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set page
     *
     * @param int $page
     * @return $this
     */
    public function setPage($page)
    {
        $this->page = $page;
        return $this;
    }

    /**
     * Get order
     *
     * @return string
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set asc or desc ordering
     *
     * @param string $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * Get column
     *
     * @return string
     */
    public function getColumn()
    {
        return ($this->column == '') ? null : $this->column;
    }

    /**
     *
     * @param string $column
     * @return $this
     */
    public function setColumn($column)
    {
        $this->column = $column;
        return $this;
    }

    /**
     * Get item count per page
     *
     * @return int
     */
    public function getItemCountPerPage()
    {
        return $this->itemCountPerPage;
    }

    /**
     *
     * @param int $itemCountPerPage
     */
    public function setItemCountPerPage($itemCountPerPage)
    {
        $this->itemCountPerPage = $itemCountPerPage;
    }

    /**
     * Return offset
     *
     * @return int
     */
    public function getOffset()
    {
        return ($this->getPage() * $this->getItemCountPerPage()) - $this->getItemCountPerPage();
    }

    /**
     * Get quick search string
     *
     * @return string
     */
    public function getQuickSearch()
    {
        return $this->quickSearch;
    }

    public function getPureValueOfFilter($key)
    {
        return $this->object[$key];
    }

    /**
     * @param $status
     * @return AdapterDataTablesold
     */
    public function setStatus( $status )
    {
        // TODO: Implement setStatus() method.
    }

    /**
     * Get status
     *
     * @return mixed
     */
    public function getStatus()
    {
        // TODO: Implement getStatus() method.
    }

    /**
     * Get status
     *
     * @return mixed
     */
    public function getStartDate()
    {
        // TODO: Implement getStartDate() method.
    }

    /**
     * Get status
     *
     * @return mixed
     */
    public function getEndDate()
    {
        // TODO: Implement getEndDate() method.
    }
}
