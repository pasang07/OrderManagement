<?php
namespace App\Models\Service\SuperAdmin\Amenity;
use App\Models\Model\SuperAdmin\Amenity\AmenityQuery;


class AmenityQueryService
{
  protected $amenityQuery;

  function __construct(AmenityQuery $amenityQuery)
  {
      $this->amenityQuery = $amenityQuery;
  }

  public function create(array $data)
  {
      try{
         return  $amenityQuery = $this->amenityQuery->create($data);
      }
      catch (\Exception $e)
      {
          return false;
      }
  }

    public function find($id)
    {
        try{
           return  $amenityQuery = $this->amenityQuery->find($id);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function update($id,array $data)
    {
        try{
            $amenityQuery = $this->amenityQuery->find($id);
            return  $amenityQuery = $amenityQuery->update($data);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $amenityQuery = $this->amenityQuery->find($id);
            return  $amenityQuery = $amenityQuery->delete();
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
        return $this->amenityQuery->orderBy('order','desc')->paginate($filter['limit']);
    }

    /**
     * Get all Product Categorys
     *
     * @return Collection
     */
    public function all()
    {
        return $this->amenityQuery->orderBy('order','desc')->get();
    }
    public function updateStatus($ids,$status)
    {
        return $this->amenityQuery->whereIn('id',$ids)->update(array('status'=>$status));
    }
    public function deletePost($ids)
    {
        return $this->amenityQuery->whereIn('id',$ids)->delete();
    }
    public function search($key)
    {
        $filter['limit']=25;
        return $this->amenityQuery->where(function($query) use ($key) {
            $terms = explode('-', $key);
            foreach ($terms as $t) {
                $query->where('email', 'LIKE', '%' . $t . '%');
            }
        })->paginate($filter['limit']);
    }

 }