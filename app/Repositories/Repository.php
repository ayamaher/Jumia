<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class Repository implements RepositoryInterface
{
    // model property on class instances
    protected $model;


    // Constructor to bind model to repo
    public function __construct(Model $model)
    {
        $this->model = $model;
    }


    public function show($id)
    {
        return $this->model->findOrFail($id);
    }


    // Get all instances of model
    public function all()
    {
        return $this->model->all();
    }


    public function get()
    {
        return $this->model->get();
    }


    // create a new record in the database
    public function create(array $data)
    {
        return $this->model->create($data);
    }


    // insert a new record in the database
    public function insert(array $data)
    {
        return $this->model->insert($data);
    }


    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->model->findOrFail($id);
        $record->update($data);
        return $record;
    }


    public function updateMany($ids, array $data)
    {
        return $this->model
                    ->whereIn($this->model->getKeyName(), $ids)
                    ->update($data);
    }


    public function findMany(array $ids)
    {
        return $this->model->findMany($ids);
    }


    // remove record from the database
    public function destroy($id)
    {
        $record = $this->model->findOrFail($id);

        return $record->destroy($id);
    }


    // show the record with the given id
    public function find($id)
    {
        return $this->model->find($id);
    }


    // show the record with the given id
    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }


    public function exists($id)
    {
        return $this->model->where('id', $id)->exists();
    }


    // update record or create it if not exist
    public function updateOrCreate($data, $data2)
    {
        return $this->model->updateOrCreate($data, $data2);
    }


    public function firstOrCreate($data, $data2 = [])
    {
        if (empty($data2)) {
            return $this->model->firstOrCreate($data);
        }

        return $this->model->firstOrCreate($data, $data2);
    }


    // Get the associated model
    public function getModel()
    {
        return $this->model;
    }


    // Set the associated model
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }


    // Eager load database relationships
    public function with($relations)
    {
        return $this->model->with($relations);
    }


    public function whereDate($column, $operator, $value = null)
    {
        return $this->model->whereDate($column, $operator, $value = null);
    }


    public function updateWhere(array $where, array $values)
    {
        return $this->model->where($where)->update($values);
    }


    public function getList(array $filters)
    {
        $select = (isset($filters['select'][0])) ? $this->model->select($filters['select']) : $this->model;

        return $select
                ->where(@$filters['where'])
                ->with(@$filters['with'] ?: [])
                ->paginate($filters['count']);
    }


    public function __call($method, $arguments)
    {
        return call_user_func_array([$this->model, $method], $arguments);
    }
}
