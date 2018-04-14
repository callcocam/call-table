<?php

/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Table\Decorator\Cell;

use Table\Decorator\Exception;
use Table\Exception\InvalidArgumentException;

class Mapper extends AbstractCellDecorator
{

    /**
     * Array of options mapping
     * @var array
     */
    protected $options;


    /**
     * Constructor
     * @param array $options
     * @throws InvalidArgumentException
     */
    public function __construct(array $options = array())
    {
        if (count($options) == 0) {
            throw new InvalidArgumentException('Array is empty');
        }

        $this->options = $options;
    }

    /**
     * Rendering decorator
     * @param string $context
     * @return string
     */
    public function render($context)
    {
        return (isset($this->options[$context])) ? $this->options[$context] :    $context;
    }
}
