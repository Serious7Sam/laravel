<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class ModelManipulationRepository implements ModelManipulationRepositoryInterface
{
    /**
     * @param Model $model
     *
     * @return bool
     */
    public function save(Model $model)
    {
        try {
            $model->save();
        } catch (QueryException $e) {
            return false;
        }

        return true;
    }

    /**
     * @param Model $model
     *
     * @return bool
     */
    public function delete(Model $model)
    {
        try {
            $model->delete();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
