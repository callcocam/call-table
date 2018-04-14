<?php

/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Table\Decorator\Cell;

use Table\Decorator\Exception;

class VarAttrDecorator extends AbstractCellDecorator
{

    protected $attr;


    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct($options)
    {
        $this->setAttr($options);
    }

    /**
     * Rendering decorator
     *
     * @param string $context
     * @return string
     */
    public function render($context)
    {
        if (count($this->attr) > 0) {
            foreach ($this->attr as $name => $value) {
                $this->getCell()->addVarAttr($name, $value);
            }
        }
        return $context;
    }

    public function getAttr()
    {
        return $this->attr;
    }

    public function setAttr($attr)
    {
        $this->attr = $attr;
    }
}
