<?php
/**
 * Created by PhpStorm.
 * User: Suresh
 * Date: 8/2/2018
 * Time: 11:12 AM
 */

namespace App\Models\Service\SuperAdmin\Page;




use App\Models\Model\SuperAdmin\Page\Page;


class PageService
{
  protected $page;

  function __construct(Page $page)
  {
      $this->page = $page;
  }

  public function create(array $data)
  {
      try{
//          dd($data);
         return  $page = $this->page->create($data);
//         $page = $this->page->create($data);
//         $page->addMedia($file)->toMediaCollection();
//         return $page;
      }
      catch (\Exception $e)
      {
         return false;
      }
  }

    public function find($id)
    {
        try{
           return  $page = $this->page->find($id);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function update($id,array $data)
    {
        try{
            $page = $this->page->find($id);
            return  $page = $page->update($data);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $this->page->where('parent_id',$id)->delete();
            $page = $this->page->find($id);
            return  $page = $page->delete();
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
        return $this->page->orderBy('order','asc')->where('parent_id',0)->paginate($filter['limit']);
    }
    public function parentPaginate($id){
        $filter['limit'] = 25;
        return $this->page->orderBy('order','asc')->where('parent_id',$id)->paginate($filter['limit']);
    }
    /**
     * Get all Product Categorys
     *
     * @return Collection
     */
    public function all()
    {
        return $this->page->all();
    }
    public function updateStatus($ids,$status)
    {
        return $this->page->whereIn('id',$ids)->update(array('status'=>$status));
    }
    public function deletePost($ids)
    {
        return $this->page->whereIn('id',$ids)->delete();
    }
    public function search($key)
    {
        $filter['limit']=25;
        return $this->page->where(function($query) use ($key) {
            $terms = explode('-', $key);
            foreach ($terms as $t) {
                $query->where('title', 'LIKE', '%' . $t . '%');
            }
        })->paginate($filter['limit']);
    }
 }