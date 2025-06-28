<?php
if (!function_exists('getFillableSort')) {
    function getFillableSort($modelName, $customFields = [])
    {
        if ($modelName) {
            $model = "App\\Models\\$modelName";
            $instance = new $model();
            $attributes = $instance->getFillable();
            $attributes = array_merge($attributes, $customFields);
            // dd($attributes);
            return $attributes;
        } else {
            return [];
        }
    }
}
