<?php
namespace App\Models\Service\SuperAdmin\Amenity;
use App\Models\Model\SuperAdmin\Amenity\AmenityFaq;


class AmenityFaqService
{
  protected $amenityFaq;

  function __construct(AmenityFaq $amenityFaq)
  {
      $this->amenityFaq = $amenityFaq;
  }

  public function create(array $data)
  {
      try{
//          dd($data);
         return  $amenityFaq = $this->amenityFaq->create($data);
      }
      catch (\Exception $e)
      {
         return false;
      }
  }

    public function find($id)
    {
        try{
           return  $amenityFaq = $this->amenityFaq->find($id);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function update($id,array $data)
    {
        try{
            $amenityFaq = $this->amenityFaq->find($id);
            return  $amenityFaq = $amenityFaq->update($data);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $amenityFaq = $this->amenityFaq->find($id);
            return  $amenityFaq = $amenityFaq->delete();
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
        return $this->amenityFaq->orderBy('order')->where('amenity_id',$id)->paginate($filter['limit']);
    }

    /**
     * Get all Product Categorys
     *
     * @return Collection
     */
    public function all()
    {
        return $this->amenityFaq->all();
    }

    public function updateStatus($ids,$status)
    {
        return $this->amenityFaq->whereIn('id',$ids)->update(array('status'=>$status));
    }
    public function deletePost($ids)
    {
        return $this->amenityFaq->whereIn('id',$ids)->delete();
    }
    public function galleryByAmenity($id)
    {
        $filter['limit'] = 25;
        return $this->amenityFaq->whereRaw('FIND_IN_SET('.$id.',amenity_id)')->paginate($filter['limit']);
    }
    public function search($key)
    {
        $filter['limit']=25;
        return $this->amenityFaq->where(function($query) use ($key) {
            $terms = explode('-', $key);
            foreach ($terms as $t) {
                $query->where('title', 'LIKE', '%' . $t . '%');
            }
        })->paginate($filter['limit']);
    }
 }