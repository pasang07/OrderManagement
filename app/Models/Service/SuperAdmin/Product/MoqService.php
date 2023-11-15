<?php
namespace App\Models\Service\SuperAdmin\Product;
use App\Models\Model\SuperAdmin\Product\Moq;
class MoqService
{
    protected $moq;

    function __construct(Moq $moq)
    {
        $this->moq = $moq;
    }

    public function create(array $data)
    {
        return  $moq = $this->moq->create($data);
        try{
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function find($id)
    {
        try{
            return  $moq = $this->moq->find($id);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function update($id,array $data)
    {
        try{
            $moq = $this->moq->find($id);
            return  $moq = $moq->update($data);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $moq = $this->moq->find($id);
            return  $moq = $moq->delete();
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
        return $this->moq->orderBy('created_at')->paginate($filter['limit']);
    }

    /**
     * Get all Product Categorys
     *
     * @return Collection
     */
    public function all()
    {
        return $this->moq->all();
    }
    public function getAll($id)
    {
        return $this->moq->get();
    }
    public function updateStatus($ids,$status)
    {
        return $this->moq->whereIn('id',$ids)->update(array('status'=>$status));
    }
    public function deletePost($ids)
    {
        return $this->moq->whereIn('id',$ids)->delete();
    }
}