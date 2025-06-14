<?php
namespace app\contracts;


interface ControllerContract{
    
    public function load(string $viewName, array $viewData = []);
    
}