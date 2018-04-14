<?php

/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Table;


abstract class AbstractCommon
{

    /**

    /**
     * Table object
     * @var AbstractTable
     */
    protected $table;
    protected $tabela;
    protected $route;

    /**
     *
     * @return AbstractTable
     */
    public function getTable()
    {
        return $this->table;
    }


    /**
     *
     * @param AbstractTable $table
     * @return \Table\AbstractCommon
     */
    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return filter_input(INPUT_GET, 'wc', FILTER_DEFAULT);
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return filter_input_array(INPUT_GET, FILTER_DEFAULT);
    }

    /**
     * @param mixed $tabela
     * @return AbstractCommon
     */
    public function setTabela( $tabela )
    {
        $this->tabela = $tabela;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTabela()
    {
        return $this->tabela;
    }
}
