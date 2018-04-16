<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/popphp/popphp-framework
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2018 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Table\Paginator;

/**
 * Paginator range of links class
 *
 * @category   Pop
 * @package    Pop\Paginator
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2018 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    3.0.2
 */
class Links extends AbstractPaginator
{


    /**
     * Link separator
     * @var string
     */
    protected $separator = null;

    /**
     * Page links property
     * @var array
     */
    protected $links = [];

    /**
     * Class 'on' name for page link tags
     * @var string
     */
    protected $classOn = null;

    /**
     * Class 'off' name for page link tags
     * @var string
     */
    protected $classOff = 'disabled';

    /**
     * Set the bookend separator
     *
     * @param  string $sep
     * @return Range
     */
    public function setSeparator($sep)
    {
        $this->separator = $sep;
        return $this;
    }

    /**
     * Set the class 'on' name
     *
     * @param  string $class
     * @return AbstractPaginator
     */
    public function setClassOn($class)
    {
        $this->classOn = $class;
        return $this;
    }

    /**
     * Set the class 'off' name.
     *
     * @param  string $class
     * @return AbstractPaginator
     */
    public function setClassOff($class)
    {
        $this->classOff = $class;
        return $this;
    }

    /**
     * Get the bookend separator
     *
     * @return string
     */
    public function getSeparator()
    {
        return $this->separator;
    }

    /**
     * Get the page links
     *
     * @param  int $page
     * @return array
     */
    public function getLinkRange($page = 1)
    {
        $this->calculateRange($page);
        $this->createRange($page);

        return $this->links;
    }

    /**
     * Get the class 'on' name
     *
     * @return string
     */
    public function getClassOn()
    {
        return $this->classOn;
    }

    /**
     * Get the class 'off' name.
     *
     * @return string
     */
    public function getClassOff()
    {
        return $this->classOff;
    }

    /**
     * Create links
     *
     * @param  int  $page
     * @return void
     */
    protected function createRange($page = 1)
    {
        $this->currentPage = $page;

        // Generate the page links.
        $this->links = [];

        // Preserve any passed GET parameters.
        $query = null;
        $uri   = null;

        if (isset($_SERVER['REQUEST_URI'])) {
            $uri = (!empty($_SERVER['QUERY_STRING'])) ?
                str_replace('?' . $_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']) :
                $_SERVER['REQUEST_URI'];


            if (count($this->queryString) > 0) {
                foreach ($this->queryString as $key => $value) {
                    if ($key != $this->queryKey) {
                        $query  .= '&' . $key . '=' . $value;
                    }
                }
            }
        }

        // Calculate page range
        $pageRange = $this->calculateRange($page);

        for ($i = $pageRange['start']; $i <= $pageRange['end']; $i++) {
            $newLink  = null;
            $classOff = (null !== $this->classOff) ? sprintf(" class='%s'",$this->classOff) : null;
            $classOn = (null !== $this->classOn) ? sprintf(" class='%s'",$this->classOn) : null;

            $newLink = ($i == $page) ?sprintf("%s/admin/dashboard.php?wc=posts/home%s?",BASE,$classOff,$i) : sprintf("<li %s><a href='#' data-page='%s'>%s</a></li>",$classOn,$i,$i);

            if (($i == $pageRange['start']) && ($pageRange['prev'])) {
                if (null !== $this->bookends['start']) {
                    $this->links[] = sprintf("%s/admin/dashboard.php=hgf%s",$classOn,$this->bookends['start']);
                }
                if (null !== $this->bookends['previous']) {
                    $this->links[] = sprintf("%s/admin/dashboard.php=hgf%s",BASE,$classOn, ($i - 1),$this->bookends['previous']);
                }
            }

            $this->links[] = $newLink;

            if (($i == $pageRange['end']) && ($pageRange['next'])) {
                if (null !== $this->bookends['next']) {
                   $this->links[] = sprintf("%s/admin/dashboard.php=hgf%s",BASE,$classOn, ($i + 1),$this->bookends['next']);
                }
                if (null !== $this->bookends['end']) {
                   $this->links[] = sprintf("%s/admin/dashboard.php=hgf%s",BASE,$classOn, $this->numberOfPages,$this->bookends['end']);
                }
            }
        }
    }

    /**
     * Output the rendered page links
     *
     * @return string
     */
    public function __toString()
    {
        $page = (isset($this->queryString[$this->queryKey]) && ((int)$this->queryString[$this->queryKey] > 0)) ? (int)$this->queryString[$this->queryKey] : 1;
        return implode($this->separator, $this->getLinkRange($page));
    }

}
