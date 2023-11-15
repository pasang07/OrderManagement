<?php

namespace App\Models\Service\SuperAdmin\ReferCustomer;
use App\Models\Model\SuperAdmin\ReferCustomer\ReferCustomer;


class ReferCustomerService
{
  protected $referCustomer;

  function __construct(ReferCustomer $referCustomer)
  {
      $this->referCustomer = $referCustomer;
  }

  public function create(array $data)
  {
      try{
         return  $referCustomer = $this->referCustomer->create($data);
      }
      catch (\Exception $e)
      {
          return false;
      }
  }

    public function find($id)
    {
        try{
           return  $referCustomer = $this->referCustomer->find($id);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function update($id,array $data)
    {
        try{
            $referCustomer = $this->referCustomer->find($id);
            return  $referCustomer = $referCustomer->update($data);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $referCustomer = $this->referCustomer->find($id);
            return  $referCustomer = $referCustomer->delete();
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
        return $this->referCustomer->orderBy('order','asc')->paginate($filter['limit']);
    }

    /**
     * Get all Product Categorys
     *
     * @return Collection
     */
    public function all()
    {
        return $this->referCustomer->get();
    }
    public function updateStatus($ids,$status)
    {
        return $this->referCustomer->whereIn('id',$ids)->update(array('status'=>$status));
    }
    public function deletePost($ids)
    {
        return $this->referCustomer->whereIn('id',$ids)->delete();
    }
    public function search($key)
    {
        $filter['limit']=25;
        return $this->referCustomer->where(function($query) use ($key) {
            $terms = explode('-', $key);
            foreach ($terms as $t) {
                $query->where('title', 'LIKE', '%' . $t . '%');
            }
        })->paginate($filter['limit']);
    }
 }