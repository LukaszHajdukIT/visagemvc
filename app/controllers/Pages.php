<?php

class Pages extends Controller {
    private $postModel;

    public function __construct()
    {
       
    }

    public function index()
    {
        $data = [
            'title' => 'VisageMVC',
        ];

        return $this->view('pages/index', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'About us'
        ];

       return $this->view('pages/about', $data);
    }
}