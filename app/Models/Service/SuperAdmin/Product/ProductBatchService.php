<?php
namespace App\Models\Service\SuperAdmin\Product;
use App\Models\Model\SuperAdmin\Product\ProductBatch;


class ProductBatchService
{
  protected $productbatch;

  function __construct(ProductBatch $productbatch)
  {
      $this->product = $productbatch;
  }

  public function create(array $data)
  {
      try{
         return  $productbatch = $this->product->create($data);
      }
      catch (\Exception $e)
      {
          return false;
      }
  }

    public function find($id)
    {
        try{
           return  $productbatch = $this->product->find($id);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function update($id,array $data)
    {
        try{
            $productbatch = $this->product->find($id);
            return  $productbatch = $productbatch->update($data);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $productbatch = $this->product->find($id);
            return  $productbatch = $productbatch->delete();
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
        $filter['limit'] = 50;
        return $this->product->orderBy('created_at','desc')->paginate($filter['limit']);
    }

    /**
     * Get all Product Categorys
     *
     * @return Collection
     */
    public function all()
    {
        return $this->product->get();
    }
    public function updateStatus($ids,$status)
    {
        return $this->product->whereIn('id',$ids)->update(array('status'=>$status));
    }
    public function deletePost($ids)
    {
        return $this->product->whereIn('id',$ids)->delete();
    }
    public function search($key)
    {
        $filter['limit']=25;
        return $this->product->where(function($query) use ($key) {
            $terms = explode('-', $key);
            foreach ($terms as $t) {
                $query->where('batch_no', 'LIKE', '%' . $t . '%');
            }
        })->paginate($filter['limit']);
    }
 }