<?php
if (!Request::ajax()) {
    $type = Illuminate\Support\Facades\Request::old('type');
}
?>
@if ($type=='pages')
<label>Select Content</label>
<select class="form-control" id="type_id" name="type_id" onchange="changeType(this.value)">
        @foreach(App\Models\Model\SuperAdmin\Page\Page::all() as $page)
            <option value="{{$page->id}}">{{$page->title}}</option>
        @endforeach
</select>
<span class="text-danger">{{ $errors->first('type_id') }}</span>

@elseif ($type=='amenities')
<label>Select Service</label>
<select class="form-control" id="type_id" name="type_id" onchange="changeType(this.value)">
@foreach(App\Models\Model\SuperAdmin\Amenity\Amenity::all() as $amenity)
<option value="{{$amenity->id}}">{{$amenity->title}}</option>
@endforeach
</select>
<span class="text-danger">{{ $errors->first('type_id') }}</span>
@elseif ($type=='software')
<label>Select Software</label>
<select class="form-control" id="type_id" name="type_id" onchange="changeType(this.value)">
@foreach(App\Models\Model\SuperAdmin\Software\Software::all() as $software)
<option value="{{$software->id}}">{{$software->title}}</option>
@endforeach
</select>
<span class="text-danger">{{ $errors->first('type_id') }}</span>

@elseif ($type=='route')
    <label>Select Route</label>
    <select class="form-control" id="url" name="url" onchange="changeType(this.value)">
        <option value="/">Home</option>
        <option value="blogs">Blog</option>
        <option value="news-notices">News & Notices</option>
        <option value="services">Services</option>
        {{--<option value="albums">Gallery</option>--}}
        <option value="contact-us">Contact Us</option>
    </select>
    <span class="text-danger">{{ $errors->first('url') }}</span>

@elseif ($type=='link')

@elseif ($type=='none')
    <input type="hidden" class="custom-file-input" id="url" name="url" value="#">
@endif
