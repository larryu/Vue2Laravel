<?php

namespace App\Models\Services;

use App\Models\Repositories\MenuRepository;

class MenuService
{
    protected $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }
    public function getAllMenuNodes()
    {
        return $this->menuRepository->getAllMenuNodes();
    }
    public function getAll()
    {
        return $this->menuRepository->getAll();
    }
    /**
     * @param $flat
     * @param $pidKey
     * @param null $idKey
     * @return mixed
     */
    public function getTreeMenus($flat, $pidKey, $idKey = null)
    {
        $grouped = array();
        foreach ($flat as $sub){
            $grouped[$sub[$pidKey]][] = $sub;
        }

        $fnBuilder = function($siblings) use (&$fnBuilder, $grouped, $idKey) {
            foreach ($siblings as $k => $sibling) {
                $id = $sibling[$idKey];
                if(isset($grouped[$id])) {
                    $sibling['children'] = $fnBuilder($grouped[$id]);
                }
                $siblings[$k] = $sibling;
            }

            return $siblings;
        };

        $tree = $fnBuilder($grouped[0]);

        return $tree;
    }
    public function update($request)
    {
        return $this->menuRepository->save($request);
    }
    public function add($request)
    {
        return $this->menuRepository->add($request);
    }
    public function delete($request)
    {
        return $this->menuRepository->delete($request);
    }
}