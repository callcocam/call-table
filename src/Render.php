<?php

/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Table;


use Table\Options\ModuleOptions;

class Render extends AbstractCommon
{

    /**
     * PhpRenderer object
     * @var PhpRenderer
     */
    protected $renderer;

    /**
     *
     * @var ModuleOptions
     */
    protected $options;

    /**
     *
     * @param AbstractTable $table
     */
    public function __construct($table)
    {
        $this->setTable($table);
    }

    /**
     * Rendering paginator
     *
     * @return string
     */
    public function renderPaginator()
    {
       return $this->getTable()->getSource()->getPaginator();
    }

     /**
     * Rendering json for dataTable
      *
     * @return string
     */
    public function renderDataTableJson()
    {
        $res = array();
        $render = $this->getTable()->getRow()->renderRows('array_assc');
        $res['sEcho'] = $render;
        $res['iTotalDisplayRecords'] = $this->getTable()->getSource()->getPaginator();
        $res['aaData'] = $render;
        $res['draw'] = $render;
        $res['data'] = $render;
        return $res;
    }


    public function renderNewDataTableJson()
    {

        $render = $this->getTable()->getRow()->renderRows('array');

        $res = array(
            'draw' => $render,
            'recordsFiltered' => $this->getTable()->getSource()->getPaginator()->getTotal(),
            'data' => $render,
        );

        return json_encode($res);
    }

    /**
     * Rendering init view for dataTable
     *
     * @return string
     */
    public function renderDataTableAjaxInit()
    {
        $renderedHeads = $this->renderHead();

        $view = new PhpRenderer();
        $view->setTemplate($this->getTable()->getOptions()->getTemplateMap()['data-table-init']);
        $view->setVariable('headers', $renderedHeads);
        $view->setVariable('attributes', $this->getTable()->getAttributes());

        return $view->render($view);

    }


    public function renderCustom($template)
    {

        $tableConfig = $this->getTable()->getOptions();
        $rowsArray = $this->getTable()->getRow()->renderRows('array_assc');

        $view = new PhpRenderer($tableConfig->getTemplateMap());
        $view->setVariable('rows', $rowsArray);
        $view->setVariable('paginator', $this->renderPaginator());
        $view->setVariable('paramsWrap', $this->renderParamsWrap());
        $view->setVariable('itemCountPerPage', $this->getTable()->getParamAdapter()->getItemCountPerPage());
        $view->setVariable('quickSearch', $this->getTable()->getParamAdapter()->getQuickSearch());
        $view->setVariable('name', $tableConfig->getName());
        $view->setVariable('itemCountPerPageValues', $tableConfig->getValuesOfItemPerPage());
        $view->setVariable('showQuickSearch', $tableConfig->getShowQuickSearch());
        $view->setVariable('showPagination', $tableConfig->getShowPagination());
        $view->setVariable('showItemPerPage', $tableConfig->getShowItemPerPage());
        $view->setVariable('router', $this->getTable()->getRoute());

        $view->setVariable('paramsWrap', $this->renderParamsWrap());

        $view->setVariable('name', $tableConfig->getName());

        /**
         * Inicia o filtro de items por paginas
         */
        $view->setVariable('quickSearch', '');
        /**
         * Verifica se ele esta habilitado para o modulo
         */
        if($tableConfig->getShowQuickSearch()){
            $view->setVariable('quickSearch', $this->getTable()->getParamAdapter()->getQuickSearch());
        }

        /**
         * Inicia o filtro de items por paginas
         */
        $view->setVariable('itemCountPerPageValues', '');
        /**
         * Verifica se ele esta habilitado para o modulo
         */
        if($tableConfig->getShowItemPerPage()){
            $view->setVariable('ValuesOfItemPerPage', $this->renderValuesOfItemPerPage());
        }


        /**
         * Inicia o filtro de status do registro
         */
        $view->setVariable('valueStatus', "");
        /**
         * Verifica se ele esta habilitado para o modulo
         */
        if($tableConfig->isShowStatusFilters()) {
            $view->setVariable('valueStatus', $this->renderStatus());
        }
        /**
         * Inicia o filtro de QuickSearch
         */
        $view->setVariable('QuickSearch', "");
        /**
         * Verifica se ele esta habilitado para o modulo
         */
        if($tableConfig->getShowQuickSearch()) {
            $view->setVariable('QuickSearch', $this->renderQuickSearch());
        }
        /**
         * Inicia o filtro de para datas
         */
        $view->setVariable('DateFilters', "");
        /**
         * Verifica se ele esta habilitado para o modulo
         */
        if($tableConfig->isShowDateFilters()) {
            $view->setVariable('DateFilters', $this->renderDateFilters());
        }

        /**
         * Inicia paginator
         */
        $view->setVariable('paginator', "");
        /**
         * Verifica se ele esta habilitado para o modulo
         */
        if($tableConfig->getShowPagination()) {
            $view->setVariable('paginator', $this->renderPaginator());
        }


        $view->setVariable('showExportToCSV', $tableConfig->getShowExportToCSV());
        $view->setVariable('zfTablePage', $this->getTable()->getParamAdapter()->getPage());


        return $view->render($template);
    }

    /**
     * Rendering table
     *
     * @return string
     * @throws \Exception
     * @throws \Throwable
     */
    public function renderTableAsHtml()
    {
        $render = '';
        $tableConfig = $this->getTable()->getOptions();
        /**
         * carregas os bostões se estiver ativado para modulo
         */
        if($tableConfig->isShowButtonsActions()){
            $render .= $this->renderAction();
        }

        $view = new PhpRenderer($tableConfig->getTemplateMap());
        $render .= $this->renderHead();
        $render = sprintf('<thead>%s</thead>', $render);

        $render .= $this->getTable()->getRow()->renderRows();

       // $table = $view->render('css/template-css');
        $table = sprintf('<table %s>%s</table>', $this->getTable()->getAttributes(), $render);
       // $table.= $view->render('js/template-js');

       $view->setVariable('table', $table);

        $view->setVariable('router', $this->getTable()->getRoute());

        $view->setVariable('paramsWrap', $this->renderParamsWrap());

        $view->setVariable('name', $tableConfig->getName());

        /**
         * Inicia o filtro de items por paginas
         */
        $view->setVariable('quickSearch', '');
        /**
         * Verifica se ele esta habilitado para o modulo
         */
        if($tableConfig->getShowQuickSearch()){
            $view->setVariable('quickSearch', $this->getTable()->getParamAdapter()->getQuickSearch());
        }

        /**
         * Inicia o filtro de items por paginas
         */
        $view->setVariable('itemCountPerPageValues', '');
        /**
         * Verifica se ele esta habilitado para o modulo
         */
        if($tableConfig->getShowItemPerPage()){
            $view->setVariable('ValuesOfItemPerPage', $this->renderValuesOfItemPerPage());
        }


        /**
         * Inicia o filtro de status do registro
         */
        $view->setVariable('valueStatus', "");
        /**
         * Verifica se ele esta habilitado para o modulo
         */
        if($tableConfig->isShowStatusFilters()) {
            $view->setVariable('valueStatus', $this->renderStatus());
        }
        /**
         * Inicia o filtro de QuickSearch
         */
        $view->setVariable('QuickSearch', "");
        /**
         * Verifica se ele esta habilitado para o modulo
         */
        if($tableConfig->getShowQuickSearch()) {
            $view->setVariable('QuickSearch', $this->renderQuickSearch());
        }
        /**
         * Inicia o filtro de para datas
         */
        $view->setVariable('DateFilters', "");
        /**
         * Verifica se ele esta habilitado para o modulo
         */
        if($tableConfig->isShowDateFilters()) {
            $view->setVariable('DateFilters', $this->renderDateFilters());
        }

        /**
         * Inicia paginator
         */
        $view->setVariable('paginator', "");
        /**
         * Verifica se ele esta habilitado para o modulo
         */
        if($tableConfig->getShowPagination()) {
            $view->setVariable('paginator', $this->renderPaginator());
        }


        $view->setVariable('showExportToCSV', $tableConfig->getShowExportToCSV());
        $view->setVariable('zfTablePage', $this->getTable()->getParamAdapter()->getPage());
        return $view->render('template-html');
    }




    /**
     * Rendering head
     *
     * @return string
     */
    public function renderHead()
    {
        $headers = $this->getTable()->getHeaders();
        $render = '';
        foreach ($headers as $name => $title) {
            $render .= $this->getTable()->getHeader($name)->render();
        }
        $render = sprintf('<tr class="zf-title">%s</tr>', $render);
        return $render;
    }

    /**
     * Rendering head
     *
     * @return string
     * @throws \Exception
     */
    public function renderAction()
    {
        $collspam = count($this->getTable()->getHeaders());
        $actions = $this->getTable()->getActions();
        $render = '';
        foreach ($actions as $name => $title) {
            $render .= $this->getTable()->getActions($name)->render();
        }
        //tr-table-actions
        $view = new Template($this->getTable()->getOptions());
        $render = $view->render("/table/tr-table-actions",[
            'render'=> $render,
            'collspam'=>$collspam
        ]);
         return $render;
    }

    /**
     * Rendering head
     *
     * @return string
     */
    public function renderDateFilters()
    {
        $render = $this->getTable()->getDateFilters("DateTimePiker")->render();
        return $render;
    }
    /**
     * Rendering head
     *
     * @return string
     */
    public function renderQuickSearch()
    {
        return  $this->getTable()->getQuickSearch("Search")->render();
    }

    /**
     * Rendering head
     *
     * @return string
     * @throws \Exception
     * @throws \Throwable
     */
    public function renderStatus()
    {
        $status = $this->getTable()->getStatus();
        $render = '';
        foreach ($status as $name => $title) {
           $render .= $this->getTable()->getStatu($title)->render();
        }
        return $this->getRenderer()->render("table/select-status",[
            "class" => $this->getTable()->getStatu($title)->getClass(),
            "render"=>$render
        ]);
    }

    public function renderValuesOfItemPerPage()
    {
        $valuesOfItemPerPage = $this->getTable()->getValuesOfItemPerPages();
        $render = '';
        foreach ($valuesOfItemPerPage as $name => $title) {
           $render .= $this->getTable()->getValuesOfItemPerPage($name)->render();
        }
        return $this->getRenderer()->render('table/item-per-page',[
            "class" => $this->getTable()->getValuesOfItemPerPage($title)->getClass(),
            "render"=>$render,
            "id"=>"itemPerPage"
        ]);
    }

    /**
     * Rendering params wrap to ajax communication
     *
     * @return string
     * @throws \Exception
     * @throws \Throwable
     */
    public function renderParamsWrap()
    {
        $view = new PhpRenderer($this->getTable()->getOptions()->getTemplateMap());

        $view->setVariable('zfTableColumn', $this->getTable()->getParamAdapter()->getColumn());
        $view->setVariable('zfTableItemPerPage', $this->getTable()->getParamAdapter()->getItemCountPerPage());
        $view->setVariable('zfTableOrder', $this->getTable()->getParamAdapter()->getOrder());
        $view->setVariable('zfTablePage', $this->getTable()->getParamAdapter()->getPage());
        $view->setVariable('zfTableQuickSearch', $this->getTable()->getParamAdapter()->getQuickSearch());
        $view->setVariable('rowAction', $this->getTable()->getOptions()->getRowAction());
        $view->setVariable('zfTableStatus', $this->getTable()->getParamAdapter()->getStatus());
        $view->setVariable('zfTableStartDate', $this->getTable()->getParamAdapter()->getStartDate());
        $view->setVariable('zfTableEndDate', $this->getTable()->getParamAdapter()->getEndDate());

        return $view->render('default-params');
    }

    /**
     * Init renderer object
     */
    protected function initRenderer()
    {
        $renderer = new PhpRenderer($this->getTable()->getOptions()->getTemplateMap());
        $this->renderer = $renderer;
    }

    /**
     * Get PHPRenderer
     * @return PhpRenderer
     */
    public function getRenderer()
    {
        if (!$this->renderer) {
            $this->initRenderer();
        }
        return $this->renderer;
    }

    /**
     * Set PhpRenderer

     */
    public function setRenderer(PhpRenderer $renderer)
    {
        $this->renderer = $renderer;
    }
}
