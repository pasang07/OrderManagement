<?php
namespace App\Models\Service\SuperAdmin\Blog;
use App\Http\Controllers\ImageController;
use App\Models\Model\SuperAdmin\Blog\Blog;


class BlogService
{
  protected $blog;
  protected $imageController;

  function __construct(Blog $blog, ImageController $imageController)
  {
      $this->blog = $blog;
      $this->imageController=$imageController;
  }

  public function create(array $data, $file)
  {
      try{
//          dd($data);
          return $blog = $this->blog->create($data);
//         $blog = $this->blog->create($data);
//         $blog->addMedia($file)->toMediaCollection();
//         return $blog;
      }
      catch (\Exception $e)
      {
         return false;
      }
  }

    public function find($id)
    {
        try{
           return  $blog = $this->blog->find($id);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function update($id,array $data)
    {
        try{
            $blog = $this->blog->find($id);
            return  $blog = $blog->update($data);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $blog = $this->blog->find($id);
            return  $blog = $blog->delete();
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
        return $this->blog->orderBy('order')->paginate($filter['limit']);
    }

    /**
     * Get all Product Categorys
     *
     * @return Collection
     */
    public function all()
    {
        return $this->blog->all();
    }

    public function updateStatus($ids,$status)
    {
        return $this->blog->whereIn('id',$ids)->update(array('status'=>$status));
    }
    public function deletePost($ids)
    {
        return $this->blog->whereIn('id',$ids)->delete();
    }
    public function search($key)
    {
        $filter['limit']=25;
        return $this->blog->where(function($query) use ($key) {
            $terms = explode('-', $key);
            foreach ($terms as $t) {
                $query->where('title', 'LIKE', '%' . $t . '%');
            }
        })->paginate($filter['limit']);
    }
 }