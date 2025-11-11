<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;
use App\Exports\ResultExport;
use Maatwebsite\Excel\Facades\Excel;

class ResultController extends Controller
{
    public function index(Request $request)
    {
       
        $query = Result::query();

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('email','like',"%$search%")
                  ->orWhere('paper_code','like',"%$search%")
                  ->orWhere('description','like',"%$search%");
            });
        }

        $results = $query->orderBy('created_at','desc')->paginate(15)->withQueryString();

        return view('results.index', compact('results'));
    }

    public function exportAll()
    {
        return Excel::download(new ResultExport(), 'results_all.xlsx');
    }

    public function exportSelected(Request $request)
    {
        $ids = $request->ids ?? [];
   
        if (!is_array($ids)) {
            $ids = explode(',', $ids);
        }
        return Excel::download(new ResultExport($ids), 'results_selected.xlsx');
    }
}
