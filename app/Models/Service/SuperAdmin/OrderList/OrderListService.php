<?php
namespace App\Models\Service\SuperAdmin\OrderList;
use App\Models\Model\SuperAdmin\OrderList\OrderList;


class OrderListService
{
  protected $orderList;

  function __construct(OrderList $orderList)
  {
      $this->orderList = $orderList;
  }

  public function create(array $data)
  {
      try{
         return  $orderList = $this->orderList->create($data);
      }
      catch (\Exception $e)
      {
          return false;
      }
  }

    public function find($id)
    {
        try{
           return  $orderList = $this->orderList->find($id);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function update($id,array $data)
    {
        try{
            $orderList = $this->orderList->find($id);
            return  $orderList = $orderList->update($data);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $orderList = $this->orderList->find($id);
            return  $orderList = $orderList->delete();
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
        $filter['limit'] = 50;
        return $this->orderList->orderBy('order','desc')->paginate($filter['limit']);
    }

    /**
     * Get all Product Categorys
     *
     * @return Collection
     */
    public function all()
    {
        return $this->orderList->get();
    }
    public function updateStatus($ids,$status)
    {
        return $this->orderList->whereIn('id',$ids)->update(array('status'=>$status));
    }
    public function deletePost($ids)
    {
        return $this->orderList->whereIn('id',$ids)->delete();
    }
    public function search($key)
    {
        $filter['limit']=50;
        return $this->orderList->where(function($query) use ($key) {
            $terms = explode('-', $key);
            foreach ($terms as $t) {
                $query->where('title', 'LIKE', '%' . $t . '%');
            }
        })->paginate($filter['limit']);
    }
 }