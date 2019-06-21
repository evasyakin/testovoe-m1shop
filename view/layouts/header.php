<?php
/**
 * Шапка сайта.
 * @param string $title - заголовок страницы
 * @param string $pageId - id страницы
 * @param string|array $styles - доп.стили страницы
 */

if (! defined('APP_NAME') && APP_NAME !== 'CD-Collection') exit();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title ?? null ?> / CD-Collections</title>
    <link rel="stylesheet" type="text/css" href="<?= $baseUri ?>/assets/css/common.css">
    <?php if (! empty($styles)): ?>
        <?php if (is_string($styles)): ?>
            <link rel="stylesheet" type="text/css" href="<?= $styles ?>">
        <?php elseif (is_array($styles)): foreach ($styles as &$style): ?>
            <link rel="stylesheet" type="text/css" href="<?= $style ?>">
        <?php endforeach; endif; ?>
    <?php endif; ?>
</head>
<body <?= !empty($pageId) ? "id=\"$pageId\"" : '' ?>>

<!-- Тут может быть общая шапка -->

<div class="page-wrapper">
