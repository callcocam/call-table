<?php

/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Table\Decorator\Condition;

interface ConditionInterface
{

    /**
     * Check if the condition is valid
     *
     * @return boolean
     */
    public function isValid();
}
