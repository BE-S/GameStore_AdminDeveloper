<?php


namespace App\Helpers;

class Collection
{
    public static function getColumnsFromCollection($collection, $column)
    {
        $value = [];

        foreach ($collection as $item) {
            array_push($value, $item[$column]);
        }
        return $value;
    }

    public static function getAssociativeFromCollection($collection, $columnOne, $columnTwo)
    {
        $value = collect();

        foreach ($collection as $item) {
            $value[$item[$columnOne]] = $item[$columnTwo];
        }
        return $value;
    }
    //$value[$columnOne] = $item[$columnTwo];
}
