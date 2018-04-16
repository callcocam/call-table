<?php

/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */


namespace Table\Params;

use Core\Table\Table\Exception;
use Table\Table\Exception\InvalidArgumentException;

class AdapterArrayObject extends AbstractAdapter implements AdapterInterface
{

    /**
     *
     * @var \ArrayObject | ArrayObject
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


     /**
     * Array of filters
     * @var array
     */
    protected $filters;
    /**
     * @var $status int
     *  status do registro
     */
    protected $status;
    /**
     * @var $start_date \DateTime
     * data incio da pesquisa
     */
    protected $start_date;
    /**
     * @var $end_date \DateTime
     * data final da pesquisa
     */
    protected $end_date;
    const DEFAULT_STATUS = 1;
    const DEFAULT_PAGE = 1;
    const DEFAULT_ORDER = 'asc';
    const DEFAULT_ITEM_COUNT_PER_PAGE = 10;



    public function __construct($object)
    {
        if (is_array($object)) {
            $this->object = new \ArrayObject($object);
        } else {
            throw new InvalidArgumentException('parameter must be instance of ArrayObject');
        }
    }

    /**
     * Init method
     */
    public function init()
    {
        $array = (method_exists($this->object, 'toArray')) ? $this->object->toArray() : $this->object->getArrayCopy();
        $this->page = (isset($array['zfTablePage'])) ? $array['zfTablePage'] : self::DEFAULT_PAGE;
        $this->column = (isset($array['zfTableColumn'])) ? $array['zfTableColumn'] : null;
        $this->order = (isset($array['zfTableOrder'])) ? $array['zfTableOrder'] : self::DEFAULT_ORDER;
        $this->status = (isset($array['zfTableStatus'])) ? $array['zfTableStatus'] : self::DEFAULT_STATUS;
        $this->start_date = (isset($array['zfTableStartDate'])) ? $array['zfTableStartDate'] : '';
        $this->end_date = (isset($array['zfTableEndDate'])) ? $array['zfTableEndDate'] : '';
        $this->itemCountPerPage = (isset($array['zfTableItemPerPage']))
            ? $array['zfTableItemPerPage'] : $this->getOptions()->getItemCountPerPage();
        $this->quickSearch = (isset($array['zfTableQuickSearch'])) ? $array['zfTableQuickSearch'] : '';

    }

    public function getPureValueOfFilter($key)
    {
        return $this->object[$key];
    }

    public function getValueOfFilter($key, $prefix = 'zff_')
    {
        return $this->filters[$prefix . $key];
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
     * @param string $page
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
     * @param $order
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
     * @param $status
     * @return AdapterArrayObject
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param \DateTime $start_date
     * @return AdapterArrayObject
     */
    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;
        return $this;
    }

    /**
     * @param \DateTime $end_date
     * @return AdapterArrayObject
     */
    public function setEndDate($end_date)
    {
        $this->end_date = $end_date;
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

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->end_date;
    }




}
