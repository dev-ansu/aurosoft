
<?php 
    component("partials.cabecalho");
?>

    <div id="page-wrapper">

        <?php $this->load($view, $viewData); ?>
    
    </div>

<?php
    component("partials.rodape");
?>