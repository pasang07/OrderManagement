<?php
namespace App\Models\Service\SuperAdmin\Contact;
use App\Models\Model\SuperAdmin\Contact\Contact;


class ContactService
{
  protected $contact;

  function __construct(Contact $contact)
  {
      $this->contact = $contact;
  }

  public function create(array $data)
  {
      try{
         return  $contact = $this->contact->create($data);
      }
      catch (\Exception $e)
      {
          return false;
      }
  }

    public function find($id)
    {
        try{
           return  $contact = $this->contact->find($id);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function update($id,array $data)
    {
        try{
            $contact = $this->contact->find($id);
            return  $contact = $contact->update($data);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $contact = $this->contact->find($id);
            return  $contact = $contact->delete();
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
        return $this->contact->paginate($filter['limit']);
    }

    /**
     * Get all Product Categorys
     *
     * @return Collection
     */
    public function all()
    {
        return $this->contact->orderBy('created_at','desc')->get();
    }
    public function updateStatus($ids,$status)
    {
        return $this->contact->whereIn('id',$ids)->update(array('status'=>$status));
    }
    public function deletePost($ids)
    {
        return $this->contact->whereIn('id',$ids)->delete();
    }
    public function search($key)
    {
        $filter['limit']=25;
        return $this->contact->where(function($query) use ($key) {
            $terms = explode('-', $key);
            foreach ($terms as $t) {
                $query->where('email', 'LIKE', '%' . $t . '%');
            }
        })->paginate($filter['limit']);
    }

 }