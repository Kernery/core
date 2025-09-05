<?php

namespace Kernery\Main\Traits;

trait HasTreeStep
{
    public static function updateTree(array $data): void
    {
        $tree = static::flatTree($data);

        static::upsert($tree, ['id', 'name'], ['parent_id', 'order']);
    }

    protected static function flatTree(array $data, array &$tree = [], string|int $parentId = 0): array
    {
        foreach ($data as $order => $item) {
            $tree[] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'order' => $order,
                'parent_id' => $parentId,
            ];

            if (!empty($item['children'])) {
                static::flatTree($item['children'], $tree, $item['id']);
            }
        }

        return $tree;
    }
}
