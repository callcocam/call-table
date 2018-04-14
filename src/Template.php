<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 28/03/2018
 * Time: 00:06
 */

namespace Table;


use Table\Options\ModuleOptions;

class Template
{
    protected $folderTemplate = 'templates';
    protected $view;
    private $options;

    public function __construct(ModuleOptions $options)
    {
        $this->options = $options;
    }

    public function render($mailTemplate, array $data)
    {
        $viewModel = new PhpRenderer($this->options->getTemplateMap());
        //$viewModel->setTemplatePath("{$this->getFolderTemplate()}/{$mailTemplate}.phtml");
       // $viewModel->setOption('has_parent', true);
       // $viewModel->setVariables($data);

        return $viewModel->render($mailTemplate,$data);
    }

}