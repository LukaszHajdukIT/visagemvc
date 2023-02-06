<?php
    /*
     * App Core Class
     * Creates URL & Loads core controller
     * URL FORMAT - /controller/method/params
    */

class Core
{
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct()
    {
        //print_r($this->getUrl());

        $url = $this->getUrl();

        // Look in controllers for first value
        // path defined from public folder because there is a instiantiated class
        // ucword() function capitalize first letter
        if(file_exists('../app/controllers/' . ucwords(isset($url[0])) . '.php')){
            // If exists, set as controller
            $this->currentController = ucwords($url[0]);
            // Unset 0 index
            unset($url[0]);  
        }

        // Require the controller
        require_once '../app/controllers/' . $this->currentController . '.php';

        // Instantiate controller class
        // example - $pages = new Pages();
        $this->currentController = new $this->currentController;

        // Check for second part of url
        if(isset($url[1])){
            // Check to see if method exists in controller
            if(method_exists($this->currentController, $url[1])){
                $this->currentMethod = $url[1];

                //Unset 1 index
                unset($url[1]);
            }
        }

        // Get params
        $this->params = $url ? array_values($url) : [];

        // Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl()
    {
        if(isset($_GET['url'])) {
            // Trim "/" form end of string
           $url = rtrim($_GET['url'], '/');

           // remove all illegal URL character from a string.
           $url = filter_var($url, FILTER_SANITIZE_URL);

           // convert url to array for example:
           // /posts/edit/1 will be
           // Array ( [0] => posts [1] => edit [2] => 1 )
           $url = explode('/', $url);

           return $url;
        }
    }
}