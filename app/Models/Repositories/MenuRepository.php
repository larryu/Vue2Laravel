<?php

namespace App\Models\Repositories;
use App\Models\Entities\Menu;
use Bosnadev\Repositories\Contracts\RepositoryInterface;
use Bosnadev\Repositories\Eloquent\Repository;
use DB;
class MenuRepository extends Repository
{
    const MENU_ID_ROOT = 1;
    public function model()
    {
        return 'App\Models\Entities\Menu';
    }
    public function getAll()
    {
        return $this->model->where('active',1)->get(['*', DB::raw("'RW' as permission")])->keyBy('id')->toArray();

    }
    public function getAllMenuNodes()
    {
        // get menu root
        $rootMenu = $this->find(self::MENU_ID_ROOT);
        $menuNods = [];
        $menuNods = $this->getAllChildren($rootMenu, $menuNods, $rootMenu->id);
        return $menuNods;

    }
    /**
     * @param $menu
     * @param null $result
     * @param int $starting
     * @return array|null
     */
    public function getAllChildren($menu, &$result = null, $starting = 0)
    {
        if($starting === 0) // initiate recursive function
        {
            $starting = $menu->id;
            $result = array();
        }
        else $result[$menu->id] = $this->model->with('parent')->where('active', 1)->find($menu->id)->toArray();

        $children = $this->model->where('parent_id', $menu->id)->where('active', 1)->get();
        foreach ($children as $child)
        {
            $this->getAllChildren($child, $result, $child->id);
        }
        return $result;
    }
    public function add($request)
    {
        $menu =  new Menu();
        $menu->parent_id = $request->input('parent_id');
        $menu->name = $request->input('name');
        $menu->link = $request->input('link');
        $menu->comment = $request->input('comment');
        $menu->save();
        return $menu;
    }
    public function save($request)
    {
        $menu =  $this->model->findOrFail($request->input('id'));
        $menu->name = $request->input('name');
        $menu->link = $request->input('link');
        $menu->comment = $request->input('comment');
        $menu->save();
        return $menu;
    }
    public function delete($request)
    {
        $menu =  $this->model->findOrFail($request->input('id'));

        // 1) check whether this menu has children if yes cannot be deleted
        $childrenMenu = $this->findAllBy('parent_id', $menu->id);
        if (count($childrenMenu) > 0)
        {
            throw new \Exception('You Cannot delete this menu because it has children menus.');
        }
        $menu->active = 0;
        $menu->save();
        return $menu;
    }
}
