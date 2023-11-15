<?php
namespace App\Helpers;
use Illuminate\Support\Facades\DB;
class DbHelper{
    public static function nextSortOrder($table) {
        return DB::table($table)->max('order') + 1;
    }
    public static function fileName($file) {
        $explode = explode(".", stripslashes($file));
        return $explode[sizeof($explode) - 2];
    }
    public static function popularTrekkingNextSortOrder($table) {
        return DB::table($table)->max('popular_order') + 1;
    }
    public static function fixedNextSortOrder($table) {
        return DB::table($table)->max('fixed_order') + 1;
    }
    public static function hotNextSortOrder($table) {
        return DB::table($table)->max('hot_order') + 1;
    }
    public static function bestNextSortOrder($table) {
        return DB::table($table)->max('best_order') + 1;
    }
}

