<?php

/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Table\Decorator\Cell;


use Table\Decorator\Cell\AbstractCellDecorator;

class Check extends AbstractCellDecorator
{

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
	}

	/**
	 * Rendering decorator
	 * @param string $context
	 * @return string
	 */
	public function render($context)
	{
		return sprintf('<input name="id[%s]" type="checkbox" class="check_acao check icheck" id="%s" value="%s">', $context, $context, $context);
	}
}