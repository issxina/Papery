<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function __construct()
    {
        // ใช้ middleware 'auth:admin' เพื่อบังคับให้ต้องล็อกอินในฐานะ admin ก่อนใช้งาน controller นี้
        // ถ้าไม่ล็อกอินหรือไม่ได้ใช้ guard 'admin' จะถูก redirect ไปหน้า login
        $this->middleware('auth:admin');
    }
    
    public function index()
    {
        // จำนวนรวม
        $orderCount = DB::table('tbl_orders')->count();
        $userCount = DB::table('tbl_users')->count();
        $bookCount = DB::table('tbl_books')->count();
        $categoryCount = DB::table('tbl_categories')->count();

        // 5 ออเดอร์ล่าสุด
        $recentOrders = DB::table('tbl_orders')
            ->join('tbl_users', 'tbl_orders.user_id', '=', 'tbl_users.id')
            ->select('tbl_orders.*', 'tbl_users.user_name')
            ->orderByDesc('tbl_orders.order_date')
            ->limit(5)
            ->get();

        // Top 5 หนังสือขายดี
        $bestSellingBooks = DB::table('tbl_order_details')
            ->join('tbl_books', 'tbl_order_details.book_id', '=', 'tbl_books.id')
            ->select('tbl_books.book_title', DB::raw('SUM(tbl_order_details.orderdetails_qty) as total_sold'))
            ->groupBy('tbl_books.book_title')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // ยอดขายรายเดือน (12 เดือนล่าสุด)
        $sales = DB::table('tbl_orders')
            ->select(
                DB::raw("DATE_FORMAT(order_date, '%Y-%m') as month"),
                DB::raw("SUM(order_amount) as total")
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $salesLabels = $sales->pluck('month');
        $salesData = $sales->pluck('total');

        // จำนวนหนังสือตามหมวดหมู่
        $categoryDataRaw = DB::table('tbl_categories')
            ->leftJoin('tbl_books', 'tbl_categories.id', '=', 'tbl_books.category_id')
            ->select('tbl_categories.category_name', DB::raw('COUNT(tbl_books.id) as total_books'))
            ->groupBy('tbl_categories.category_name')
            ->get();

        $categoryLabels = $categoryDataRaw->pluck('category_name');
        $categoryData = $categoryDataRaw->pluck('total_books');

        return view('dashboard.index', compact(
            'orderCount',
            'userCount',
            'bookCount',
            'categoryCount',
            'recentOrders',
            'bestSellingBooks',
            'salesLabels',
            'salesData',
            'categoryLabels',
            'categoryData'
        ));
    }
}
