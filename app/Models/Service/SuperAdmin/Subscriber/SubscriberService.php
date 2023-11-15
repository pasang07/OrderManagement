<?php
/**
 * Created by PhpStorm.
 * User: Suresh
 * Date: 8/2/2018
 * Time: 11:12 AM
 */

namespace App\Models\Service\SuperAdmin\Subscriber;




use App\Models\Model\SuperAdmin\Subscriber\Subscriber;


class SubscriberService
{
  protected $subscriber;

  function __construct(Subscriber $subscriber)
  {
      $this->subscriber = $subscriber;
  }

  public function create(array $data)
  {
      try{
         return  $subscriber = $this->subscriber->create($data);
      }
      catch (\Exception $e)
      {
          return false;
      }
  }

    public function find($id)
    {
        try{
           return  $subscriber = $this->subscriber->find($id);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function update($id,array $data)
    {
        try{
            $subscriber = $this->subscriber->find($id);
            return  $subscriber = $subscriber->update($data);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $subscriber = $this->subscriber->find($id);
            return  $subscriber = $subscriber->delete();
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
        return $this->subscriber->paginate($filter['limit']);
    }

    /**
     * Get all Product Categorys
     *
     * @return Collection
     */
    public function all()
    {
        return $this->subscriber->where('role','!=','superadmin')->get();
    }
    public function updateStatus($ids,$status)
    {
        return $this->subscriber->whereIn('id',$ids)->update(array('status'=>$status));
    }
    public function deletePost($ids)
    {
        return $this->subscriber->whereIn('id',$ids)->delete();
    }
    public function search($key)
    {
        $filter['limit']=25;
        return $this->subscriber->where(function($query) use ($key) {
            $terms = explode('-', $key);
            foreach ($terms as $t) {
                $query->where('email', 'LIKE', '%' . $t . '%');
            }
        })->paginate($filter['limit']);
    }

 }