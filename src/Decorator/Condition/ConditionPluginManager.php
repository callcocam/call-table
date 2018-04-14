<?php

/**
 * Created By: Claudio  Campos
 * E-Mail: callcocam@gmail.com
 */

namespace Table\Decorator\Condition;

class ConditionPluginManager
{

    /**
     * Default set of helpers
     *
     * @var array
     */
    protected $invokableClasses = array(
        'equal' => '\Table\Decorator\Condition\Plugin\Equal',
        'notequal' => '\Table\Decorator\Condition\Plugin\NotEqual',
        'between' => '\Table\Decorator\Condition\Plugin\Between',
        'greaterthan' => '\Table\Decorator\Condition\Plugin\GreaterThan',
        'lesserthan' => '\Table\Decorator\Condition\Plugin\LesserThan',


    );

    /**
     * Don't share plugin by default
     *
     * @var bool
     */
    protected $shareByDefault = false;


    /**
     * See AbstractPluginManager
     *
     * @throws \DomainException
     * @param mixed $plugin
     */
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof AbstractCondition) {
            return;
        }
        throw new \DomainException('Invalid Condition Implementation');
    }
}
