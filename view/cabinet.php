<?php
/**
 * Страница коллекций.
 */
use base\App;

if (! defined('APP_NAME') && APP_NAME !== 'CD-Collection') exit();

$this->layout('header', [
    'title' => 'Коллекции CD',
    'pageId' => 'cabinet',
    'styles' => App::getUri() . '/assets/css/cabinet.css',
]);

?>

<div id="cabinet"></div>

<script type="text/javascript" src="<?= App::getUri() ?>/assets/js/cabinet/Ajax.js"></script>
<script type="text/javascript" src="<?= App::getUri() ?>/assets/js/cabinet/Api.js"></script>
<script type="text/javascript" src="<?= App::getUri() ?>/assets/js/cabinet/App.js"></script>
<script type="text/javascript" src="<?= App::getUri() ?>/assets/js/cabinet/Route.js"></script>
<script type="text/javascript" src="<?= App::getUri() ?>/assets/js/cabinet/Router.js"></script>
<script type="text/javascript" src="<?= App::getUri() ?>/assets/js/cabinet/Store.js"></script>
<script type="text/javascript">

var app = new App({
    selector: '#cabinet',
    router: {
        routes: [
            { 
                path: 'collection', title: 'Коллекция',
                component: <?= $this->component('collection.php'); ?>,
                data () {
                    return {
                        'collection.name': this.store.collection.name,
                    };
                },
                mounted () {
                    <?= json_decode($this->component('collection.js')) ?>
                },
            },
            { 
                path: 'collection-edit', title: 'Редактирование коллекции',
                component: <?= $this->component('collection-edit.php'); ?>,
                mounted () {
                    <?= json_decode($this->component('collection-edit.js')) ?>
                },
            },
            { 
                path: 'album-edit', title: 'Редактирование альбома',
                component: <?= $this->component('album-edit.php'); ?>,
                mounted () {
                    <?= json_decode($this->component('album-edit.js')) ?>
                },
            },
        ],
        default: { redirect: 'collection' },
    },
    store: {
        collection: {
            name: 'Тест',
            albums: [
                {
                    name: 'Альбом 1',
                    artist: 'evas',
                }
            ],
        },
    },
    api: {
        collection: {
            show () {
                return '';
            },
            save () {
                return '';
            },
        },
        album: {
            save () {
                return '';
            },
            drop () {
                return '';
            }
        }
    },
});
    
</script>

<?php

$this->layout('footer');
