<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

interface ModelManipulationRepositoryInterface
{
    /**
     * @param Model $model
     *
     * @return bool
     */
    public function save(Model $model);

    /**
     * @param Model $model
     *
     * @return bool
     */
    public function delete(Model $model);
}
