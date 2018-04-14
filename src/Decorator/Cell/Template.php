<?php

/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Table\Decorator\Cell;

use Table\Decorator\Exception;
use Table\Table\Exception\InvalidArgumentException;

class Template extends AbstractCellDecorator
{

    /**
     * Template
     * @var string
     */
    protected $template;

    /**
     * Array of variables
     * @var null | array
     */
    protected $vars;

    /**
     * Constructor
     *
     * @param array $options
     * @throws InvalidArgumentException
     */
    public function __construct(array $options = array())
    {
        if (!isset($options['template'])) {
            throw new InvalidArgumentException('path key in options argument requred');
        }

        $this->template = $options['template'];
        $this->vars = is_array($options['vars']) ? $options['vars'] : array($options['vars']);
        $this->place = (isset($options['place'])) ? $options['place'] : self::RESET_CONTEXT;
    }

    /**
     * Rendering decorator
     *
     * @param string $context
     * @return string
     */
    public function render($context)
    {
        $values = array();

        foreach ($this->vars as $var) {
            $actualRow = $this->getCell()->getActualRow();
            if (is_object($actualRow)) {
                $actualRow = $actualRow->getArrayCopy();
            }
            $values[] = $actualRow[$var];
        }

        $value = vsprintf($this->template, $values);

        if ($this->place == self::RESET_CONTEXT) {
            return $value;
        } else {
            return ($this->place == self::PRE_CONTEXT) ? $value . $context :  $context . $value;
        }
    }
}
