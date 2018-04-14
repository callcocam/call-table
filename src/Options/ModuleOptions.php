<?php

/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Table\Options;

class ModuleOptions implements
    TableOptionsInterface,
    DataTableInterface,
    RenderInterface,
    PaginatorInterface
{

    /**
     * Id of table
     * @var string
     */
    protected $id = 'id';

    /**
     * Status of table
     * @var string
     */
    protected $status = 'status';
    /**
     * Data search of table
     * @var string
     */
    protected $field_date = 'date';
    /**
     * Name of table
     * @var null | string
     */
    protected $name = '';

    /**
     * Show or hide pagination view
     * @var boolean
     */
    protected $showPagination = true;

    /**
     * Show or hide status view
     * @var boolean
     */
    protected $showStatusFilters = true;

    /**
     * Show or hide quick search view
     * @var boolean
     */
    protected $showQuickSearch = true;


    /**
     * Show or hide item per page view
     * @var boolean
     */
    protected $showItemPerPage = true;

    /**
     * @todo item and default count per page
     * Default value for item count per page
     * @var int
     */
    protected $itemCountPerPage = 5;

    /**
     * Flag to show row with filters (for each column)
     * @var boolean
     */
    protected $showColumnFilters = false;

    /**
     * @var bool
     */
    protected $showButtonsActions = true;

    /**
     * @var bool
     */
    protected $showDateFilters = true;


    /**
     * Definition of
     * @var string | boolean
     */
    protected $rowAction = false;


    /**
     * Show or hide exporter to CSV
     * @var boolean
     */
    protected $showExportToCSV = false;


    /**
     * Value to specify items per page (pagination)
     * @var array
     */
    protected $valuesOfItemPerPage = array(5, 10, 20, 50, 100);


    /**
     * Get maximal rows to returning. Data tables can use
     * pagination, but also can get data by ajax, and use
     * java script to pagination (and variable destiny for this case)
     *
     * @var int
     */
    protected $dataTablesMaxRows = 999;


    /**
     * Template Map
     * @var array
     */
    protected $templateMap = '';


    /**
     * ModuleOptions constructor.
     * @param null $options
     */
    public function __construct( $options = null )
    {
        $this->id = (isset($options['id'])) ? $options['id'] : $this->id;
        $this->status = (isset($options['status'])) ? $options['status'] : $this->status;
        $this->field_date = (isset($options['field_date'])) ? $options['field_date'] : '';
        $this->name = (isset($options['name'])) ? $options['name'] : $this->id;
        $this->showExportToCSV = (isset($options['showExportToCSV'])) ? $options['showExportToCSV'] : $this->showExportToCSV;
        $this->showStatusFilters = (isset($options['showStatusFilters'])) ? $options['showStatusFilters'] : $this->showStatusFilters;
        $this->dataTablesMaxRows = (isset($options['dataTablesMaxRows'])) ? $options['dataTablesMaxRows'] : $this->dataTablesMaxRows;
        $this->valuesOfItemPerPage = (isset($options['valuesOfItemPerPage'])) ? $options['valuesOfItemPerPage'] : $this->valuesOfItemPerPage;
        $this->rowAction = (isset($options['rowAction'])) ? $options['rowAction'] : $this->rowAction;
        $this->showButtonsActions = (isset($options['showButtonsActions'])) ? $options['showButtonsActions'] : $this->showButtonsActions;
        $this->showColumnFilters = (isset($options['showColumnFilters'])) ? $options['showColumnFilters'] : $this->showColumnFilters;
        $this->itemCountPerPage = (isset($options['itemCountPerPage'])) ? $options['itemCountPerPage'] : $this->itemCountPerPage;
        $this->showQuickSearch = (isset($options['showQuickSearch'])) ? $options['showQuickSearch'] : $this->showQuickSearch;
        $this->showStatusFilters = (isset($options['showStatusFilters'])) ? $options['showStatusFilters'] : $this->showStatusFilters;
        $this->showPagination = (isset($options['showPagination'])) ? $options['showPagination'] : $this->showPagination;
        $this->templateMap = sprintf("%s/_app/Library/Table/www/templates", dirname(dirname(dirname(dirname(dirname(__DIR__))))));

    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return ModuleOptions
     */
    public function setId( string $id ): ModuleOptions
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return ModuleOptions
     */
    public function setStatus( string $status ): ModuleOptions
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getFieldDate(): string
    {
        return $this->field_date;
    }

    /**
     * @param string $field_date
     * @return ModuleOptions
     */
    public function setFieldDate( string $field_date ): ModuleOptions
    {
        $this->field_date = $field_date;
        return $this;
    }


    /**
     * @return bool
     */
    public function getShowExportToCSV()
    {
        return $this->showExportToCSV;
    }

    /**
     * @param $showExportToCSV
     */
    public function setShowExportToCSV( $showExportToCSV )
    {
        $this->showExportToCSV = $showExportToCSV;
    }

    /**
     * @return bool
     */
    public function isShowStatusFilters(): bool
    {
        return $this->showStatusFilters;
    }

    /**
     * @param bool $showStatusFilters
     * @return ModuleOptions
     */
    public function setShowStatusFilters( bool $showStatusFilters ): ModuleOptions
    {
        $this->showStatusFilters = $showStatusFilters;
        return $this;
    }


    /**
     * @return bool
     */
    public function isShowDateFilters(): bool
    {
        return $this->showDateFilters;
    }

    /**
     * @param bool $showDateFilters
     * @return ModuleOptions
     */
    public function setShowDateFilters( bool $showDateFilters )
    {
        $this->showDateFilters = $showDateFilters;
        return $this;
    }

    /**
     * Set template map
     * @param array $templateMap
     */
    public function setTemplateMap( $templateMap )
    {
        $this->templateMap = array_merge($this->templateMap, $templateMap);
    }


    /**
     * Set template map
     *
     * @return array
     */
    public function getTemplateMap()
    {
        return $this->templateMap;
    }

    /**
     * Get maximal rows to returning
     *
     * @return int
     */
    public function getDataTablesMaxRows()
    {
        return $this->dataTablesMaxRows;
    }

    /**
     * Set maximal rows to returning.
     *
     * @param int $dataTablesMaxRows
     * @return $this
     */
    public function setDataTablesMaxRows( $dataTablesMaxRows )
    {
        $this->dataTablesMaxRows = $dataTablesMaxRows;
        return $this;
    }

    /**
     * Get Array of values to set items per page
     * @return array
     */
    public function getValuesOfItemPerPage()
    {
        return $this->valuesOfItemPerPage;
    }

    /**
     *
     * Set Array of values to set items per page
     *
     * @param array $valuesOfItemPerPage
     * @return $this
     */
    public function setValuesOfItemPerPage( $valuesOfItemPerPage )
    {
        $this->valuesOfItemPerPage = $valuesOfItemPerPage;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function getShowPagination()
    {
        return $this->showPagination;
    }

    /**
     * @return bool
     */
    public function getShowQuickSearch()
    {
        return $this->showQuickSearch;
    }

    /**
     * @return bool
     */
    public function getShowItemPerPage()
    {
        return $this->showItemPerPage;
    }

    /**
     * @return int
     */
    public function getItemCountPerPage()
    {
        return $this->itemCountPerPage;
    }

    /**
     * @return bool
     */
    public function getShowColumnFilters()
    {
        return $this->showColumnFilters;
    }

    /**
     * @return bool
     */
    public function isShowButtonsActions(): bool
    {
        return $this->showButtonsActions;
    }

    /**
     * @return array
     */
    public function getValueButtonsActions(): array
    {
        return $this->valueButtonsActions;
    }


    /**
     * @return bool|string
     */
    public function getRowAction()
    {
        return $this->rowAction;
    }

    /**
     * @param $name
     */
    public function setName( $name )
    {
        $this->name = $name;
    }

    /**
     * @param $showPagination
     * @return ModuleOptions
     */
    public function setShowPagination( $showPagination )
    {
        $this->showPagination = $showPagination;
        return $this;
    }

    /**
     * @param $showQuickSearch
     * @return ModuleOptions
     */
    public function setShowQuickSearch( $showQuickSearch )
    {
        $this->showQuickSearch = $showQuickSearch;
        return $this;
    }

    /**
     * @param $showItemPerPage
     * @return ModuleOptions
     */
    public function setShowItemPerPage( $showItemPerPage )
    {
        $this->showItemPerPage = $showItemPerPage;
        return $this;
    }

    /**
     * @param $itemCountPerPage
     * @return ModuleOptions
     */
    public function setItemCountPerPage( $itemCountPerPage )
    {
        $this->itemCountPerPage = $itemCountPerPage;
        return $this;
    }

    /**
     * @param $showColumnFilters
     * @return ModuleOptions
     */
    public function setShowColumnFilters( $showColumnFilters )
    {
        $this->showColumnFilters = $showColumnFilters;
        return $this;
    }

    /**
     * @param bool $showButtonsActions
     * @return ModuleOptions
     */
    public function setShowButtonsActions( bool $showButtonsActions ): ModuleOptions
    {
        $this->showButtonsActions = $showButtonsActions;
        return $this;
    }

    /**
     * @param array $valueButtonsActions
     * @return ModuleOptions
     */
    public function setValueButtonsActions( array $valueButtonsActions ): ModuleOptions
    {
        $this->valueButtonsActions = $valueButtonsActions;
        return $this;
    }


    /**
     * @param $rowAction
     * @return ModuleOptions
     */
    public function setRowAction( $rowAction )
    {
        $this->rowAction = $rowAction;
        return $this;
    }
}
