<?php

/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Table\Params;

use Table\AbstractCommon;
use Table\Config;

abstract class AbstractAdapter extends AbstractCommon
{

    /**
     * Get configuration of table
     *
     * @return \Table\Options\ModuleOptions
     * @throws \Exception
     */
    public function getOptions()
    {
        return $this->getTable()->getOptions();
    }
}
