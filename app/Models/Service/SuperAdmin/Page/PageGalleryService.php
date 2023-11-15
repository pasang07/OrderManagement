<?php
namespace App\Models\Service\SuperAdmin\Page;
use App\Models\Model\SuperAdmin\Page\PageGallery;


class PageGalleryService
{
  protected $pageGallery;

  function __construct(PageGallery $pageGallery)
  {
      $this->pageGallery = $pageGallery;
  }

  public function create(array $data)
  {
      try{
//          dd($data);
         return  $pageGallery = $this->pageGallery->create($data);
      }
      catch (\Exception $e)
      {
         return false;
      }
  }

    public function find($id)
    {
        try{
           return  $pageGallery = $this->pageGallery->find($id);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function update($id,array $data)
    {
        try{
            $pageGallery = $this->pageGallery->find($id);
            return  $pageGallery = $pageGallery->update($data);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $pageGallery = $this->pageGallery->find($id);
            return  $pageGallery = $pageGallery->delete();
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
        return $this->pageGallery->orderBy('order')->where('page_id',$id)->paginate($filter['limit']);
    }

    /**
     * Get all Product Categorys
     *
     * @return Collection
     */
    public function all()
    {
        return $this->pageGallery->all();
    }

    public function updateStatus($ids,$status)
    {
        return $this->pageGallery->whereIn('id',$ids)->update(array('status'=>$status));
    }
    public function deletePost($ids)
    {
        return $this->pageGallery->whereIn('id',$ids)->delete();
    }
    public function galleryByPage($id)
    {
        $filter['limit'] = 25;
        return $this->pageGallery->whereRaw('FIND_IN_SET('.$id.',page_id)')->paginate($filter['limit']);
    }
    public function search($key)
    {
        $filter['limit']=25;
        return $this->pageGallery->where(function($query) use ($key) {
            $terms = explode('-', $key);
            foreach ($terms as $t) {
                $query->where('title', 'LIKE', '%' . $t . '%');
            }
        })->paginate($filter['limit']);
    }
 }