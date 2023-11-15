<?php
/**
 * Created by PhpStorm.
 * User: Suresh
 * Date: 8/2/2018
 * Time: 11:12 AM
 */

namespace App\Models\Service\SuperAdmin\SiteSetting;

use App\Models\Model\SuperAdmin\SiteSetting\SiteSetting;


class SiteSettingService
{
  protected $siteSetting;

  function __construct(SiteSetting $siteSetting)
  {
      $this->siteSetting = $siteSetting;
  }

  public function create(array $data)
  {
      try{
         return  $this->siteSetting->create($data);
      }
      catch (\Exception $e)
      {
          return false;
      }
  }

    public function find($id)
    {
        try{
           return  $this->siteSetting->find($id);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function update($id,array $data)
    {
        try{
            $siteSetting = $this->siteSetting->find($id);
            return  $siteSetting = $siteSetting->update($data);
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    public function delete($id)
    {
        try{
            $siteSetting = $this->siteSetting->find($id);
            return  $siteSetting = $siteSetting->delete();
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
        return $this->siteSetting->paginate($filter['limit']);
    }

    /**
     * Get all Product Categorys
     *
     * @return Collection
     */
    public function all()
    {
        return $this->siteSetting->where('role','!=','superadmin')->get();
    }
    public function updateStatus($ids,$status)
    {
        return $this->siteSetting->whereIn('id',$ids)->update(array('status'=>$status));
    }
    public function deletePost($ids)
    {
        return $this->siteSetting->whereIn('id',$ids)->delete();
    }

 }
