<?php

namespace controller;

class MainController {
    
    private $mainLayoutView;

    public function __construct(\view\MainLayoutView $mainLayoutView) {
        $this->mainLayoutView = $mainLayoutView;
    }

    public function renderMainPage() {
   
    echo $this->mainLayoutView->render();
    }
}