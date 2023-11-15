<?php
/**
 * Created by PhpStorm.
 * User: Suresh
 * Date: 8/2/2018
 * Time: 11:12 AM
 */

namespace App\Models\Service\SuperAdmin\Menu;






use App\Models\Model\SuperAdmin\Menu\Nav;

class NavService
{
  protected $nav;

  function __construct(Nav $nav)
  {
      $this->nav = $nav;
  }

  public function create(array $data)
  {
      try{
//          dd($data);
         return  $nav = $this->nav->create($data);
      }
      catch (\Exception $e)
      {
         return false;
      }
  }

    public function find($id)
    {
        try{
           return  $nav = $this->nav->find($id);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function update($id,array $data)
    {
        try{
            $nav = $this->nav->find($id);
            return  $nav = $nav->update($data);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $this->nav->where('parent_id',$id)->delete();
            $nav = $this->nav->find($id);
            return  $nav = $nav->delete();
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    /**
     * Paginate all Product PageList
     *
     * @param array $filter
     * @return Collection
     */
    public function paginate(array $filter = [])
    {
        $filter['limit'] = 25;
        return $this->nav->orderBy('order','asc')->where('parent_id',0)->paginate($filter['limit']);
    }
    public function parentPaginate($id){
        $filter['limit'] = 25;
        return $this->nav->orderBy('order','asc')->where('parent_id',$id)->paginate($filter['limit']);
    }

    /**
     * Get all Product Categorys
     *
     * @return Collection
     */
    public function all()
    {
        return $this->nav->all();
    }
    public function updateStatus($ids,$status)
    {
        return $this->nav->whereIn('id',$ids)->update(array('status'=>$status));
    }
    public function deletePost($ids)
    {
        return $this->nav->whereIn('id',$ids)->delete();
    }
    public function search($key)
    {
        $filter['limit']=25;
        return $this->nav->where(function($query) use ($key) {
            $terms = explode('-', $key);
            foreach ($terms as $t) {
                $query->where('title', 'LIKE', '%' . $t . '%');
            }
        })->paginate($filter['limit']);
    }
 }