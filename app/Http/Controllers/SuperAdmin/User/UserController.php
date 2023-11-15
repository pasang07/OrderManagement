<?php

namespace App\Http\Controllers\SuperAdmin\User;

use App\Http\Controllers\ImageController;
use App\Http\Requests\SuperAdmin\User\ChangePasswordRequest;
use App\Http\Requests\SuperAdmin\User\UserRequest;
use App\Http\Requests\SuperAdmin\User\UserUpdateRequest;
use App\Models\Model\SuperAdmin\User\User;
use App\Models\Service\SuperAdmin\User\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Kamaln7\Toastr\Facades\Toastr;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $user;
    protected $imageController;
    function __construct(UserService $user, ImageController $imageController)
    {
        $this->user=$user;
        $this->imageController=$imageController;
    }

    public function index()
    {
        if(Auth::user()->role=='superadmin'){

            $users= User::where('role', 'admin')->paginate();
        }else{
            $users= User::where('role', 'admin')->orWhere('role', 'demo')->paginate();
        }
        $users->append('user_role');

        $show_search='yes';
        return view('super-admin.user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('super-admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $userInfo=$request->all();
        $userInfo['password']=bcrypt($request['password']);
        $userInfo['is_verified'] = '1';
        $userInfo['is_new'] = 'no';
        $userInfo['created_by'] = Auth::user()->id;
        if($request->file('image')){
            $folder_name='User';
            $ImgName=$this->imageController->saveAnyImg($request,$folder_name,'image',100,100);
            $userInfo['image']=$ImgName;
        }
        if($this->user->create($userInfo)){
            Toastr::success('User created successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('user.index');
        }else{
            Toastr::error('Problem in creating user', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('user.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=$this->user->find($id);
        return view('super-admin.user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $userInfo=$request->all();
        $userInfo['password']=bcrypt($request['password']);
        $folder_name='User';
        $user=$this->user->find($id);
        if($request->file('image')==''){
            $userInfo['image']=$user->image;
        }
        else{
            $this->imageController->deleteImg($folder_name,$user->image);
            $ImgName=$this->imageController->saveAnyImg($request,$folder_name,'image',100,100);
            $userInfo['image']=$ImgName;
        }
        if($this->user->update($id, $userInfo)){
            Toastr::success('User updated successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('user.index');
        }else{
            Toastr::error('Problem in updating user', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('user.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=$this->user->find($id);
        if($this->user->delete($id)){
            $this->imageController->deleteImg('User',$user->image);
            Toastr::success('User deleted successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('user.index');
        }else{
            Toastr::error('Problem in deleting user', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('user.index');
        }
    }
    public function updateCredentialForm()
    {
        return view('super-admin.user.change-password');
    }
    public function updateCredential(ChangePasswordRequest $request)
    {
        $user=$this->user->find(Auth::user()->id);
        if(! Hash::check($request['oldpassword'],$user->password))
        {
            Toastr::error('Your Old Password does not match.', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('user.change-password-form');
        }
        $adminpassword['password']=bcrypt($request['password']);
        if($this->user->update(Auth::user()->id,$adminpassword)){
            Toastr::success('Password Changed successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('superadmin.logout');
        }else{
            Toastr::error('Problem in changing password', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('superadmin.dashboard');
        }
    }
    public function search()
    {
        $users=$this->user->search(str_slug($_GET['key']));
        $show_search='yes';
        return view('super-admin.user.index',compact('users'));
    }

    public function updateProfileForm($id)
    {
        $user = $this->user->find($id);
        return view('super-admin.user.profile-setting',compact('id','user'));
    }
    public function updateProfile(Request $request, $id)
    {
        $userInfo=$request->all();
        $folder_name='User';
        $user=$this->user->find($id);

        if($request->file('image')==''){
            $userInfo['image']=$user->image;
        }
        else{
            $this->imageController->deleteImg($folder_name,$user->image);
            $ImgName=$this->imageController->saveAnyImg($request,$folder_name,'image',100,100);
            $userInfo['image']=$ImgName;
        }
        if($this->user->update(Auth::user()->id,$userInfo)){
            Toastr::success('Profile updated successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('user.profile-setting-form',Auth::user()->id);
        }else{
            Toastr::error('Problem in updating profile', 'Oops !!!', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('user.profile-setting-form',Auth::user()->id);
        }
    }


    public function displayProfile($id)
    {
        $user = $this->user->find($id);
        return view('super-admin.user.myprofile',compact('id','user'));
    }
}
