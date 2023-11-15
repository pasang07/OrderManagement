<?php
/**
 * Created by PhpStorm.
 * User: Suresh
 * Date: 8/2/2018
 * Time: 11:12 AM
 */

namespace App\Models\Service\SuperAdmin\Reservation;




use App\Models\Model\SuperAdmin\Reservation\Reservation;


class ReservationService
{
  protected $reservation;

  function __construct(Reservation $reservation)
  {
      $this->reservation = $reservation;
  }

  public function create(array $data)
  {
      try{
         return  $reservation = $this->reservation->create($data);
      }
      catch (\Exception $e)
      {
         return false;
      }
  }

    public function find($id)
    {
        try{
           return  $reservation = $this->reservation->find($id);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function update($id,array $data)
    {
        try{
            $reservation = $this->reservation->find($id);
            return  $reservation = $reservation->update($data);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $banner = $this->reservation->find($id);
            return  $banner = $banner->delete();
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
        return $this->reservation->orderBy('created_at','desc')->paginate($filter['limit']);
    }

    /**
     * Get all Product Categorys
     *
     * @return Collection
     */
    public function all()
    {
        return $this->reservation->all();
    }
    public function updateStatus($ids,$status)
    {
        return $this->reservation->whereIn('id',$ids)->update(array('status'=>$status));
    }
    public function deletePost($ids)
    {
        return $this->reservation->whereIn('id',$ids)->delete();
    }
    public function reservationByCategory($id)
    {
        $filter['limit'] = 25;
        return $this->reservation->whereCategoryId($id)->paginate($filter['limit']);
    }
    public function search($key)
    {
        $filter['limit']=25;
        return $this->reservation->where(function($query) use ($key) {
            $terms = explode('-', $key);
            foreach ($terms as $t) {
                $query->where('title', 'LIKE', '%' . $t . '%');
            }
        })->paginate($filter['limit']);
    }
 }