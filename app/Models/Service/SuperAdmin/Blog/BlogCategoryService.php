<?php
/**
 * Created by PhpStorm.
 * User: Suresh
 * Date: 8/2/2018
 * Time: 11:12 AM
 */

namespace App\Models\Service\SuperAdmin\Blog;




use App\Models\Model\SuperAdmin\Blog\BlogCategory;


class BlogCategoryService
{
  protected $blogCategory;

  function __construct(BlogCategory $blogCategory)
  {
      $this->blogCategory = $blogCategory;
  }

  public function create(array $data)
  {
      try{
         return  $blogCategory = $this->blogCategory->create($data);
      }
      catch (\Exception $e)
      {
          return false;
      }
  }

    public function find($id)
    {
        try{
           return  $blogCategory = $this->blogCategory->find($id);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function update($id,array $data)
    {
        try{
            $blogCategory = $this->blogCategory->find($id);
            return  $blogCategory = $blogCategory->update($data);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $blogCategory = $this->blogCategory->find($id);
            return  $blogCategory = $blogCategory->delete();
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
        return $this->blogCategory->paginate($filter['limit']);
    }

    /**
     * Get all Product Categorys
     *
     * @return Collection
     */
    public function all()
    {
        return $this->blogCategory->all();
    }
    public function search($key)
    {
        $filter['limit']=25;
        return $this->blogCategory->where(function($query) use ($key) {
            $terms = explode('-', $key);
            foreach ($terms as $t) {
                $query->where('title', 'LIKE', '%' . $t . '%');
            }
        })->paginate($filter['limit']);
    }

 }