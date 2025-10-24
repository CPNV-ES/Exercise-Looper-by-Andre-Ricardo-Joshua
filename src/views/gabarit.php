<?php
$headerClass = '';
// Use regex to match dynamic routes for managing fields and editing them.
// This makes the class assignment work for any exercise ID.
if (str_starts_with($route, '/exercises/new') || preg_match('/^\/exercises\/\d+\/fields/', $route)) {
    $headerClass = 'creating';
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/solid.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/scaffold.css">
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
            <span class="exercise-label"><?= $title ?? ''?></span>
        </section>
    </header>
    <?php endif; ?>
    
    <main class="container">
        <div class="content">
            <?php
            // This includes the actual view content (e.g., exercises.php)
            if (isset($view_content_path)) {
                include $view_content_path;
            }
            ?>
        </div>
    </main>
</body>
</html>