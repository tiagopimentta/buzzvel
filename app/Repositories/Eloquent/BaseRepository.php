<?php

namespace App\Repositories\Eloquent;

use App\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements RepositoryInterface
{
    public function __construct(protected Model $model){}

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function update($id, $data)
    {
        $record = $this->model->find($id);
        $record->update($data);

        return $record;
    }

    public function delete($id)
    {
        $request = $this->model->find($id);
        $request->delete();

        return $request;
    }
}
