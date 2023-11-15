<?php
/**
 * Created by PhpStorm.
 * User: Suresh
 * Date: 8/2/2018
 * Time: 11:12 AM
 */

namespace App\Models\Service\SuperAdmin\Gallery;




use App\Models\Model\SuperAdmin\Gallery\Gallery;


class GalleryService
{
  protected $gallery;

  function __construct(Gallery $gallery)
  {
      $this->gallery = $gallery;
  }

  public function create(array $data)
  {
      try{
//          dd($data);
         return  $gallery = $this->gallery->create($data);
      }
      catch (\Exception $e)
      {
         return false;
      }
  }

    public function find($id)
    {
        try{
           return  $gallery = $this->gallery->find($id);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function update($id,array $data)
    {
        try{
            $gallery = $this->gallery->find($id);
            return  $gallery = $gallery->update($data);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $gallery = $this->gallery->find($id);
            return  $gallery = $gallery->delete();
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
        return $this->gallery->orderBy('order')->where('album_id',$id)->paginate($filter['limit']);
    }

    /**
     * Get all Product Categorys
     *
     * @return Collection
     */
    public function all()
    {
        return $this->gallery->all();
    }

    public function updateStatus($ids,$status)
    {
        return $this->gallery->whereIn('id',$ids)->update(array('status'=>$status));
    }
    public function deletePost($ids)
    {
        return $this->gallery->whereIn('id',$ids)->delete();
    }
    public function search($key)
    {
        $filter['limit']=25;
        return $this->gallery->where(function($query) use ($key) {
            $terms = explode('-', $key);
            foreach ($terms as $t) {
                $query->where('title', 'LIKE', '%' . $t . '%');
            }
        })->paginate($filter['limit']);
    }
 }