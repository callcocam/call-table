<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 20/03/2018
 * Time: 23:58
 */

namespace Table\Decorator\Cell;


use Table\Decorator\Exception\InvalidArgumentException;

class Btn extends AbstractCellDecorator
{

    /**
     * Array of variable attribute for link
     * @var array
     */
    protected $vars;

    /**
     * Link url
     * @var string
     */
    protected $url;
    private $options;
    protected $action ="create";
    protected $callback ="Posts";
    protected $callback_action ="delete";


    /**
     * Constructor
     *
     * @param array $options
     * @throws InvalidArgumentException
     */
    public function __construct(array $options = array())
    {
        if (!isset($options['url'])) {
            throw new InvalidArgumentException('Url key in options argument required');
        }

        $this->url = $options['url'];
        $this->options = $options;
    }

    /**
     * Rendering decorator
     * @param string $context
     * @return string
     */
    public function render($context,$opt=null)
    {

//        echo "<pre>";
//        var_dump($this->options['url']);
//        echo "</pre>";
        $Buttons=[];
        if ($opt) {
           $this->view = new \Table\Template($opt);
        }

            $actualRow = $this->getCell()->getActualRow();
            foreach ($this->url->getBtn() as $name => $urls) {
                if (isset($urls['status']) && isset($urls['vars']) && isset($actualRow[$urls['vars']['campo_status']])) {
                   if ((array_search($actualRow[$urls['vars']['campo_status']],$urls['status'])) === FALSE){
                        continue;
                    }
                    unset($urls['status']);
                    $Buttons[] = $this->view->render(sprintf("table/rows/%s", $name),[
                        'id'=>trim($actualRow[$urls['vars']['id']]),
                        'campo'=>trim($urls['vars']['campo_status']),
                        'status'=>trim($actualRow[$urls['vars']['campo_status']]),
                        'icon'=>(int)$actualRow[$urls['vars']['campo_status']]?" icon-checkmark":" icon-cross",
                        'class'=>(int)$actualRow[$urls['vars']['campo_status']]?"blue":"default",
                        'action'=>isset($urls['vars']['action'])?$urls['vars']['action']:$this->action,
                        'callback'=>isset($urls['vars']['callback'])?$urls['vars']['callback']:$this->callback,
                        'callback_action'=>isset($urls['vars']['callback_action'])?$urls['vars']['callback_action']:$this->callback_action,
                    ]);
                }

            }

        return implode(" | ", $Buttons);
    }


}