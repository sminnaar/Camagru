<?php

class View {

    protected $_head;
    protected $_body;
    protected $_outputBuffer;
    protected $_siteTitle = SITE_TITLE;
    protected $_layout = DEF_LAYOUT;

    public function __construct() {
    
    }

    public function render($viewName) {
        $viewArray = explode('/', $viewName);
        $viewString = implode(DS, $viewArray);
        if (file_exists(ROOT . DS . 'app' . DS . 'views' . DS . $viewString . '.php')) {
            include(ROOT . DS . 'app' . DS . 'views' . DS . $viewString . '.php');
            include(ROOT . DS . 'app' . DS . 'views' . DS . 'layouts' . DS . $this->_layout . '.php');
        } else {
            die('The view \" ' . $viewName . ' \" does not exists.');
        }
    }

    public function content($type) {
        if ($type == 'head') {
            return $this->_head;
        } else if ($type == 'body') {
            return $this->_body;
        } else {
            return false;
        }
    }

    public function start($type) {
        $this->_outputBuffer = $type;
        ob_start();
    }
    
    public function end() {
        if ($this->_outputBuffer == 'head') {
            $this->_head = ob_get_clean();
        } else if ($this->_outputBuffer == 'body') {
            $this->_body = ob_get_clean();
        } else {
            die('You must first run the start method');
        }
    }

    public function siteTitle() {
        return SITE_TITLE . ' | ' . $this->_siteTitle;
    }

    public function setSiteTitle($title) {
        $this->_siteTitle = $title;
    }

    public function setLayout($path) {
        $this->_layout = $path;
    }
}