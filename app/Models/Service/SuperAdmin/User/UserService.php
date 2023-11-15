<?php

namespace App\Models\Service\SuperAdmin\User;
use App\Models\Model\SuperAdmin\User\User;


class UserService
{
  protected $user;

  function __construct(User $user)
  {
      $this->user = $user;
  }

  public function create(array $data)
  {
      try{
          return  $user = $this->user->create($data);
      }
      catch (\Exception $e)
      {
          return false;
      }
  }

    public function find($id)
    {
        try{
           return  $user = $this->user->find($id);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function update($id,array $data)
    {
        try{
            $user = $this->user->find($id);
            return  $user = $user->update($data);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $user = $this->user->find($id);
            return  $user = $user->delete();
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
        return $this->user->where('role','!=','superadmin')->paginate($filter['limit']);
    }

    /**
     * Get all Product Categorys
     *
     * @return Collection
     */
    public function all()
    {
        return $this->user->where('role','!=','superadmin')->get();
    }
    public function updateStatus($ids,$status)
    {
        return $this->user->whereIn('id',$ids)->update(array('status'=>$status));
    }
    public function deletePost($ids)
    {
        return $this->user->whereIn('id',$ids)->delete();
    }
    public function search($key)
    {
        $filter['limit']=25;
        return $this->user->where('role','!=','superadmin')->where(function($query) use ($key) {
            $terms = explode('-', $key);
            foreach ($terms as $t) {
                $query->where('name', 'LIKE', '%' . $t . '%');
            }
        })->paginate($filter['limit']);
    }
 }