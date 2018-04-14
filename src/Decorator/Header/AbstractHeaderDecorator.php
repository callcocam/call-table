<?php

/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Table\Decorator\Header;

use Table\Decorator\AbstractDecorator;

abstract class AbstractHeaderDecorator extends AbstractDecorator
{

    /**
     * Header object
     * @var \Table\Header
     */
    protected $header;

    /**
     *
     * @return \Table\Header
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     *
     * @param \Table\Header $header
     * @return \Table\Decorator\Header\AbstractHeaderDecorator
     */
    public function setHeader($header)
    {
        $this->header = $header;
        return $this;
    }
}
