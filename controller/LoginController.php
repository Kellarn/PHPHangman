<?php

namespace controller;

class LoginController {
    
    private $layoutView;

    public function __construct(\view\LayoutView $layoutView) {

        $this->layoutView = $layoutView;
    }
    
    public function renderPage() {

    return $this->layoutView->render();
    }
}