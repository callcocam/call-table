<?php

/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Table\Decorator\Cell;


use Table\Table\Exception\InvalidArgumentException;

class State extends AbstractCellDecorator
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
		$class = (isset($this->options['class'][$context])) ? $this->options['class'][$context] : $context;
		$value = (isset($this->options['value'][$context])) ? $this->options['value'][$context] : $context;
		return sprintf('<span  class="btn_%s">%s</span>', $class,$value);
	}
}
