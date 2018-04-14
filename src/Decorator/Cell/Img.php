<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 28/03/2018
 * Time: 10:58
 */

namespace Table\Decorator\Cell;

use Table\Decorator\Exception\InvalidArgumentException;

class Img extends AbstractCellDecorator
{

    /**
     * Array of variables
     * @var null | array
     */
    protected $vars;
    protected $w=250;
    protected $h=250;


    /**
     * Constructor
     *
     * @param array $options
     * @throws InvalidArgumentException
     */
    public function __construct( array $options = [] )
    {

        if (!isset($options['vars'])) {
            throw new InvalidArgumentException('vars key in options argument required');
        }
        $this->vars = $options['vars'];
        $this->w = isset($options['w'])?$options['w']:$this->w;
        $this->h = isset($options['h'])?$options['h']:$this->h;


    }

    /**
     * Rendering decorator
     *
     * @param string $context
     * @param null $opt
     * @return string
     */
    public function render( $context, $opt = null )
    {
        if ($opt) {
            $this->view = new \Table\Template($opt);
        }
        $actualRow = $this->getCell()->getActualRow();
        return $this->view->render("table/rows/thumbnail", [
            'cover' => $context,
            'h' => $this->h,
            'w' => $this->w,
            'title' =>$actualRow[$this->vars['title']]
        ]);

    }

}