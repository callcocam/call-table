<?php

/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Table\Decorator;

class DecoratorPluginManager
{

    /**
     * Default set of helpers
     *
     * @var array
     */
    protected $invokableClasses = array(

        'cellattr' => '\Table\Decorator\Cell\AttrDecorator',
        'cellvarattr' => '\Table\Decorator\Cell\VarAttrDecorator',
        'cellclass' => '\Table\Decorator\Cell\ClassDecorator',
        'cellicon' => '\Table\Decorator\Cell\Icon',
        'cellmapper' => '\Table\Decorator\Cell\Mapper',
        'celllink' => '\Table\Decorator\Cell\Link',
        'celltemplate' => '\Table\Decorator\Cell\Template',
        'celleditable' => '\Table\Decorator\Cell\Editable',
        'cellcallable' => '\Table\Decorator\Cell\CallableDecorator',
        'cellstate' => '\Table\Decorator\Cell\State',
        'cellcheck' => '\Table\Decorator\Cell\Check',
        'cellbtn' => '\Table\Decorator\Cell\Btn',
        'cellimg' => '\Table\Decorator\Cell\Img',


        'rowclass' => '\Table\Decorator\Row\ClassDecorator',
        'rowvarattr' => '\Table\Decorator\Row\VarAttr',
        'rowseparatable' => '\Table\Table\Decorator\Row\Separatable',
        'headercheck' => '\Table\Decorator\Header\Check',
    );

    /**
     * Don't share header by default
     *
     * @var bool
     */
    protected $shareByDefault = false;

    /**
     * @param mixed $plugin
     */
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof AbstractDecorator) {
            return;
        }
        throw new \DomainException('Invalid Decorator Implementation');
    }
    public function get($name, $options)
    {
        if(class_exists($this->invokableClasses[$name])){
            return (new \ReflectionClass($this->invokableClasses[$name]))->newInstance($options);
        }
       return "";
    }
}
