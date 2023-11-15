<?php

namespace App\Http\Controllers\FrontEnd\Home;

use App\Http\Requests\FrontEnd\Subscribe\SubscribeRequest;
use App\Models\Model\SuperAdmin\Amenity\Amenity;
use App\Models\Model\SuperAdmin\Blog\Blog;
use App\Models\Model\SuperAdmin\Feature\Feature;
use App\Models\Model\SuperAdmin\Page\Page;
use App\Models\Model\SuperAdmin\Seo\Seo;
use Spatie\Searchable\Search;
use TreeHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
class HomeController extends Controller
{
    public function index()
    {
        $data['about'] = Page::where('slug','about-us')->first();

        $data['features'] = Feature::where('status','active')->orderBy('order','asc')->paginate(4);

        $data['services'] = Amenity::where('status','active')->orderBy('order','asc')->paginate(6);

        $data['blogs'] = Blog::latest()
            ->where('status', 'active')
            ->orderBy('order', 'asc')
            ->take(3)
            ->get();

        return view('front-end.home.index',$data);
    }

    public function subscriber(SubscribeRequest $request)
    {
        $subscriber=DB::table('subscribers')
            ->where('email', $request->get('email'))
            ->first();
        if(!$subscriber){
            DB::table('subscribers')->insert(
                ['email' => $request->get('email')]
            );
            return 1;
        }
        return back();
    }
    public function search()
    {
        $data['key']=$key=Input::get('search');
        $data['searchResults'] = (new Search())
            ->registerModel(Trip::class, 'title')
            ->registerModel(TripCategory::class, 'title')
            ->registerModel(Page::class, 'title','content')
            ->registerModel(Blog::class, 'title','content')
            ->search($key);
        $data['model'] = Seo::where('slug', 'search')->first();
        if($data['model']) {
            $data['meta_title'] = $data['model']->seo_title ? $data['model']->seo_title : $data['model']->title;
            $data['meta_keywords'] = $data['model']->seo_keywords;
            $data['meta_description'] = $data['model']->seo_description;
        }
        return view('front-end.search.index',$data);
    }

    public function HomeSearch(){
        $destination=Input::get('destination');
        $type=Input::get('type');
        $region=Input::get('region');
        $grade=Input::get('grade');
        $budget=Input::get('budget');
        $season=Input::get('season');
        $accommodation=Input::get('accommodation');
        $db=DB::table('trips');

        //destination
        $destId=(TreeHelper::getValueBySlug('destinations', $destination)->id);
        $trips=$db->WhereRaw('FIND_IN_SET('.$destId.',destination)')->orderBy('order','asc');

        //type
        if(!empty($type)){
            $catId=(TreeHelper::getValueBySlug('trip_categories', $type)->id);
            $trips=$db->WhereRaw('FIND_IN_SET('.$catId.',category)')->orderBy('order','asc');
        }

        //region
        if(!empty($region)){
            $regionId = (TreeHelper::getValueBySlug('trip_categories', $region)->id);
            $trips=$db->WhereRaw('FIND_IN_SET('.$regionId.',category)')->orderBy('order','asc');
        }
        //grade
        if(!empty($grade)){
            $trips = $db->where('trip_grade',$grade);
        }
        //season
        if(!empty($season)){
            $trips = $db->where('season', 'LIKE', "%$season%");
        }
        //budget
        if(!empty($budget)){
            if ($budget == '2000+') {
                $trips = $db->where('price', '>', 2000);
            }elseif($budget == '1000-'){
                $trips = $db->where('price', '<', 1000);
            } else {
                $bud = implode('' ,$budget);
                // dd($bud);
                $budgetExplode = explode('-', $bud);
                // dd($budgetExplode);
                $trips = $db->whereBetween('price', [$budgetExplode[0], $budgetExplode[1]]);
            }
        }
        //accommodation
        if(!empty($accommodation)){
            $trips = $db->where('accommodation',$accommodation);
        }
        $trips=$trips->get();
        $model = Seo::where('slug', 'search')->first();
        return view('front-end.trip.trip-search',compact('trips', 'model'));
    }
}
