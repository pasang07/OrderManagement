<form method="get" action="{{route('home-search')}}/?search" data-parsley-validate novalidate>
    <div class="fields">
        <div class="field">
            <div class="label">Destination</div>
            <div class="field_wrap select_field">
                <select name="destination"  id="multiDestination" onchange="getType()" required>
                    <option value="">Your Destination</option>
                    @foreach($destinations as $destination)
                        <option value="{{$destination->slug}}" {{ old('destination')}}>{{$destination->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="field">
            <div class="label">Activities</div>
            <div class="field_wrap select_field">
                <select name="type" id="type_select" onchange="getRegion()" >
                    <option value="">Select</option>
                </select>
            </div>
        </div>
        <div class="field">
            <div class="label">Region</div>
            <div class="field_wrap select_field">
                <select id="regionName" name="region">
                    <option value="">Select</option>
                </select>
            </div>
        </div>
        <div class="field">
            <div class="label">Difficulty</div>
            <div class="field_wrap select_field">
                <select  name="grade" class="niceSelect">
                    <option value="">Physical Rating</option>
                    <option value="Comfort">Easy/ Comfort</option>
                    <option value="Moderate">Moderate</option>
                    <option value="Difficult">Difficult</option>
                    <option value="Strenuous">Strenuous/Hard</option>
                </select>
            </div>
        </div>
        <div class="field">
            <div class="label">Season</div>
            <div class="field_wrap select_field">
                <select name="season" class="niceSelect">
                    <option value="">Season</option>
                    <option value="spring">Spring</option>
                    <option value="summer">Summer</option>
                    <option value="autumn">Autumn</option>
                    <option value="winter">Winter</option>
                </select>
            </div>
        </div>
    </div>
    <button class="submit"></button>
</form>