<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class BaseService
{
    protected $repository;

    /**
     * @var Model
     */
    protected $entity;

    /**
     * @param $repository
     */
    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param array $params
     * @return Model
     */
    public function save(array $params): Model
    {
        return $this->repository->save($params);
    }

    /**
     * @param int $id
     * @param array $params
     * @return Model
     * @throws \Exception
     */
    public function update(int $id, array $params): Model
    {
        $entity = $this->getRepository()->find($id);
        if (null === $entity) {
            throw new \Exception('Entity not found.');
        }

        if (isset($params['file'])) {
            $imagePath = $params['file']->store('images', 'public');
            $params['image'] = $imagePath;
            unset($params['file']);
        }

        return $this->repository->update($entity, $params);
    }

    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getPaginationList(array $params)
    {
        return $this->getRepository()->getPaginationList($params);
    }
}
