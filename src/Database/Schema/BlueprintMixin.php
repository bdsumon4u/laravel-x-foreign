<?php

namespace Hotash\XForeign\Database\Schema;

use Illuminate\Database\Schema\Blueprint;

/**
 * @mixin Blueprint
 */
class BlueprintMixin
{
    public function xForeign()
    {
        return fn ($columns, $name = null) => ignorable($this->foreign($columns, $name), ! config('x-foreign.constrained'));
    }

    public function xForeignId()
    {
        return fn ($column) =>
            /** @var \Illuminate\Database\Schema\Blueprint $this */
            $this->addColumnDefinition(new ExclusiveForeign($this, [
                'type' => 'bigInteger',
                'name' => $column,
                'autoIncrement' => false,
                'unsigned' => true,
            ]));
    }

    public function xForeignUuid()
    {
        return fn ($column) =>
            /** @var \Illuminate\Database\Schema\Blueprint $this */
            $this->addColumnDefinition(new ExclusiveForeign($this, [
                'type' => 'uuid',
                'name' => $column,
            ]));
    }

    public function xForeignIdFor()
    {
        return function ($model, $column = null) {
            if (is_string($model)) {
                $model = new $model;
            }

            /** @var \Illuminate\Database\Schema\Blueprint $this */
            return $model->getKeyType() === 'int' && $model->getIncrementing()
                ? $this->xForeignId($column ?: $model->getForeignKey())
                : $this->xForeignUuid($column ?: $model->getForeignKey());
        };
    }
}
