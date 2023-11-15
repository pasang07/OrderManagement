<?php
namespace App\Models\Service\SuperAdmin\AgentCommission;
use App\Models\Model\SuperAdmin\AgentCommission\AgentCommission;


class AgentCommissionService
{
  protected $agentCommission;

  function __construct(AgentCommission $agentCommission)
  {
      $this->agentCommission = $agentCommission;
  }

  public function create(array $data)
  {
      try{
         return  $agentCommission = $this->agentCommission->create($data);
      }
      catch (\Exception $e)
      {
          return false;
      }
  }

    public function find($id)
    {
        try{
           return  $agentCommission = $this->agentCommission->find($id);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function update($id,array $data)
    {
        try{
            $agentCommission = $this->agentCommission->find($id);
            return  $agentCommission = $agentCommission->update($data);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $agentCommission = $this->agentCommission->find($id);
            return  $agentCommission = $agentCommission->delete();
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
        return $this->agentCommission->orderBy('order','asc')->paginate($filter['limit']);
    }

    /**
     * Get all Product Categorys
     *
     * @return Collection
     */
    public function all()
    {
        return $this->agentCommission->get();
    }
    public function updateStatus($ids,$status)
    {
        return $this->agentCommission->whereIn('id',$ids)->update(array('status'=>$status));
    }
    public function deletePost($ids)
    {
        return $this->agentCommission->whereIn('id',$ids)->delete();
    }
    public function search($key)
    {
        $filter['limit']=25;
        return $this->agentCommission->where(function($query) use ($key) {
            $terms = explode('-', $key);
            foreach ($terms as $t) {
                $query->where('title', 'LIKE', '%' . $t . '%');
            }
        })->paginate($filter['limit']);
    }
 }