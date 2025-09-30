<?php
$headerClass = '';
if (str_starts_with($route, '/exercises/new')) {
    $headerClass = 'create';
} elseif (str_starts_with($route, '/exercises/answering')) {
    $headerClass = 'answering';
} elseif (str_starts_with($route, '/exercises')) {
    $headerClass = 'managing';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/style.css">
    <title><?= $title ?? 'Exercise Looper' ?></title>
</head>
<body>
    <?php if ($route === '/'): ?>
        <header class="dashboard">
            <section class="container">
                <p><img src="/assets/logo.png"></p>
                <h1>Exercise<br>Looper</h1>
            </section>
        </header>
    <?php else: ?>
        <header class="heading <?= $headerClass ?>">
            <section class="container">
                <a href="/"><img src="/assets/logo.png"></a>
            </section>
        </header>
    <?php endif; ?>
    
    <div class="content">
        <?php
        // This includes the actual view content (e.g., exercises.php)
        if (isset($view_content_path)) {
            include $view_content_path;
        }
        ?>
    </div>
</body>
</html>