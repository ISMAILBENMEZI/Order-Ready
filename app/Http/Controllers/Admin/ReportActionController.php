<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReportRequest;
use App\Mail\Admin\ReporterFeedbackMail;
use App\Mail\Admin\SellerActionMail;
use App\Models\Product;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ReportActionController extends Controller
{
    public function reports()
    {
        $reports = Report::with(['product', 'user'])->latest()->paginate(10);

        return view('admin.reports', compact('reports'));
    }

    public function updateReportAction(ReportRequest $request)
    {
        // dd($request);
        DB::transaction(function () use ($request) {
            $product = Product::findOrFail($request->product_id);

            $product->update([
                'admin_status' => $request->product_admin_status,
                'ban_reason' => $request->seller_message
            ]);

            $report = Report::findOrFail($request->report_id);
            $report->update([
                'status' => $request->report_status,
                'admin_note' => $request->reporter_message
            ]);

            Mail::to($product->store->contact_email)->send(new SellerActionMail($product, $request->seller_message));
            Mail::to($report->user->email)->send(new ReporterFeedbackMail($report,$request->reporter_message));
        });

        return back()->with('success', 'Report and Product status updated successfully.');
    }
}
