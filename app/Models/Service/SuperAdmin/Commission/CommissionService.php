<?php
namespace App\Models\Service\SuperAdmin\Commission;
use App\Models\Model\SuperAdmin\Commission\Commission;

class CommissionService
{
  protected $commission;

  function __construct(Commission $commission)
  {
      $this->commission = $commission;
  }

  public function create(array $data)
  {
      try{
         return  $commission = $this->commission->create($data);
      }
      catch (\Exception $e)
      {
          return false;
      }
  }

    public function find($id)
    {
        try{
           return  $commission = $this->commission->find($id);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function update($id,array $data)
    {
        try{
            $commission = $this->commission->find($id);
            return  $commission = $commission->update($data);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $commission = $this->commission->find($id);
            return  $commission = $commission->delete();
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
        return $this->commission->orderBy('order','asc')->paginate($filter['limit']);
    }

    /**
     * Get all Product Categorys
     *
     * @return Collection
     */
    public function all()
    {
        return $this->commission->get();
    }
    public function updateStatus($ids,$status)
    {
        return $this->commission->whereIn('id',$ids)->update(array('status'=>$status));
    }
    public function deletePost($ids)
    {
        return $this->commission->whereIn('id',$ids)->delete();
    }
    public function search($key)
    {
        $filter['limit']=25;
        return $this->commission->where(function($query) use ($key) {
            $terms = explode('-', $key);
            foreach ($terms as $t) {
                $query->where('title', 'LIKE', '%' . $t . '%');
            }
        })->paginate($filter['limit']);
    }
 }