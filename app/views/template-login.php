<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= asset("/output.css") ?>" rel="stylesheet">
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <title><?= $title ?? 'Document' ?></title>
</head>
<body>
    
    <div class="alert-container absolute top-5 right-5">
        <?= getFlash("message") ?>
    </div>
    <main class="h-screen w-full bg-[#1d1d1d] flex justify-center items-center p-4">
        <?php $this->load($view, $viewData); ?>
    </main>


</body>
</html>