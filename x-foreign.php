<?php

namespace Illuminate\Database\Schema
{

    use Hotash\XForeign\Database\Schema\ExclusiveForeign;

    class Blueprint
    {
        public function xForeign($column): ForeignKeyDefinition
        {
        }

        public function xForeignId($column): ExclusiveForeign
        {
        }

        public function xForeignIdUuid($column): ExclusiveForeign
        {
        }

        public function xForeignIdFor($model, $column = null): ExclusiveForeign
        {
        }
    }
}
