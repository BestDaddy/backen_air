<?php


namespace App\Services;


use App\Services\BaseService;
use Illuminate\Database\Eloquent\Model;

class BaseServiceImpl implements BaseService
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseServiceImpl constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function allWith(array $relationships)
    {
        return $this->model->with($relationships)->get();
    }

    public function withWhere(array $relationships, array $params)
    {
        $query = $this->model->with($relationships);

        foreach ($params as $field => $value) {
            $query = $query->where($field, $value);
        }

        return $query->get();
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): Model
    {
        $model = $this->model->newInstance();
        $model->fill($attributes);
        $model->save();
        return $model;
    }

    /**
     * @inheritDoc
     */
    public function find($id): ?Model
    {
        $model = $this->model->findOrFail($id);

        return $model;
    }

    public function findWith($id, array $relationships)
    {
        return $this->model->with($relationships)->findOrFail($id);
    }

    public function firstWhere(array $params)
    {
        $query = $this->model;

        foreach ($params as $field => $value) {
            $query = $query->where($field, $value);
        }

        return $query->first();
    }

    public function getWhere(array $params)
    {
        $query = $this->model;

        foreach ($params as $field => $value) {
            $query = $query->where($field, $value);
        }

        return $query->get();
    }

    public function update($id, array $attributes) : bool
    {
        return $this->model::where($this->model->getKeyName(), $id)->update($attributes);
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }

    public function updateFirstWhere(array $params, array $attributes)
    {
        $model = $this->firstWhere($params);

        if (!empty($model)) {
            $model->update($attributes);
        }

        return $model;
    }

    public function store(array $params, array $attributes)
    {
        return $this->model::updateOrCreate($params, $attributes);
    }

    public function datatable(array $buttons, array $relationships)
    {
        $datatable = datatables()->of($this->model::with($relationships));
            if (in_array(self::DATATABLE_BUTTON_EDIT, $buttons)) {
                $datatable = $datatable->addColumn('edit', function ($data) {
                    return '<button
                         class=" btn btn-primary btn-sm btn-block "
                          data-id="' . $data->id . '"
                          onclick="editModel(event.target)"><i class="fas fa-edit" data-id="' . $data->id . '"></i> ' . 'Edit' . '</button>';
                });
            }
            if (in_array(self::DATATABLE_BUTTON_MORE, $buttons)) {
                $datatable = $datatable->addColumn('more', function ($data){
                    return '<a class="text-decoration-none"  href="' .$this->model->getTable(). '/'.$data->id.'"><button class="btn btn-primary btn-sm btn-block">'. 'More' .'</button></a>';
                });
            }

        return $datatable->rawColumns($buttons)->make();
    }
}
