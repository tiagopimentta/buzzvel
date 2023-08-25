<?php

namespace App\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @param array $params
     * @return Model
     */
    public function save(array $params): Model
    {
        return $this->getModel()->forceCreate($this->formatParams($params));
    }

    /**
     * @param Model $entity
     * @param array $data
     * @return Model
     */
    public function update(Model $entity, array $data): Model
    {
        $entity->forceFill($this->formatParams($data))->update();
        return $this->find($entity->id);
    }

    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        $entity = $this->find($id);
        $entity->delete();
    }

    /**
     * @param array $params
     * @param string $value
     * @param null $default
     * @return mixed
     */
    public function getAttribute(array $params, string $value, $default = null): mixed
    {
        return (isset($params[$value])) ? $params[$value] : $default;
    }

    /**
     * @param array $params
     * @param array $with
     * @param int|null $perPage
     * @return mixed
     */
    public function getPaginationList(array $params, array $with = [], int $perPage = null): mixed
    {
        return $this
            ->getModel()
            ->with($with)
            ->simplePaginate($perPage)
            ->withQueryString();
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): Model|null
    {
        $model = $this->getModel()->find($id);
        if (!$model) {
            throw new \Exception('Object not found.');
        }
        return $model;
    }

    /**
     * @param array $params
     * @return array
     */
    public function formatParams(array $params): array
    {
        return $params;
    }
}
