<?php
namespace App\Services;

use Illuminate\Support\Collection;

class BladeUtilService
{
    /**
     * Construct
     */
    public function __construct()
    {
        // do something
    }

    /**
     * Convert collection to options required by select, checkbox or radio
     *
     * @param Collection $collection
     * @param string $idKey
     * @param string $textKey
     * @return assoicated array
     */
    public function collectionToOptions(Collection $collection, $idKey = 'id', $textKey = 'name')
    {
        $result = [];
        if (!empty($collection)) {
            $collection->each(function ($item) use (&$result, $idKey, $textKey) {
                $result[$item->{$idKey}] = $item->{$textKey};
            });
        }

        return $result;
    }

    /**
     * Convert associated array to source data required by select 2
     */
    public function arrayToSource($data)
    {
        $result = [];
        foreach ($data as $k => $v) {
            $result[] = [
                'id' => $k,
                'text' => $v,
            ];
        }

        return $result;
    }

    /**
     * Convert collection to source data required by select 2
     *
     * @param Collection $collection
     * @param string $idKey
     * @param string $textKey
     * @return array
     */
    public function collectionToSource(Collection $collection, $idKey, $textKey)
    {
        $result = [];
        if (!empty($collection)) {
            $result = $collection->map(function ($item) use ($idKey, $textKey) {
                return [
                    'id' => $item[$idKey],
                    'text' => $item[$textKey],
                ];
            })->toArray();
        }

        return $result;
    }

    /**
     * Get one column from collection
     *
     * @param Collection $collection
     * @param string $columnKey
     * @return array
     */
    public function columnOfCollection(Collection $collection, $columnKey)
    {
        $result = [];
        if (!empty($collection)) {
            $result = $collection->pluck($columnKey)->toArray();
        }

        return $result;
    }
}
