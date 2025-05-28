
<?php

use app\services\Config\ConfigService;

$config = (new ConfigService())->fetch();

    component("partials.cabecalho", [
        'config' => $config,
        'title' => @$title]);
?>

    <div id="page-wrapper">

        <?php $this->load($view, $viewData); ?>
    
    </div>

<?php
    component("partials.rodape", [
        'config' => $config,
    ]);
?>