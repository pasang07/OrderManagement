<?php
namespace App\Models\Service\SuperAdmin\Service;
use App\Models\Model\SuperAdmin\Service\Service;


class ServiceService
{
  protected $service;

  function __construct(Service $service)
  {
      $this->service = $service;
  }

  public function create(array $data)
  {
      try{
         return  $service = $this->service->create($data);
      }
      catch (\Exception $e)
      {
         return false;
      }
  }

    public function find($id)
    {
        try{
           return  $service = $this->service->find($id);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function update($id,array $data)
    {
        try{
            $service = $this->service->find($id);
            return  $service = $service->update($data);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $this->service->where('parent_id',$id)->delete();
            $service = $this->service->find($id);
            return  $service = $service->delete();
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
        return $this->service->orderBy('order','asc')->where('parent_id',0)->paginate($filter['limit']);
    }
    public function parentPaginate($id){
        $filter['limit'] = 25;
        return $this->service->orderBy('order','asc')->where('parent_id',$id)->paginate($filter['limit']);
    }

    /**
     * Get all Product Categorys
     *
     * @return Collection
     */
    public function all()
    {
        return $this->service->all();
    }
    public function updateStatus($ids,$status)
    {
        return $this->service->whereIn('id',$ids)->update(array('status'=>$status));
    }
    public function deletePost($ids)
    {
        return $this->service->whereIn('id',$ids)->delete();
    }
    public function serviceByCategory($id)
    {
        $filter['limit'] = 25;
        return $this->service->whereCategoryId($id)->paginate($filter['limit']);
    }
    public function search($key)
    {
        $filter['limit']=25;
        return $this->service->where(function($query) use ($key) {
            $terms = explode('-', $key);
            foreach ($terms as $t) {
                $query->where('title', 'LIKE', '%' . $t . '%');
            }
        })->paginate($filter['limit']);
    }
 }