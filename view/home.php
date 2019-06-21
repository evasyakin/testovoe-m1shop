<?php
/**
 * Главная страница.
 */
use base\App;

if (! defined('APP_NAME') && APP_NAME !== 'CD-Collection') exit();

$this->layout('header', [
    'title' => 'Добро пожаловать в коллекции альбомов',
    'pageId' => 'home',
    'styles' => App::getUri() . '/assets/css/site.css',
]);

?>

<div class="hello">
    <h1>Добро пожаловать в коллекции альбомов</h1>
    <a href="<?= App::getUri() ?>/cabinet">Перейти в коллекции</a>
</div>

<?php

$this->layout('footer');
