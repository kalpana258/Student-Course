<?php
namespace src\core;

use src\core\CustomException;

class Views
{
    private $data = array();

    private $render = false;

    public function __construct($template)
    {
        try {
            $file = $_SERVER['DOCUMENT_ROOT'] . '/view/' . strtolower($template) ;
            if (file_exists($file)) {
                $this->render = $file;
            } else {
                throw new CustomException('Template ' . $template . ' not found!');
            }
        } catch (CustomException $e) {
            echo $e->customFunction();
        }
    }

    public function assign($variable, $value)
    {
        $this->data[$variable] = $value;
    }

    public function __destruct()
    {
        extract($this->data);
        include($this->render);
    }
}
