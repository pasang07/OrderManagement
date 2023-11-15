<?php
namespace App\Models\Service\SuperAdmin\Amenity;
use App\Models\Model\SuperAdmin\Amenity\AmenityGallery;


class AmenityGalleryService
{
  protected $amenityGallery;

  function __construct(AmenityGallery $amenityGallery)
  {
      $this->amenityGallery = $amenityGallery;
  }

  public function create(array $data)
  {
      try{
//          dd($data);
         return  $amenityGallery = $this->amenityGallery->create($data);
      }
      catch (\Exception $e)
      {
         return false;
      }
  }

    public function find($id)
    {
        try{
           return  $amenityGallery = $this->amenityGallery->find($id);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function update($id,array $data)
    {
        try{
            $amenityGallery = $this->amenityGallery->find($id);
            return  $amenityGallery = $amenityGallery->update($data);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $amenityGallery = $this->amenityGallery->find($id);
            return  $amenityGallery = $amenityGallery->delete();
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    /**
     * Paginate all Product AmenityList
     *
     * @param array $filter
     * @return Collection
     */
    public function paginate($id,array $filter = [])
    {
        $filter['limit'] = 25;
        return $this->amenityGallery->orderBy('order')->where('amenity_id',$id)->paginate($filter['limit']);
    }

    /**
     * Get all Product Categorys
     *
     * @return Collection
     */
    public function all()
    {
        return $this->amenityGallery->all();
    }

    public function updateStatus($ids,$status)
    {
        return $this->amenityGallery->whereIn('id',$ids)->update(array('status'=>$status));
    }
    public function deletePost($ids)
    {
        return $this->amenityGallery->whereIn('id',$ids)->delete();
    }
    public function galleryByAmenity($id)
    {
        $filter['limit'] = 25;
        return $this->amenityGallery->whereRaw('FIND_IN_SET('.$id.',amenity_id)')->paginate($filter['limit']);
    }
    public function search($key)
    {
        $filter['limit']=25;
        return $this->amenityGallery->where(function($query) use ($key) {
            $terms = explode('-', $key);
            foreach ($terms as $t) {
                $query->where('title', 'LIKE', '%' . $t . '%');
            }
        })->paginate($filter['limit']);
    }
 }