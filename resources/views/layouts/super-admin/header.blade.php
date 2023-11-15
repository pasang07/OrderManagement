@if(Auth::user()->is_new == 'no')
    <!-- [ Header ] start -->
<header class="navbar pcoded-header navbar-expand-lg navbar-light">
    <div class="m-header">
        <a class="mobile-menu" id="mobile-collapse1" href="javascript:"><span></span></a>
        <a href="{{route('superadmin.dashboard')}}" class="b-brand">
      <div class="b-bg">
                    <i class="fas fa-user"></i>
                </div>
                <span class="b-title">{{SITE_TITLE}}</span>
        </a>
    </div>
    <a class="mobile-menu" id="mobile-header" href="javascript:">
        <i class="fa fa-more-horizontal"></i>
    </a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ml-auto">
          
          @if(isset($show_search))
            <li class="nav-item">
                <form method="get" action="{{url('super-admin/'.Request::segment(2).'/search')}}" enctype="multipart/form-data" autocomplete="off" data-parsley-validate novalidate>
                    {{--@csrf--}}
                <div class="main-search">
                    <div class="input-group">
                        <input type="text" id="m-search" name="key" class="form-control" placeholder="Search . . ." required autofocus>
                        <a href="javascript:" class="input-group-append search-close">
                        </a>
                        <span class="input-group-append search-btn btn btn-primary">
                            <i class="icon fas fa-eye input-group-text"></i>
                        </span>
                    </div>
                </div>
                </form>
            </li>
          @endif
             
            <li>
                <a href="javascript:void(0)" onclick="window.history.go(-1); return false;" title="Go Back"> <i class="fa fa-arrow-left"></i> </a>
            </li>
            <li>
                <div class="dropdown drp-user">
                    @if(Auth::user()->image)
                    <a href="javascript:" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{asset('uploads/User/thumbnail/'.Auth::user()->image)}}" class="img-radius profile-img" alt="User-Profile-Image">
                    </a>
                    @else
                    <a href="javascript:" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{asset('resources/super-admin/images/user/user.jpg')}}" class="img-radius profile-img" alt="User-Profile-Image">
                    </a>
                    @endif
                    <div class="dropdown-menu dropdown-menu-right profile-notification">
                        <div class="pro-head">
                            @if(Auth::user()->image)
                                <img src="{{asset('uploads/User/thumbnail/'.Auth::user()->image)}}" class="img-radius" alt="User-Profile-Image">
                            @else
                                <img src="{{asset('resources/super-admin/images/user/user.jpg')}}" class="img-radius" alt="User-Profile-Image">
                            @endif
                            <span>{{Auth::user()->name}}</span>
                        </div>
                        <ul class="pro-body">
                            <li><a href="{{route('user.profile-view',Auth::user()->id)}}" class="dropdown-item"><i class="fa fa-tachometer-alt"></i> Your Profile</a></li>
                            <li><a href="{{route('user.change-password-form')}}" class="dropdown-item"><i class="fa fa-key"></i> Change-Password</a></li>
                            <li><a href="{{route('superadmin.logout')}}" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </li>
      </ul>
    </div>
</header>
<!-- [ Header ] end -->

<!-- [ chat user list ] start -->
<section class="header-user-list">
    <div class="h-list-header">
        <div class="input-group">
            <input type="text" id="search-friends" class="form-control" placeholder="Search Friend . . .">
        </div>
    </div>
    <div class="h-list-body">
        <a href="javascript:" class="h-close-text"><i class="fa fa-chevrons-right"></i></a>
        <div class="main-friend-cont scroll-div">
            <div class="main-friend-list">
                <div class="media userlist-box" data-id="1" data-status="online" data-username="Josephin Doe">
                    <a class="media-left" href="javascript:"><img class="media-object img-radius" src="{{asset('resources/super-admin/images/user/avatar-1.jpg')}}" alt="Generic placeholder image ">
                        <div class="live-status">3</div>
                    </a>
                    <div class="media-body">
                        <h6 class="chat-header">Josephin Doe<small class="d-block text-c-green">Typing . . </small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="2" data-status="online" data-username="Lary Doe">
                    <a class="media-left" href="javascript:"><img class="media-object img-radius" src="{{asset('resources/super-admin/images/user/avatar-1.jpg')}}" alt="Generic placeholder image">
                        <div class="live-status">1</div>
                    </a>
                    <div class="media-body">
                        <h6 class="chat-header">Lary Doe<small class="d-block text-c-green">online</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="3" data-status="online" data-username="Alice">
                    <a class="media-left" href="javascript:"><img class="media-object img-radius" src="{{asset('resources/super-admin/images/user/avatar-1.jpg')}}" alt="Generic placeholder image"></a>
                    <div class="media-body">
                        <h6 class="chat-header">Alice<small class="d-block text-c-green">online</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="4" data-status="offline" data-username="Alia">
                    <a class="media-left" href="javascript:"><img class="media-object img-radius" src="{{asset('resources/super-admin/images/user/avatar-1.jpg')}}" alt="Generic placeholder image">
                        <div class="live-status">1</div>
                    </a>
                    <div class="media-body">
                        <h6 class="chat-header">Alia<small class="d-block text-muted">10 min ago</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="5" data-status="offline" data-username="Suzen">
                    <a class="media-left" href="javascript:"><img class="media-object img-radius" src="{{asset('resources/super-admin/images/user/avatar-1.jpg')}}" alt="Generic placeholder image"></a>
                    <div class="media-body">
                        <h6 class="chat-header">Suzen<small class="d-block text-muted">15 min ago</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="1" data-status="online" data-username="Josephin Doe">
                    <a class="media-left" href="javascript:"><img class="media-object img-radius" src="{{asset('resources/super-admin/images/user/avatar-1.jpg')}}" alt="Generic placeholder image ">
                        <div class="live-status">3</div>
                    </a>
                    <div class="media-body">
                        <h6 class="chat-header">Josephin Doe<small class="d-block text-c-green">Typing . . </small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="2" data-status="online" data-username="Lary Doe">
                    <a class="media-left" href="javascript:"><img class="media-object img-radius" src="{{asset('resources/super-admin/images/user/avatar-1.jpg')}}" alt="Generic placeholder image">
                        <div class="live-status">1</div>
                    </a>
                    <div class="media-body">
                        <h6 class="chat-header">Lary Doe<small class="d-block text-c-green">online</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="3" data-status="online" data-username="Alice">
                    <a class="media-left" href="javascript:"><img class="media-object img-radius" src="{{asset('resources/super-admin/images/user/avatar-1.jpg')}}" alt="Generic placeholder image"></a>
                    <div class="media-body">
                        <h6 class="chat-header">Alice<small class="d-block text-c-green">online</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="4" data-status="offline" data-username="Alia">
                    <a class="media-left" href="javascript:"><img class="media-object img-radius" src="{{asset('resources/super-admin/images/user/avatar-1.jpg')}}" alt="Generic placeholder image">
                        <div class="live-status">1</div>
                    </a>
                    <div class="media-body">
                        <h6 class="chat-header">Alia<small class="d-block text-muted">10 min ago</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="5" data-status="offline" data-username="Suzen">
                    <a class="media-left" href="javascript:"><img class="media-object img-radius" src="{{asset('resources/super-admin/images/user/avatar-1.jpg')}}" alt="Generic placeholder image"></a>
                    <div class="media-body">
                        <h6 class="chat-header">Suzen<small class="d-block text-muted">15 min ago</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="1" data-status="online" data-username="Josephin Doe">
                    <a class="media-left" href="javascript:"><img class="media-object img-radius" src="{{asset('resources/super-admin/images/user/avatar-1.jpg')}}" alt="Generic placeholder image ">
                        <div class="live-status">3</div>
                    </a>
                    <div class="media-body">
                        <h6 class="chat-header">Josephin Doe<small class="d-block text-c-green">Typing . . </small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="2" data-status="online" data-username="Lary Doe">
                    <a class="media-left" href="javascript:"><img class="media-object img-radius" src="{{asset('resources/super-admin/images/user/avatar-1.jpg')}}" alt="Generic placeholder image">
                        <div class="live-status">1</div>
                    </a>
                    <div class="media-body">
                        <h6 class="chat-header">Lary Doe<small class="d-block text-c-green">online</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="3" data-status="online" data-username="Alice">
                    <a class="media-left" href="javascript:"><img class="media-object img-radius" src="{{asset('resources/super-admin/images/user/avatar-1.jpg')}}" alt="Generic placeholder image"></a>
                    <div class="media-body">
                        <h6 class="chat-header">Alice<small class="d-block text-c-green">online</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="4" data-status="offline" data-username="Alia">
                    <a class="media-left" href="javascript:"><img class="media-object img-radius" src="{{asset('resources/super-admin/images/user/avatar-1.jpg')}}" alt="Generic placeholder image">
                        <div class="live-status">1</div>
                    </a>
                    <div class="media-body">
                        <h6 class="chat-header">Alia<small class="d-block text-muted">10 min ago</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="5" data-status="offline" data-username="Suzen">
                    <a class="media-left" href="javascript:"><img class="media-object img-radius" src="{{asset('resources/super-admin/images/user/avatar-1.jpg')}}" alt="Generic placeholder image"></a>
                    <div class="media-body">
                        <h6 class="chat-header">Suzen<small class="d-block text-muted">15 min ago</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="1" data-status="online" data-username="Josephin Doe">
                    <a class="media-left" href="javascript:"><img class="media-object img-radius" src="{{asset('resources/super-admin/images/user/avatar-1.jpg')}}" alt="Generic placeholder image ">
                        <div class="live-status">3</div>
                    </a>
                    <div class="media-body">
                        <h6 class="chat-header">Josephin Doe<small class="d-block text-c-green">Typing . . </small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="2" data-status="online" data-username="Lary Doe">
                    <a class="media-left" href="javascript:"><img class="media-object img-radius" src="{{asset('resources/super-admin/images/user/avatar-1.jpg')}}" alt="Generic placeholder image">
                        <div class="live-status">1</div>
                    </a>
                    <div class="media-body">
                        <h6 class="chat-header">Lary Doe<small class="d-block text-c-green">online</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="3" data-status="online" data-username="Alice">
                    <a class="media-left" href="javascript:"><img class="media-object img-radius" src="{{asset('resources/super-admin/images/user/avatar-1.jpg')}}" alt="Generic placeholder image"></a>
                    <div class="media-body">
                        <h6 class="chat-header">Alice<small class="d-block text-c-green">online</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="4" data-status="offline" data-username="Alia">
                    <a class="media-left" href="javascript:"><img class="media-object img-radius" src="{{asset('resources/super-admin/images/user/avatar-1.jpg')}}" alt="Generic placeholder image">
                        <div class="live-status">1</div>
                    </a>
                    <div class="media-body">
                        <h6 class="chat-header">Alia<small class="d-block text-muted">10 min ago</small></h6>
                    </div>
                </div>
                <div class="media userlist-box" data-id="5" data-status="offline" data-username="Suzen">
                    <a class="media-left" href="javascript:"><img class="media-object img-radius" src="{{asset('resources/super-admin/images/user/avatar-1.jpg')}}" alt="Generic placeholder image"></a>
                    <div class="media-body">
                        <h6 class="chat-header">Suzen<small class="d-block text-muted">15 min ago</small></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- [ chat user list ] end -->

<!-- [ chat message ] start -->
<section class="header-chat">
    <div class="h-list-header">
        <h6>Josephin Doe</h6>
        <a href="javascript:" class="h-back-user-list"><i class="fa fa-chevron-left"></i></a>
    </div>
    <div class="h-list-body">
        <div class="main-chat-cont scroll-div">
            <div class="main-friend-chat">
                <div class="media chat-messages">
                    <a class="media-left photo-table" href="javascript:"><img class="media-object img-radius img-radius m-t-5" src="{{asset('resources/super-admin/images/user/avatar-1.jpg')}}" alt="Generic placeholder image"></a>
                    <div class="media-body chat-menu-content">
                        <div class="">
                            <p class="chat-cont">hello Datta! Will you tell me something</p>
                            <p class="chat-cont">about yourself?</p>
                        </div>
                        <p class="chat-time">8:20 a.m.</p>
                    </div>
                </div>
                <div class="media chat-messages">
                    <div class="media-body chat-menu-reply">
                        <div class="">
                            <p class="chat-cont">Ohh! very nice</p>
                        </div>
                        <p class="chat-time">8:22 a.m.</p>
                    </div>
                </div>
                <div class="media chat-messages">
                    <a class="media-left photo-table" href="javascript:"><img class="media-object img-radius img-radius m-t-5" src="{{asset('resources/super-admin/images/user/avatar-1.jpg')}}" alt="Generic placeholder image"></a>
                    <div class="media-body chat-menu-content">
                        <div class="">
                            <p class="chat-cont">can you help me?</p>
                        </div>
                        <p class="chat-time">8:20 a.m.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="h-list-footer">
        <div class="input-group">
            <input type="file" class="chat-attach" style="display:none">
            <a href="javascript:" class="input-group-prepend btn btn-success btn-attach">
                <i class="fa fa-paperclip"></i>
            </a>
            <input type="text" name="h-chat-text" class="form-control h-send-chat" placeholder="Write hear . . ">
            <button type="submit" class="input-group-append btn-send btn btn-primary">
                <i class="fa fa-message-circle"></i>
            </button>
        </div>
    </div>
</section>
<!-- [ chat message ] end -->
    @endif