<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Pagination\Paginator;
use App\Models\BookModel;
use App\Models\OrderModel;
use App\Models\CategoryModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function index()
    {
        Paginator::useBootstrap(); // ใช้ Bootstrap pagination
        $book = BookModel::orderBy('id', 'asc')->paginate(8); //order by & pagination
        $promotions   = BookModel::where('book_price', '>=', 300)->take(4)->get();
        $bestsellers = BookModel::select(
            'tbl_books.id',
            'tbl_books.book_title',
            'tbl_books.book_author',
            'tbl_books.book_price',
            'tbl_books.book_img',
            DB::raw('SUM(tbl_order_details.orderdetails_qty) as total_sold')
        )
            ->join('tbl_order_details', 'tbl_books.id', '=', 'tbl_order_details.book_id')
            ->groupBy('tbl_books.id', 'tbl_books.book_title', 'tbl_books.book_author', 'tbl_books.book_price', 'tbl_books.book_img')
            ->orderByDesc('total_sold')
            ->take(4)
            ->get();

        $newBooks = BookModel::where('book_created', '>=', now()->subDays(14))
            ->orderBy('book_created', 'desc')->take(4)->get();
        $recommended  = BookModel::where('book_stock_qty', '>=', 60)->take(4)->get();


        //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
        return view('home.index', compact('book', 'promotions', 'newBooks', 'bestsellers', 'recommended'));
    }

    public function category($slug)
    {
        Paginator::useBootstrap();

        // หา category จาก slug
        $category = CategoryModel::where('category_slug', $slug)->firstOrFail();

        // ดึงหนังสือใน category นี้
        $books = BookModel::where('category_id', $category->id)
            ->orderBy('id', 'desc')
            ->paginate(12);

        return view('home.category', compact('books', 'category'));
    }

    public function searchbook(Request $request)
    {
        $keyword = $request->keyword;
        $query = BookModel::query();

        if ($keyword) {
            $query->where('book_title', 'like', "%{$keyword}%");
        }

        if ($request->ajax()) {
            return response()->json(
                $query->take(5)->get(['id', 'book_title', 'book_img'])
            );
        }

        $book = $query->paginate(8);
        return view('home.search', compact('book', 'keyword'));
    }

    public function liveSearch(Request $request)
    {
        $keyword = $request->get('keyword');
        $books = BookModel::where('book_title', 'like', "%{$keyword}%")
            ->take(5)
            ->get(['id', 'book_title', 'book_img']);
        return response()->json($books);
    }

    public function history()
    {
        $user = Auth::guard('web')->user();

        // ดึงเฉพาะ order ของ user ที่ล็อกอิน
        $orders = OrderModel::with('details.book')
            ->where('user_id', $user->id)
            ->orderBy('order_date', 'desc')
            ->paginate(10);

        return view('profile.history', compact('orders'));
    }
} //class
