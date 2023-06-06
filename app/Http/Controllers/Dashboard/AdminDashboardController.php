<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Management\Ledger;
use App\Models\Management\Budget;
use App\Models\Management\Account;
use App\Models\Management\category;
use DateTime;


class AdminDashboardController extends Controller
{
    public function index(){
        $ledgers =Ledger::with('user','category','account')->latest()->limit(6)->get();
       // $active_user =User::has('accounts')->count();
        $users       =User::withCount('accounts')->get();
       // return $users;
        $data =[
            'user'           =>User::count(),
            'active_user'    =>$users->where('accounts_count','>',0)->count(),
            'inactive_user'  =>$users->where('accounts_count',0)->count(),
            'transactions'    =>Ledger::cursor(),
            'accounts'        =>Account::whereyear('created_at',date('Y'))->cursor(),
            'categories'      =>Category::withSum('budgets','amount')->cursor(),
            'budgets'         =>Budget::whereYear('created_at',date('Y'))->cursor(),
        ];
  
        return view('dashboards.admin_dashboard',compact('data','ledgers'));
    }


    public function columChart(){
        return response()->json([
            'users'         =>$this->users(),
            'transactions'  =>$this->transactions(),
            'budgets'  =>$this->budgets(),
        ],200);
    }   

    public function users() {

        $monthly_sales = User::
         whereYear( 'created_at', date( 'Y' ) )
        ->selectRaw( 'COUNT(id) as count, YEAR(created_at) year,MONTH(created_at) month ' )
        ->groupBy( 'year', 'month' )
        ->get( array( 'month', 'count' ));

        $sales_array = array();
        foreach ( $monthly_sales as $sales ) {

            //$months = array( 1, 2, 3, 4, 5, 6 )
            $dateObj   = DateTime::createFromFormat( '!m', $sales->month );
            $monthName = substr( $dateObj->format( 'F' ), 0, 3 );
            $sale_ = $sales->count;

            $sales_array[$monthName] = $sales->count;

        }

        $month_array = array();
        for ( $i = 1; $i <= 12; $i++ ) {

            $dateObj   = DateTime::createFromFormat( '!m', $i );
            $monthName = substr( $dateObj->format( 'F' ), 0, 3 );

            if ( array_key_exists( $monthName, $sales_array ) ) {
                $month_array[] = $sales_array[$monthName];
            } else {
                $month_array[] = 0;
            }

        }
       // return implode( ',', $month_array );

        return json_encode($month_array);

    }

    public function transactions(){

        $monthly_sales = Ledger::
        whereYear( 'created_at', date( 'Y' ) )
        ->selectRaw( 'COUNT(id) as count, YEAR(created_at) year,MONTH(created_at) month ')
        ->groupBy( 'year', 'month' )
        ->get( array( 'month', 'count' ));

        $sales_array = array();
        foreach ( $monthly_sales as $sales ) {

            //$months = array( 1, 2, 3, 4, 5, 6 )
            $dateObj   = DateTime::createFromFormat( '!m', $sales->month );
            $monthName = substr( $dateObj->format( 'F' ), 0, 3 );
            $sale_ = $sales->count;

            $sales_array[$monthName] = $sales->count;

        }

        $month_array = array();
        for ( $i = 1; $i <= 12; $i++ ) {

            $dateObj   = DateTime::createFromFormat( '!m', $i );
            $monthName = substr( $dateObj->format( 'F' ), 0, 3 );

            if ( array_key_exists( $monthName, $sales_array ) ) {
                $month_array[] = $sales_array[$monthName];
            } else {
                $month_array[] = 0;
            }

        }
       // return implode( ',', $month_array );

        return json_encode($month_array);
    }

    public function budgets(){

        $monthly_sales = Budget::
        whereYear( 'created_at', date( 'Y' ) )
        ->selectRaw( 'COUNT(id) as count, YEAR(created_at) year,MONTH(created_at) month ')
        ->groupBy( 'year', 'month' )
        ->get( array( 'month', 'count' ));

        $sales_array = array();
        foreach ( $monthly_sales as $sales ) {

            //$months = array( 1, 2, 3, 4, 5, 6 )
            $dateObj   = DateTime::createFromFormat( '!m', $sales->month );
            $monthName = substr( $dateObj->format( 'F' ), 0, 3 );
            $sale_ = $sales->count;

            $sales_array[$monthName] = $sales->count;

        }

        $month_array = array();
        for ( $i = 1; $i <= 12; $i++ ) {

            $dateObj   = DateTime::createFromFormat( '!m', $i );
            $monthName = substr( $dateObj->format( 'F' ), 0, 3 );

            if ( array_key_exists( $monthName, $sales_array ) ) {
                $month_array[] = $sales_array[$monthName];
            } else {
                $month_array[] = 0;
            }

        }
       // return implode( ',', $month_array );

        return json_encode($month_array);
    }
}
