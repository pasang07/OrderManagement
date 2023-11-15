<?php
if (!Request::ajax()) {
    $type = Illuminate\Support\Facades\Request::old('type')? Illuminate\Support\Facades\Request::old('type'): $nav->type;;
}
?>
@if ($type=='pages')
    <label>Select Content</label>
    <select class="form-control" id="type_id" name="type_id" onchange="changeType(this.value)">
        @foreach(App\Models\Model\SuperAdmin\Page\Page::all() as $page)
            <option value="{{$page->id}}" {{ old('type_id', isset($nav->type_id) ? $nav->type_id : '')==$page->id?'selected="selected"':''}}>{{$page->title}}</option>
        @endforeach
    </select>
    <span class="text-danger">{{ $errors->first('type_id') }}</span>
@elseif ($type=='amenities')
    <label>Select Service</label>
    <select class="form-control" id="type_id" name="type_id" onchange="changeType(this.value)">
        @foreach(App\Models\Model\SuperAdmin\Amenity\Amenity::all() as $amenity)
            <option value="{{$amenity->id}}" {{ old('type_id', isset($nav->type_id) ? $nav->type_id : '')==$amenity->id?'selected="selected"':''}}>{{$amenity->title}}</option>
        @endforeach
    </select>
    <span class="text-danger">{{ $errors->first('type_id') }}</span>

@elseif ($type=='software')
    <label>Select Software</label>
    <select class="form-control" id="type_id" name="type_id" onchange="changeType(this.value)">
        @foreach(App\Models\Model\SuperAdmin\Software\Software::all() as $software)
            <option value="{{$software->id}}" {{ old('type_id', isset($nav->type_id) ? $nav->type_id : '')==$software->id?'selected="selected"':''}}>{{$software->title}}</option>
        @endforeach
    </select>
    <span class="text-danger">{{ $errors->first('type_id') }}</span>



@elseif ($type=='route')
    <label>Select Route</label>
        <select class="form-control" id="url" name="url" onchange="changeType(this.value)">
            <option value="/" {{ old('url', isset($nav->url) ? $nav->url : '')=="/"?'selected="selected"':''}}>Home</option>
            <option value="blogs" {{ old('url', isset($nav->url) ? $nav->url : '')=="blogs"?'selected="selected"':''}}>Blogs</option>
            <option value="news-notices" {{ old('url', isset($nav->url) ? $nav->url : '')=="news-notices"?'selected="selected"':''}}>News & Notices</option>
            <option value="services" {{ old('url', isset($nav->url) ? $nav->url : '')=="services"?'selected="selected"':''}}>Services</option>
            {{--<option value="albums" {{ old('url', isset($nav->url) ? $nav->url : '')=="albums"?'selected="selected"':''}}>Gallery</option>--}}
            <option value="contact-us" {{ old('url', isset($nav->url) ? $nav->url : '')=="contact-us"?'selected="selected"':''}}>Contact Us</option>
        </select>
    </select>

    <span class="text-danger">{{ $errors->first('url') }}</span>

@elseif ($type=='link')

@elseif ($type=='none')
    <input type="hidden" class="custom-file-input" id="url" name="url" value="#">
@endif
