<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use App\Models\Model\SuperAdmin\Menu\Nav;
class TreeHelper{

    public static $level = 0;
    private static $option_array = array();
    private static $id_array = array();
    public static $result = null;
    public static $results = null;
    public static $resultActivity = null;
    public static function selectOptions($table, $base_id, $id = null, $terms = NULL, $order_by = NULL, $order = NULL) {
        if (!$terms)
            $terms = '1=1';
        if ($id) {
            $models = DB::table($table)
                ->where('id', '!=', $id)
                ->where('parent_id', $base_id)
                ->whereRaw($terms)
                ->orderBy($order_by, $order)
                ->get(array('id', 'parent_id', 'title'));
        } else {

            $models = DB::table($table)
                ->where('parent_id', $base_id)
                ->whereRaw($terms)
                ->orderBy($order_by, $order)
                ->get(array('id', 'parent_id', 'title'));
        }
        if (sizeof($models) > 0) {
            foreach ($models as $m) {
                $title_prefix = TreeHelper::getTitlePrefix(self::$level);
                self::$option_array[$m->id] = $title_prefix . $m->title;
                $childs = DB::table($table)
                    ->where('parent_id', $m->id)
                    ->whereRaw($terms)
                    ->orderBy($order_by, $order)
                    ->get(array('id', 'parent_id', 'title'));

                if (sizeof($childs) > 0) {
                    self::$level++;
                    TreeHelper::selectOptions($table, $m->id, $id, $terms, $order_by, $order);
                    self::$level--;
                }
            }
            return self::$option_array;
        } else {
            return array();
        }
    }
    public static function checkbox($name, $checkeds, $table, $base_id = NULL, $terms = NULL, $order_by = NULL, $order = NULL, $class='parent') {
//        dd($checkeds);
        if (!$terms)
            $terms = '1=1';
        $models = DB::table($table)
            ->where('parent_id', $base_id)
            ->whereRaw($terms)
            ->orderBy($order_by, $order)
            ->get();

        if (sizeof($models) > 0) {
            self::$result .= '<ul>';
            foreach ($models as $m) {

                $childs = DB::table($table)
                    ->where('parent_id', $m->id)
                    ->whereRaw($terms)
                    ->orderBy($order_by, $order)
                    ->get(array('id'));
                $checked =in_array($m->id, $checkeds) ? 'checked' : '';
                self::$result .= "<li>";
                if (sizeof($childs) > 0) {
                    self::$result .= '<input type="checkbox" name="'.$name.'" value="'.$m->id.'" class="custom-control-input '.$class.'" id="'.$m->slug.'" '.$checked.'>
                                        <label class="custom-control-label" for="'.$m->slug.'">'.$m->title.'</label>';
                    TreeHelper::checkbox($name, $checkeds, $table, $m->id, $terms, $order_by, $order,'child');
                } else {
                    self::$result .= '<input type="checkbox" name="'.$name.'" value="'.$m->id.'" class="custom-control-input '.$class.'" id="'.$m->slug.'" '.$checked.'>
                                        <label class="custom-control-label" for="'.$m->slug.'">'.$m->title.'</label>';
                }
                self::$result .= '</li>';
            }
            self::$result .= '</ul>';
        }
        return self::$result;
    }
    public static function checkboxCat($name, $checkeds, $table, $base_id = NULL, $terms = NULL, $order_by = NULL, $order = NULL) {
//        dd($checkeds);
        if (!$terms)
            $terms = '1=1';
        $models = DB::table($table)
            ->where('parent_id', $base_id)
            ->whereRaw($terms)
            ->orderBy($order_by, $order)
            ->get();

        if (sizeof($models) > 0) {
            self::$results .= '<ul>';
            foreach ($models as $m) {

                $childs = DB::table($table)
                    ->where('parent_id', $m->id)
                    ->whereRaw($terms)
                    ->orderBy($order_by, $order)
                    ->get(array('id'));
                $checked =in_array($m->id, $checkeds) ? 'checked' : '';
                self::$results .= "<li>";
                if (sizeof($childs) > 0) {
                    self::$results .= '<input type="checkbox" name="'.$name.'" value="'.$m->id.'" class="custom-control-input" id="'.$m->slug.'" '.$checked.'>
                                        <label class="custom-control-label" for="'.$m->slug.'">'.$m->title.'</label>';
                    TreeHelper::checkboxCat($name, $checkeds, $table, $m->id, $terms, $order_by, $order);
                } else {
                    self::$results .= '<input type="checkbox" name="'.$name.'" value="'.$m->id.'" class="custom-control-input" id="'.$m->slug.'" '.$checked.'>
                                        <label class="custom-control-label" for="'.$m->slug.'">'.$m->title.'</label>';
                }
                self::$results .= '</li>';
            }
            self::$results .= '</ul>';
        }
        return self::$results;
    }

    public static function checkboxMenu($name, $checkeds, $table, $base_id = NULL, $terms = NULL, $order_by = NULL, $order = NULL) {
//        dd($checkeds);
        if (!$terms)
            $terms = '1=1';
        $models = DB::table($table)
            ->where('parent_id', $base_id)
            ->whereRaw($terms)
            ->orderBy($order_by, $order)
            ->get();

        if (sizeof($models) > 0) {
            self::$results .= '<ul>';
            foreach ($models as $m) {

                $childs = DB::table($table)
                    ->where('parent_id', $m->id)
                    ->whereRaw($terms)
                    ->orderBy($order_by, $order)
                    ->get(array('id'));
                $checked =in_array($m->id, $checkeds) ? 'checked' : '';
                self::$results .= "<li>";
                if (sizeof($childs) > 0) {
                    if($m->parent_id == 0){
                        self::$results .= '<label>'.$m->title.'</label>';
                    }
                    else{
                        self::$results .= '<input type="checkbox" name="'.$name.'" value="'.$m->id.'" class="custom-control-input" id="'.$m->slug.'" '.$checked.'>
                                        <label class="custom-control-label" for="'.$m->slug.'">'.$m->title.'</label>';

                    }TreeHelper::checkboxCat($name, $checkeds, $table, $m->id, $terms, $order_by, $order);
                } else {
                    self::$results .= '<input type="checkbox" name="'.$name.'" value="'.$m->id.'" class="custom-control-input" id="'.$m->slug.'" '.$checked.'>
                                        <label class="custom-control-label" for="'.$m->slug.'">'.$m->title.'</label>';
                }
                self::$results .= '</li>';
            }
            self::$results .= '</ul>';
        }
        return self::$results;
    }
    public static function checkboxTrip($name, $checkeds, $table, $terms = NULL, $order_by = NULL, $order = NULL) {
        if (!$terms)
            $terms = '1=1';
        $models = DB::table($table)
            ->whereRaw($terms)
            ->orderBy($order_by, $order)
            ->get();

        if (sizeof($models) > 0) {
            self::$results .= '<ul>';
            foreach ($models as $m) {
                $checked =in_array($m->id, $checkeds) ? 'checked' : '';
                self::$results .= "<li>";
                    self::$results .= '<input type="checkbox" name="'.$name.'" value="'.$m->id.'" class="custom-control-input" id="'.$m->slug.'" '.$checked.'>
                                        <label class="custom-control-label" for="'.$m->slug.'">'.$m->title.'</label>';
                self::$results .= '</li>';
            }
            self::$results .= '</ul>';
        }
        return self::$results;
    }
    public static function checkboxActivity($name, $checkeds, $table, $base_id = NULL, $terms = NULL, $order_by = NULL, $order = NULL) {
//        dd($checkeds);
        if (!$terms)
            $terms = '1=1';
        $models = DB::table($table)
            ->whereRaw($terms)
            ->orderBy($order_by, $order)
            ->get();

        if (sizeof($models) > 0) {
            self::$resultActivity .= '<ul>';
            foreach ($models as $m) {
                $checked =in_array($m->id, $checkeds) ? 'checked' : '';
                self::$resultActivity .= "<li>";
                    self::$resultActivity .= '<input type="checkbox" name="'.$name.'" value="'.$m->id.'" class="custom-control-input" id="'.$m->slug.'" '.$checked.'>
                                        <label class="custom-control-label" for="'.$m->slug.'">'.$m->title.'</label>';
                self::$resultActivity .= '</li>';
            }
            self::$resultActivity .= '</ul>';
        }
        return self::$resultActivity;
    }
    public static function getCheckboxValue($table,$id){
        $details = DB::table($table)
            ->where('id', $id)
            ->first();
        return $details;
    }
     public static function getValueBySlug($table,$slug){
        $details = DB::table($table)
            ->where('slug', $slug)
            ->first();
        return $details;

    }
    public static function getTitlePrefix($level) {
        $prefix = null;
        for ($i = 0; $i <= $level; $i++) {
            $prefix .= ' - - - ';
        }
        return $prefix;
    }
    public static function banner_count(){
        $total = DB::table('trips')->count();
        return $total;
    }
    public static function unread_contact_count(){
        $total = DB::table('contacts')->where('is_read', 'no')->count();
        return $total;
    }
    public static function unread_to_be_confirmed_count($id){
        $total = DB::table('order_lists')->where('customer_id', $id)
            ->where('is_confirmed_read', 'no')
            ->where('is_reviewed', 'yes')
            ->count();
        return $total;
    }
    public static function siteSetting(){
        $siteSettings = DB::table('site_settings')
            ->where('id', 1)
            ->first();
        return $siteSettings;
    }
    public static function getParent($table,$parent_id){
        $parent = DB::table($table)
            ->where('id', $parent_id)
            ->first();
        return $parent;
    }
    public static function getTableDetails($table, $id){
        $details = DB::table($table)
            ->where('id', $id)
            ->first();
        return $details;
    }


//   Front-end menus//
//   Mega Menu
    public static function megaMenu($base_id, $id = NULL, $class = NULL, $current_class = NULL) {

        $models = Nav::where('parent_id', $base_id)
            ->where('status', 'active')
            ->orderBy('order', 'asc')
            ->get();

        if (sizeof($models) > 0) {
            if (self::$level == 0) {
                self::$result .= '<ul>';
            }
            self::$level++;
            foreach ($models as $m) {
                $childs = Nav::where('parent_id', $m->id)
                    ->where('status', 'active')
                    ->orderBy('order', 'asc')
                    ->get();
                if (sizeof($childs) > 0){
                    self::$result .= '<li>';
                    self::$result .= '<a href="' . URL::to($m->url) . '">'.$m->title.'</a>';
                    self::$result.='<ul class="submenu">';
                    foreach ($childs as $ch){
                        $child = Nav::where('parent_id', $ch->id)
                            ->where('status', 'active')
                            ->orderBy('order', 'asc')
                            ->get(array('id'));
                        if(sizeof($child)>0){
                            self::$result .='<li>';
                            if($ch->type == 'none') {
                                self::$result .= ' <a href="javascript:void(0)">'.$ch->title.'</a>';
                            }else{
                                self::$result .= '<a href="' . URL::to($ch->url) . '"  target="' . $ch->target . '"> ' . $ch->title . '</a>';
                            }
                            TreeHelper::innerMenu2($ch->id,$id,"sub-menu");
                        }else{
                            self::$result .='<li>';
                            if($ch->type == 'none') {
                                self::$result .= ' <a href="javascript:void(0)">'.$ch->title.'</a>';
                            }else{
                                self::$result .= '<a href="' . URL::to($ch->url) . '" target="' . $ch->target . '"> ' . $ch->title . '</a>';
                            }
                        }
                        self::$result .= '</li>';
                    }
                    self::$result.=' </ul>';

                    self::$result .= '</li>';
                }else {
                    self::$result .= $m->url == Request::path() ?  '<li class="active"> ' : '<li>';
                    self::$result .= '<a href="' . URL::to($m->url) . '" target="' . $m->target . '"> ' . $m->title . '</a>';
                    self::$result .= '</li>';
                }
            }
            self::$result .= '</ul>';
        }
        return self::$result;
    }

    public static  function innerMenu2($base_id, $id = NULL, $class = NULL, $current_class = NULL){
        $models =Nav::where('parent_id', $base_id)
            ->where('status', 'active')
            ->orderBy('order', 'asc')
            ->get();
        if (sizeof($models) > 0) {
            self::$result .= '<div  class="' . $class . '"><ul>';
            self::$level++;
            foreach ($models as $m) {
                $childs = Nav::where('parent_id', $m->id)
                    ->where('status', 'active')
                    ->orderBy('order', 'asc')
                    ->get(array('id'));
//                if (sizeof($childs) > 0) {
//                    self::$result .= $m->url == Request::path() ? '<li class="dropdown-submenu pd-18">' : '<li class="dropdown-submenu">';
//                    if ($m->type == 'none')
//                        self::$result .= '<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">' . $m->title . '</a>';
//                    else {
//                        self::$result .= '<a href="' . URL::to($m->url) . '" class="dropdown-toggle" data-toggle="dropdown">' . $m->title . '</a>';
//                    }
//                    TreeHelper::innerMenu2($m->id, $id, $class, $current_class);
//                } else {
//                    self::$result .= $m->url == Request::path() ? '<li>' : '<li>';
//                    if ($m->type == 'none')
//                        self::$result .= '<a href="javascript:void(0);">' . $m->title . '</a>';
//                    else {
//                        self::$result .= '<a href="' . URL::to($m->url) . '">' . $m->title . '</a>';
//                    }
//                }
                self::$result .= $m->url == Request::path() ? '<li>' : '<li>';
                if ($m->type == 'none')
                    self::$result .= '<a href="javascript:void(0);">' . $m->title . '</a>';
                else {
                    self::$result .= '<a href="' . URL::to($m->url) . '" target="' . $m->target . '">' . $m->title . '</a>';
                }
                self::$result .= '</li>';
            }
            self::$result .= '</ul></div>';
        }
        return self::$result;
    }

//  Menu
    public static function oneLineMenu($base_id, $id = NULL, $class = NULL, $current_class = NULL) {

        $models = Nav::where('parent_id', $base_id)
            ->where('status', 'active')
            ->orderBy('order', 'asc')
            ->get();

        if (sizeof($models) > 0) {
            if (self::$level == 0) {
                self::$result .= '<ul class="wsmenu-list">';
            }
            self::$level++;
            foreach ($models as $m) {
                $childs = Nav::where('parent_id', $m->id)
                    ->where('status', 'active')
                    ->orderBy('order', 'asc')
                    ->get();
//                if (sizeof($childs) > 0){
//                    self::$result .= '<li class="dropdown_li">';
//                    self::$result .= '<a href="' . URL::to($m->url) . '"><span>'.$m->title.'</span></a>';
//                    self::$result.='<div class="dropdown-menu"><ul>';
//                    foreach ($childs as $ch){
//                        $child = Nav::where('parent_id', $ch->id)
//                            ->where('status', 'active')
//                            ->orderBy('order', 'asc')
//                            ->get(array('id'));
//                        if(sizeof($child)>0){
//                            self::$result .='<li class="dropdown_li">';
//                            if($ch->type == 'none') {
//                                self::$result .= ' <a href="' . URL::to($ch->url) . '">'.$ch->title.'</a>';
//                            }else{
//                                self::$result .= '<a href="' . URL::to($ch->url) . '" > ' . $ch->title . '</a>';
//                            }
//                            TreeHelper::innerMenu2($ch->id,$id,"submenu");
//                        }else{
//                            self::$result .='<li>';
//                            if($ch->type == 'none') {
//                                self::$result .= ' <a href="' . URL::to($ch->url) . '">'.$ch->title.'</a>';
//                            }else{
//                                self::$result .= '<a href="' . URL::to($ch->url) . '"> ' . $ch->title . '</a>';
//                            }
//                        }
//                        self::$result .= '</li>';
//                    }
//                    self::$result.=' </ul></div>';
//
//                    self::$result .= '</li>';
//                }else {
//                    self::$result .= '<li>';
//                    self::$result .= $m->url == Request::path() ?  '<a href="' . URL::to($m->url) . '" class="active"> ' . $m->title . '</a>' : '<a href="' . URL::to($m->url) . '"> ' . $m->title . '</a>';
//                    self::$result .= '</li>';
//                }

                self::$result .= '<li class="nl-simple" aria-haspopup="true">';
                self::$result .= $m->url == Request::path() ?  '<a href="' . URL::to($m->url) . '" class="active"> ' . $m->title . '</a>' : '<a href="' . URL::to($m->url) . '"> ' . $m->title . '</a>';
                self::$result .= '</li>';
            }
            self::$result .= '</ul>';
        }
        return self::$result;
    }

    //    quicklink menu
    public static function quickLinkMenu($base_id, $id = NULL, $class = NULL, $current_class = NULL,$aTagClass= Null,$iconClass=Null) {
        $models =Nav::where('parent_id', $base_id)
            ->where('status', 'active')
            ->orderBy('order', 'asc')
            ->get();

        if (sizeof($models) > 0) {
            if (self::$level == 0) {
                if ($id)
                    self::$result .= '<ul class="' . $class . '" id="' . $id . '" >';
                else
                    self::$result .= '<ul class="' . $class . '" >';
            } else
                self::$result .= '<ul class="' . $class . '">';
            self::$level++;
            foreach ($models as $m) {
                self::$result .= $m->url == Request::path() ? '<li class="' . $current_class . '">' : '<li class="' . $current_class . '">';
                if ($m->type == 'none')
                    self::$result .= '<a href="javascript:void(0);">' . $m->title . '</a>';
                else {
                    self::$result .= '<a href="' . URL::to($m->url) . '" target="' . $m->target . '" >' . $m->title . '</a>';
                }
                self::$result .= '</li>';
            }
            self::$result .= '</ul>';
        }
        return self::$result;
    }


//   Mega Menu
    public static function serviceMenu($base_id, $id = NULL, $class = NULL, $current_class = NULL) {

        $models = Nav::where('parent_id', $base_id)
            ->where('status', 'active')
            ->orderBy('order', 'asc')
            ->get();

        if (sizeof($models) > 0) {
            if (self::$level == 0) {
                self::$result .= '<ul>';
            }
            self::$level++;
            foreach ($models as $m) {
                $childs = Nav::where('parent_id', $m->id)
                    ->where('status', 'active')
                    ->orderBy('order', 'asc')
                    ->get();

                    self::$result .= '<li>';
                    self::$result .= $m->url == Request::path() ?  '<li class="current"> ' : '<li>';
                    self::$result .= '<a href="' . URL::to($m->url) . '" target="' . $m->target . '"> ' . $m->title . '</a>';
                    self::$result .= '</li>';

            }
            self::$result .= '</ul>';
        }
        return self::$result;
    }
    public static function getDetails($table){
        $destinations = DB::table($table)
            ->where('parent_id', 0)
            ->get();
        return $destinations;
    }
    public static function getPartner(){
        $partners = DB::table('partners')
            ->where('status', 'active')
            ->orderBy('order','asc')
            ->get();
        return $partners;
    }
    public static function calculateRating($id)
    {
        $total=DB::table('ratings')
            ->where('trip_id', $id)
            ->get()->count();
        $rate = DB::table('ratings')
            ->where('trip_id', $id)
            ->sum('rate');
        if($total!=0 && $rate!=0){
            return $rate/$total;
        }
        return 3.5;
    }
    public static function calculateReview($id)
    {
        $totalReview=DB::table('ratings')
            ->where('trip_id', $id)
            ->get()->count();
        if($totalReview == 0){
            return 'No';

        }
        return $totalReview;
    }
    public static function getIndividualReview($id)
    {
        $total=DB::table('ratings')
            ->where('id', $id)
            ->first();
            return $total->rate;
    }
    public static function getBlogCategory($id){
        $category = DB::table('blog_categories')
            ->where('id', $id)
            ->first();
        return $category;
    }
    public static function request_customer_count(){
        $referCustomerTotal = DB::table('refer_customers')->where('is_approve', 'no')->get()->count();
        return $referCustomerTotal;
    }
}
?>