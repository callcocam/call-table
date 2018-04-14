<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 13/04/2018
 * Time: 09:19
 */

namespace Table;



use Psr\Http\Message\ResponseInterface;

class PhpRenderer
{
    /**
     * @var string
     */
    protected $templatePath;

    /**
     * @var array
     */
    protected $attributes;

    protected $variable=[];

    /**
     * SlimRenderer constructor.
     *
     * @param string $templatePath
     * @param array $attributes
     */
    public function __construct($templatePath = "", $attributes = [])
    {
        $this->templatePath = rtrim($templatePath, '/\\') . '/';
        $this->attributes = $attributes;
    }

    /**
     * Render a template
     *
     * $data cannot contain template as a key
     *
     * throws RuntimeException if $templatePath . $template does not exist
     *
     * @param string $template
     * @param array $data
     *
     * @return ResponseInterface
     *
     * @throws \Exception
     * @throws \Throwable
     */
    public function render($template, array $data = [])
    {
        $output = $this->fetch($template, $data);


        return $output;
    }

    /**
     * Get the attributes for the renderer
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set the attributes for the renderer
     *
     * @param array $attributes
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Add an attribute
     *
     * @param $key
     * @param $value
     */
    public function addAttribute($key, $value) {
        $this->attributes[$key] = $value;
    }

    /**
     * Retrieve an attribute
     *
     * @param $key
     * @return mixed
     */
    public function getAttribute($key) {
        if (!isset($this->attributes[$key])) {
            return false;
        }

        return $this->attributes[$key];
    }

    /**
     * Get the template path
     *
     * @return string
     */
    public function getTemplatePath()
    {
        return $this->templatePath;
    }

    /**
     * Set the template path
     *
     * @param string $templatePath
     */
    public function setTemplatePath($templatePath)
    {
        $this->templatePath = rtrim($templatePath, '/\\') . '/';
    }

    /**
     * Renders a template and returns the result as a string
     *
     * cannot contain template as a key
     *
     * throws RuntimeException if $templatePath . $template does not exist
     *
     * @param $template
     * @param array $data
     *
     * @return mixed
     *
     * @throws \Exception
     * @throws \Throwable
     */
    public function fetch($template, array $data = []) {
        if (isset($data['template'])) {
            throw new \InvalidArgumentException("Duplicate template key found");
        }

        if (!is_file("{$this->templatePath}{$template}.phtml")) {
            throw new \RuntimeException("View cannot render `{$this->templatePath}{$template}.phtml` because the template does not exist");
        }


        /*
        foreach ($data as $k=>$val) {
            if (in_array($k, array_keys($this->attributes))) {
                throw new \InvalidArgumentException("Duplicate key found in data and renderer attributes. " . $k);
            }
        }
        */
        $data = array_merge($this->attributes, $data);

        try {
            ob_start();
            $this->protectedIncludeScope("{$this->templatePath}{$template}.phtml", $data);
            $output = ob_get_clean();
        } catch(\Throwable $e) { // PHP 7+
            ob_end_clean();
            throw $e;
        } catch(\Exception $e) { // PHP < 7
            ob_end_clean();
            throw $e;
        }

        return $output;
    }

    /**
     * @param string $template
     * @param array $data
     */
    protected function protectedIncludeScope ($template, array $data) {
        extract(array_merge($data,$this->variable));
        include func_get_arg(0);
    }

    /**
     * @param array $variable
     * @return PhpRenderer
     */
    public function setVariable($key, $variable ): PhpRenderer
    {
        $this->variable[$key] = $variable;
        return $this;
    }

    /**
     * @return array
     */
    public function getVariable(): array
    {
        return $this->variable;
    }
}