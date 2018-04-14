<?php

/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Table;

use Table\Drivers\MysqlPdo;
use Table\Drivers\Select;
use Table\Params\AdapterArrayObject;
use Table\Source\AbstractSource;
use Table\Table\TableInterface;
use Table\Params\AdapterInterface as ParamAdapterInterface;
use Table\Table\Exception;
use Table\Options\ModuleOptions;


abstract class AbstractTable extends AbstractElement implements TableInterface
{

    /**
     * Collection on actions objects
     * @var array
     */
    private $actionsObjects;

    /**
     * Collection on headers objects
     * @var array
     */
    private $headersObjects;

    /**
     * Collection on status objects
     * @var array
     */
    private $statusObjects;
    /**
     * Collection on valuesOfItemPerPage objects
     * @var array
     */
    private $valuesOfItemPerPageObjects;
    /**
     * Collection on quickSearch objects
     * @var array
     */
    private $quickSearchObjects;
    /**
     * Collection on dateFilters objects
     * @var array
     */
    private $dateFiltersObjects;


    protected $buttonConfig;
    /**
     * List of headers with title and width option
     * @var array
     */
    protected $headers;

    protected $valuesOfState = ["" => 'All', 1 => 'Active', 2 => 'Inactive', 3 => 'Trash'];

    protected $valuesOfItemPerPage = [5 => 5, 10 => 10, 20 => 20, 50 => 50, 100 => 100];

    protected $actions;

    protected $coverConfig;

    /**
     *
     * @var Source\SourceInterface
     */
    protected $source;

    /**
     *
     * @var Row
     */
    protected $row;

    /**
     * Data after execute of query
     */
    protected $data;

    /**
     * Render object responsible for rendering
     * @var Render
     */
    protected $render;

    /**
     * Params adapter which responsible for universal mapping parameters from diffrent
     * source (default params, Data Table params, JGrid params)
     * @var ParamAdapterInterface
     */
    protected $paramAdapter;

    /**
     * Flag to know if table has been initializable
     * @var boolean
     */
    private $tableInit = false;


    /**
     * Default classes for table
     * @var array
     */
    protected $class = array('table', 'table-bordered', 'table-condensed', 'table-hover', 'table-striped', 'dataTable');

    /**
     * Array configuration of table
     * @var array
     */
    protected $config;


    /**
     * Options base ond ModuleOptions and config array
     * @var Options\ModuleOptions
     */
    protected $options = null;


    public function __construct()
    {

    }

    /**
     * Check if table has benn initializable
     * @return boolean
     */
    public function isTableInit()
    {
        return $this->tableInit;
    }

    /**
     * Set module options
     *
     * @param  array|\Traversable|ModuleOptions $options
     * @return AbstractTable
     */
    public function setOptions( $options )
    {
        if (!$options instanceof ModuleOptions) {
            $options = new ModuleOptions($options);
        }

        $this->options = $options;
        return $this;
    }

    /**
     * Return Params adapter
     *
     * which responsible for universal mapping parameters from different
     * source (default params, Data Table params, JGrid params)
     *
     * @return ParamAdapterInterface
     */
    public function getParamAdapter()
    {
        return $this->paramAdapter;
    }


    /**
     *
     * @param $params
     * @throws Exception\InvalidArgumentException
     */
    public function setParamAdapter( $params )
    {
        $this->paramAdapter = new AdapterArrayObject($params);
        $this->paramAdapter->setTable($this);
        $this->paramAdapter->init();
    }

    /**
     *
     * @throws Exception\LogicException
     */
    public function getData()
    {

        if (!$this->data) {
            $source = $this->getSource();
            if (!$source) {
                throw new Exception\LogicException('Source data is required');
            }
            $this->data = $source->getData();
        }
        return $this->data;
    }

    /**
     *
     * @return Source\SourceInterface
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     *
     * @param $source
     * @return AbstractTable
     * @throws Exception\LogicException
     */
    public function setSource( $Tabela )
    {

// instanciação da classe de sql (driver)
        $driver = new MysqlPdo(\Conn::getConn());
        $driver->setTable($Tabela);
        $model = new Select();
        $model->setDriver($driver);
        $source = new AbstractSource($model);
        $source->setTable($this);
        $source->setTabela($Tabela);
        $this->source = $source;
        return $this;
    }


    /**
     * Rendering table
     *
     * @param string $type (html | dataTableAjaxInit | dataTableJson)
     * @param null $template
     * @return string
     * @throws \Exception
     */
    public function render( $type = 'html', $template = null )
    {
        if (!$this->isTableInit()) {
            $this->initializable();
        }

        if ($type == 'html') {
            return $this->getRender()->renderTableAsHtml();
        } elseif ($type == 'dataTableAjaxInit') {
            return $this->getRender()->renderDataTableAjaxInit();
        } elseif ($type == 'dataTableJson') {
            return $this->getRender()->renderDataTableJson();
        } elseif ($type == 'custom') {
            return $this->getRender()->renderCustom($template);
        } elseif ($type == 'newDataTableJson') {
            return $this->getRender()->renderNewDataTableJson();
        } else {
            throw new Exception\InvalidArgumentException(sprintf('Invalid type %s', $type));
        }

    }

    /**
     * Init configuration like setting header, decorators, filters and others
     *
     * (call in render method as well)
     */
    protected function initializable()
    {
        if (!$this->getParamAdapter()) {
            throw new Exception\LogicException('Param Adapter is required');
        }

        if (!$this->getSource()) {
            throw new Exception\LogicException('Source data is required');
        }

        $this->init = true;

        if (count($this->valuesOfItemPerPage)) {
            $this->setValuesOfItemPerPage($this->valuesOfItemPerPage);
        }

        if (count($this->valuesOfState)) {
            $this->setStatus($this->valuesOfState);
        }

        if (count($this->actions)) {
            $this->setActions($this->actions);
        }

        if (count($this->headers)) {
            $this->setHeaders($this->headers);
        }

        $this->setSearch("Search");

        $this->setDateFilters('DateTimePiker');

        $this->init();

        $this->initFilters($this->getSource());
    }


    /**
     * @deprecated since version 2.0
     *
     * Function replace by initFilters
     */
    protected function initQuickSearch()
    {

    }

    /**
     * Init filters for quick search or filters for each column
     * @param  $query
     */
    protected function initFilters( $query )
    {

    }

    public function setSearch( $name )
    {
        $quickSearch = new Search($this->getParamAdapter()->getQuickSearch());
        $quickSearch->setView(new Template($this->getOptions()));
        $this->quickSearchObjects[$name] = $quickSearch;
        return $this;
    }

    public function setDateFilters( $name )
    {
        $dateFilters = new DateFilters($this->getParamAdapter()->getStartDate(), $this->getParamAdapter()->getEndDate());
        $dateFilters->setView(new Template($this->getOptions()));
        $this->dateFiltersObjects[$name] = $dateFilters;
        return $this;
    }

    /**
     * @param $name
     * @return array
     */
    public function getQuickSearch( $name )
    {
        if (!count($this->quickSearchObjects)) {
            throw new Exception\LogicException('Table hasn\'t got defined quickSearchObjects');
        }

        if (!isset($this->quickSearchObjects[$name])) {
            throw new \RuntimeException('quickSearchObjects name doesnt exist');
        }
        return $this->quickSearchObjects[$name];
    }

    /**
     * @param $name
     * @return array
     */
    public function getDateFilters( $name )
    {
        if (!count($this->dateFiltersObjects)) {
            throw new Exception\LogicException('Table hasn\'t got defined dateFiltersObjects');
        }

        if (!isset($this->dateFiltersObjects[$name])) {
            throw new \RuntimeException('dateFiltersObjects name doesnt exist');
        }
        return $this->dateFiltersObjects[$name];
    }


    public function setActions( array $actions )
    {
        $this->actions = $actions;
        foreach ($actions as $name => $options) {
            $action = new Actions($name, $options, $this->getParamAdapter()->getStatus());
            $action->setTable($this);
            $action->setView(new Template($this->getOptions()));
            $this->actionsObjects[$name] = $action;
        }
        return $this;
    }

    public function setStatus( array $valuesOfState )
    {
        $this->valuesOfState = $valuesOfState;
        foreach ($valuesOfState as $value => $Label) {
            $Status = new Status($value, $Label, $this->getParamAdapter()->getStatus());
            $Status->setView(new Template($this->getOptions()));
            $this->statusObjects[$Label] = $Status;
        }
        return $this;
    }

    public function setValuesOfItemPerPage( array $valuesOfItemPerPage )
    {
        $this->valuesOfItemPerPage = $valuesOfItemPerPage;
        foreach ($valuesOfItemPerPage as $value => $Label) {
            $ItemPerPage = new ValuesOfItemPerPage($value, $Label, $this->getParamAdapter()->getItemCountPerPage());
            $ItemPerPage->setView(new Template($this->getOptions()));
            $ItemPerPage->setTable($this);
            $this->valuesOfItemPerPageObjects[$value] = $ItemPerPage;
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getValuesOfItemPerPages()
    {
        return $this->valuesOfItemPerPage;
    }

    /**
     * @param $name
     * @return array
     */
    public function getValuesOfItemPerPage( $name )
    {
        if (!count($this->valuesOfItemPerPageObjects)) {
            throw new Exception\LogicException('Table hasn\'t got defined valuesOfItemPerPageObjects');
        }

        if (!isset($this->valuesOfItemPerPageObjects[$name])) {
            throw new \RuntimeException('valuesOfItemPerPageObjects name doesnt exist');
        }
        return $this->valuesOfItemPerPageObjects[$name];
    }

    /**
     *
     * @param array $headers
     * @return $this
     */
    public function setHeaders( array $headers )
    {
        $this->headers = $headers;
        foreach ($headers as $name => $options) {
            $this->addHeader($name, $options);
        }

        return $this;
    }

    /**
     * Return array of headers
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     *
     * @param string $name type
     * @return Header | boolean
     * @throws Exception\LogicException
     */
    public function getHeader( $name )
    {
        if (!count($this->headersObjects)) {
            throw new Exception\LogicException('Table hasn\'t got defined headers');
        }

        if (!isset($this->headersObjects[$name])) {
            throw new \RuntimeException('Header name doesnt exist');
        }
        return $this->headersObjects[$name];
    }

    /**
     * Return array of headers
     *
     * @return mixed
     */
    public function getStatus()
    {
        return $this->valuesOfState;
    }

    /**
     * Return array of headers
     *
     * @return mixed
     */
    public function getStatu( $name )
    {
        if (!count($this->statusObjects)) {
            throw new Exception\LogicException('Table hasn\'t got defined valuesOfState');
        }

        if (!isset($this->statusObjects[$name])) {
            throw new \RuntimeException('valuesOfState name doesnt exist');
        }
        return $this->statusObjects[$name];

    }

    /**
     * Add new action
     *
     * @return array
     */
    public function getActions( $name = "" )
    {
        if (!empty($name)) {
            if (!count($this->actionsObjects)) {
                throw new Exception\LogicException('Table hasn\'t got defined actionsObjects');
            }

            if (!isset($this->actionsObjects[$name])) {
                throw new \RuntimeException('actionsObjects name doesnt exist');
            }
            return $this->actionsObjects[$name];
        }
        return $this->actions;
    }

    /**
     * Add new action
     *
     * @param $name
     * @return array
     */
    public function getAction( $name )
    {
        if (!count($this->actionsObjects)) {
            throw new Exception\LogicException('Table hasn\'t got defined actionsObjects');
        }

        if (!isset($this->actionsObjects[$name])) {
            throw new \RuntimeException('actionsObjects name doesnt exist');
        }
        return $this->actionsObjects[$name];

    }

    /**
     * Add new header
     *
     * @param string $name
     * @param array $options
     */
    public function addHeader( $name, $options )
    {
        $header = new Header($name, $options);
        $header->setTable($this);
        $this->headersObjects[$name] = $header;
    }

    /**
     * Get Row object
     *
     * @return Row
     */
    public function getRow()
    {
        if (!$this->row) {
            $this->row = new Row($this);
        }
        return $this->row;
    }

    /**
     * Set row object
     *
     * @param $row Row
     * @return $this
     */
    public function setRow( $row )
    {
        $this->row = $row;
        return $this;
    }

    /**
     * Get Render object
     *
     * @return Render
     */
    public function getRender()
    {
        if (!$this->render) {
            $this->render = new Render($this);
        }
        return $this->render;
    }

    /**
     * Get render object
     * @param Render $render
     */
    public function setRender( Render $render )
    {
        $this->render = $render;
    }

    /**
     * Rendering table
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     *
     * @return ModuleOptions
     * @throws \Exception
     */
    public function getOptions()
    {
        if (is_array($this->config)) {
            $this->config = new ModuleOptions($this->config);
        } elseif (!$this->config instanceof ModuleOptions) {
            throw new \Exception('Config class problem');
        }
        return $this->config;
    }


}
