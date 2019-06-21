<?php
namespace collection\controllers;

use \Exception;
use base\custom\ApiV1Controller;
use collection\models\Album;
use collection\validators\SaveAlbumFieldset;
use collection\validators\AlbumIdField;

/**
 * Контроллер альбомов для Api V1.
 */
class AlbumApiV1 extends ApiV1Controller
{
    /**
     * Сохранение альбома.
     * @api POST /api/v1/album/save
     */
    public function save()
    {
        try {
            $params = $this->request->getParams();
            (new SaveAlbumFieldset)->throwIfNotValid($params);

            $hasId = isset($params['id']);
        
            // можно вынести в метод кусок логики
            if ($hasId) {
                $album = Album::findById($params['id']);
                if (empty($album)) throw new Exception(Album::ERROR_NOT_FOUND, 404);
                foreach ($params as $name => $value) {
                    $album->$name = $value;
                }
            } else  {
                $album = Album::create($params);
            }
            $album->save();


            $this->response->sendJson(200, $album->extract());
        } catch (Exception $e) {
            $this->response->sendError($e->getCode(), $e->getMessage());
        }
    }

    /**
     * Удаление альбома.
     * @api POST /api/v1/album/drop
     */
    public function drop()
    {
        try {
            $albumId = $this->request->getParams('id');
            (new AlbumIdField)->throwIfNotValid($albumId);

            // можно вынести в метод кусок логики
            $album = Album::findById($albumId);
            if (empty($album)) throw new Exception(Album::ERROR_NOT_FOUND, 404);
            $album->softDeleted();
            
            $this->response->send(200, 'ok');
        } catch (Exception $e) {
            $this->response->sendError($e->getCode(), $e->getMessage());
        }
    }
}
