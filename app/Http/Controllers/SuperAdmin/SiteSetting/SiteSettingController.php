<?php

namespace App\Http\Controllers\SuperAdmin\SiteSetting;

use App\Http\Controllers\ImageController;
use App\Http\Requests\SuperAdmin\SiteSetting\SiteSettingRequest;
use App\Models\Service\SuperAdmin\SiteSetting\SiteSettingService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kamaln7\Toastr\Facades\Toastr;

class SiteSettingController extends Controller
{
    protected $siteSetting;
    protected $imageController;
    function __construct(SiteSettingService $siteSetting, ImageController $imageController)
    {
        $this->siteSetting=$siteSetting;
        $this->imageController=$imageController;
    }
    public function edit($id)
    {
        $siteSetting=$this->siteSetting->find($id);
        return view('super-admin.site-setting.index',compact('siteSetting'));
    }
    public function update(SiteSettingRequest $request, $id)
    {
        $siteSettingInfo=$request->all();
        $folder_name='Nav';
        $siteSetting=$this->siteSetting->find($id);

        if($request->file('logo_image')==''){
            if($request->get('delete_logo_image')){
                $this->imageController->deleteImg($folder_name,$siteSetting->logo_image);
                $siteSettingInfo['logo_image'] = NULL;
            }else {
                $siteSettingInfo['logo_image'] = $siteSetting->logo_image;
            }
        }
        else{
            $this->imageController->deleteImg($folder_name,$siteSetting->logo_image);
            $ImgName=$this->imageController->saveAnyImg($request,$folder_name,'logo_image',664,286);
            $siteSettingInfo['logo_image']=$ImgName;
        }


        if($this->siteSetting->update($id, $siteSettingInfo)){
            alert()->success('Setting updated successfully', 'Success !!!')->persistent('Close');
            return redirect()->route('site-setting.edit',1);
        }else{
            alert()->error('Problem in updating site setting', 'Oops !!!')->persistent('Close');
            return redirect()->route('site-setting.edit',1);
        }
    }
}
