<?php

/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Table\Source;

use Table\AbstractCommon;
use Table\Drivers\DriverStrategy;
use Table\Drivers\Select;
use Table\Paginator\Range;
use Table\Params\AdapterInterface;

class AbstractSource extends AbstractCommon implements SourceInterface
{

    /**
     *
     * @var \Table\Params\AdapterInterface
     */
    protected $paramAdapter;
    /**
     *
     * @var DriverStrategy
     */
    protected $arraySource;
    protected $query = "";
    /**
     * @var \Pager
     */
    protected $paginator;
    protected $queryParams = [];
    protected $ParseString = [];
    protected $fields = ["*"];

    /**
     *
     * @param Select $arraySource
     */
    public function __construct( Select $arraySource )
    {
        $this->arraySource = $arraySource;

    }

    /**
     * @return \Table\Params\AdapterInterface
     */
    public function getParamAdapter()
    {
        if (!$this->paramAdapter) {
            $this->paramAdapter = $this->getTable()->getParamAdapter();
        }
        return $this->paramAdapter;
    }

    /**
     *
     * @return Paginator
     * @throws \Exception
     */
    public function getData()
    {
        $this->quickSearch();
        $this->order();
        if ($this->getTable()->getOptions()->getShowPagination()) {
            $this->getPaginator();
        }
        return $this->getSource();
    }


    /**
     *
     * @param Paginator $paginator
     */
    public function setPaginator( $paginator )
    {
        $this->paginator = $paginator;
    }

    /**
     *
     * @param AdapterInterface $paramAdapter
     */
    public function setParamAdapter( AdapterInterface $paramAdapter )
    {
        $this->paramAdapter = $paramAdapter;
    }


    /**
     *
     */
    public function getPaginator()
    {

        if (!$this->paginator) {
            $Total = $this->arraySource->count($this->getTable()->getOptions()->getId());
            $perPage = $this->getParamAdapter()->getItemCountPerPage();
            $this->paginator = new Range($Total, $perPage, 10);
            $this->arraySource->getOffset($this->getParamAdapter()->getOffset());
            $this->arraySource->getLimit($this->paginator->getPerPage());
        }
        return $this->paginator;
    }

    /*
         * Init quick search
         */
    protected function quickSearch()
    {
        $concatFields = array_keys($this->getTable()->getHeaders());
        $anyKeyword = $this->getParamAdapter()->getQuickSearch();
        if (!empty($anyKeyword)):
            foreach ($concatFields as $field) {
                $header = $this->getTable()->getHeader($field);
                if (!empty($header->getTableAlias())) {
                    $this->fields[$field] = $field;
                }
            }
            $this->arraySource->setConcat(array_keys($this->fields), $anyKeyword);
        endif;
        if ($this->getTable()->getParamAdapter()->getStatus()) {
            $this->arraySource->setWhere($this->getTable()->getOptions()->getStatus());
            $this->queryParams[$this->getTable()->getOptions()->getStatus()]=$this->getTable()->getParamAdapter()->getStatus();
        }

    }

    protected function order()
    {
        $column = $this->getParamAdapter()->getColumn();
        $order = $this->getParamAdapter()->getOrder();
        if (!$column) {
            return;
        }
        $this->arraySource->setOrder($column, strtoupper($order));
    }


    public function getSource()
    {
        return $this->arraySource->findAll(implode(", ",$this->fields), $this->queryParams);
    }
}
