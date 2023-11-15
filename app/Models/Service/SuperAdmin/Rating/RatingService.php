<?php
/**
 * Created by PhpStorm.
 * User: puspa
 * Date: 8/2/2018
 * Time: 11:12 AM
 */

namespace App\Models\Service\SuperAdmin\Rating;


use App\Models\Model\SuperAdmin\Rating\Rating;

class RatingService
{
  protected $rating;

  function __construct(Rating $rating)
  {
      $this->rating = $rating;
  }

  public function create(array $data)
  {
      try{
         return  $rating = $this->rating->create($data);
      }
      catch (\Exception $e)
      {
          return false;
      }
  }

    public function find($id)
    {
        try{
           return  $rating = $this->rating->find($id);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function update($id,array $data)
    {
        try{
            $rating = $this->rating->find($id);
            return  $rating = $rating->update($data);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $rating = $this->rating->find($id);
            return  $rating = $rating->delete();
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
    public function paginate($id,array $filter = [])
    {
        $filter['limit'] = 25;
        return $this->rating->orderBy('order','asc')->where('trip_id',$id)->paginate($filter['limit']);
    }

    /**
     * Get all Product Categorys
     *
     * @return Collection
     */
    public function all()
    {
        return $this->rating->get();
    }
    public function updateStatus($ids,$status)
    {
        return $this->rating->whereIn('id',$ids)->update(array('status'=>$status));
    }
    public function deletePost($ids)
    {
        return $this->rating->whereIn('id',$ids)->delete();
    }
    public function search($key)
    {
        $filter['limit']=25;
        return $this->rating->where(function($query) use ($key) {
            $terms = explode('-', $key);
            foreach ($terms as $t) {
                $query->where('title', 'LIKE', '%' . $t . '%');
            }
        })->paginate($filter['limit']);
    }
 }