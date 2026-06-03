<?php

declare(strict_types=1);

/**
 * Master layout — matches original HTML document structure.
 *
 * @var string $content
 * @var string $pageTitle
 * @var string $metaDescription
 * @var string $metaKeywords
 * @var string $canonicalUrl
 * @var string $ogImage
 * @var bool $showTicker
 */
$siteName = (string) ($siteName ?? config('site.name'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($pageTitle) ?></title>
<meta name="description" content="<?= e($metaDescription) ?>">
<meta name="keywords" content="<?= e($metaKeywords) ?>">
<meta name="robots" content="index, follow">
<link rel="canonical" href="<?= e($canonicalUrl) ?>">

<link rel="icon" type="image/png" sizes="32x32" href="<?= e(asset('images/favicon-32x32.png')) ?>">
<link rel="icon" type="image/png" sizes="16x16" href="<?= e(asset('images/favicon-16x16.png')) ?>">
<link rel="apple-touch-icon" sizes="180x180" href="<?= e(asset('images/apple-touch-icon.png')) ?>">

<meta property="og:type" content="website">
<meta property="og:title" content="<?= e($pageTitle) ?>">
<meta property="og:description" content="<?= e($metaDescription) ?>">
<meta property="og:url" content="<?= e($canonicalUrl) ?>">
<meta property="og:image" content="<?= e($ogImage) ?>">
<meta property="og:site_name" content="<?= e($siteName) ?>">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= e($pageTitle) ?>">
<meta name="twitter:description" content="<?= e($metaDescription) ?>">
<meta name="twitter:image" content="<?= e($ogImage) ?>">

<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,300;12..96,400;12..96,500;12..96,600;12..96,700;12..96,800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= e(asset('css/site.css')) ?>">
<?php if (!empty($extraStylesheet)): ?>
<link rel="stylesheet" href="<?= e(asset($extraStylesheet)) ?>">
<?php endif; ?>
</head>
<body>

<?php require dirname(__DIR__, 2) . '/Components/whatsapp-float.php'; ?>
<?php require dirname(__DIR__, 2) . '/Layouts/navigation.php'; ?>
<?php if (!empty($showTicker)) {
    require dirname(__DIR__, 2) . '/Components/ticker.php';
} ?>

<?= $content ?>

<?php require dirname(__DIR__, 2) . '/Layouts/footer.php'; ?>

<script src="<?= e(asset('js/site.js')) ?>"></script>
</body>
</html>
