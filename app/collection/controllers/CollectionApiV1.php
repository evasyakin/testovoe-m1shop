<?php
namespace collection\controllers;

use \Excpetion;
use base\custom\ApiV1Controller;
use collection\models\Collection;
use collection\validators\CollectionIdField;
use collection\validators\SaveCollectionFieldset;

/**
 * Контроллер коллекций для Api V1.
 */
class CollectionApiV1 extends ApiV1Controller
{
    /**
     * Получение коллекции.
     * @api POST /api/v1/collection/show
     */
    public function show()
    {
        try {
            $collectionId = 1;

            // можно вынести в метод кусок логики
            $collection = Collection::findById($collectionId)->extract();

            $this->response->sendJson(200, $collection);
        } catch (Excpetion $e) {
            $this->response->sendError($e->getCode(), $e->getMessage());
        }
    }

    /**
     * Сохранение коллекции.
     * @api POST /api/v1/collection/save
     */
    public function save()
    {
         try {
            $params = $this->request->getParams();
            (new SaveCollectionFieldset)->throwIfNotValid($params);

            $hasId = isset($params['id']);
        
            // можно вынести в метод кусок логики
            if ($hasId) {
                $collection = Collection::findById($params['id']);
                if (empty($collection)) throw new Exception(Collection::ERROR_NOT_FOUND, 404);
                foreach ($params as $name => $value) {
                    $collection->$name = $value;
                }
            } else  {
                $collection = Collection::create($params);
            }
            $collection->save();

            $this->response->sendJson(200, $collection->extractSaved());
        } catch (Exception $e) {
            $this->response->sendError($e->getCode(), $e->getMessage());
        }
    }

    /**
     * Удаление коллекции.
     * @api POST /api/v1/collection/drop
     */
    public function drop()
    {
        try {
            $collectionId = $this->request->getParams('id');
            (new CollectionIdField)->throwIfNotValid($collectionId);

            // можно вынести в метод кусок логики
            $collection = Collection::findById($collectionId);
            if (empty($collection)) throw new Exception(Collection::ERROR_NOT_FOUND, 404);
            $collection->softDeleted();
            
            $this->response->send(200, 'ok');
        } catch (Exception $e) {
            $this->response->sendError($e->getCode(), $e->getMessage());
        }
    }
}
