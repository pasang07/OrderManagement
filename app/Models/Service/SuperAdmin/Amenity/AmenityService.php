<?php

namespace App\Models\Service\SuperAdmin\Amenity;
use App\Models\Model\SuperAdmin\Amenity\Amenity;


class AmenityService
{
  protected $amenity;

  function __construct(Amenity $amenity)
  {
      $this->amenity = $amenity;
  }

  public function create(array $data)
  {
      try{
         return  $amenity = $this->amenity->create($data);
      }
      catch (\Exception $e)
      {
          return false;
      }
  }

    public function find($id)
    {
        try{
           return  $amenity = $this->amenity->find($id);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function update($id,array $data)
    {
        try{
            $amenity = $this->amenity->find($id);
            return  $amenity = $amenity->update($data);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $amenity = $this->amenity->find($id);
            return  $amenity = $amenity->delete();
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
        return $this->amenity->orderBy('order','asc')->paginate($filter['limit']);
    }

    /**
     * Get all Product Categorys
     *
     * @return Collection
     */
    public function all()
    {
        return $this->amenity->get();
    }
    public function updateStatus($ids,$status)
    {
        return $this->amenity->whereIn('id',$ids)->update(array('status'=>$status));
    }
    public function deletePost($ids)
    {
        return $this->amenity->whereIn('id',$ids)->delete();
    }
    public function search($key)
    {
        $filter['limit']=25;
        return $this->amenity->where(function($query) use ($key) {
            $terms = explode('-', $key);
            foreach ($terms as $t) {
                $query->where('title', 'LIKE', '%' . $t . '%');
            }
        })->paginate($filter['limit']);
    }
 }