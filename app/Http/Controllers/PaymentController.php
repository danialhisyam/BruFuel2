<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        // Fake summary numbers
        $summary = [
            'totalRevenue' => 8000,
            'totalTransactions' => 100,
            'pending' => 4,
            'failed' => 6,
            'revenueByMonth' => [
                'Jan' => 90, 'Feb' => 180, 'Mar' => 210, 'Apr' => 200,
                'May' => 160, 'Jun' => 90, 'Jul' => 220, 'Aug' => 140,
                'Sep' => 80, 'Oct' => 170, 'Nov' => 0, 'Dec' => 0,
            ],
        ];

        // Fake transactions (id, name, date, time, amount, provider, status)
        $transactions = [
            ['id'=>875,'name'=>'ADIB','date'=>'Oct 10, 2025','time'=>'17:53:01 PM','amount'=>30,'provider'=>'BAIDURI','status'=>'Pending'],
            ['id'=>236,'name'=>'MOHAMMAD ALI','date'=>'Oct 10, 2025','time'=>'12:05:58 PM','amount'=>40,'provider'=>'BIBD','status'=>'Paid'],
            ['id'=>101,'name'=>'IRYNA','date'=>'Oct 09, 2025','time'=>'18:12:06 PM','amount'=>26,'provider'=>'TAIB','status'=>'Paid'],
            ['id'=>641,'name'=>'NADEERAH','date'=>'Oct 08, 2025','time'=>'18:10:01 PM','amount'=>30,'provider'=>'BAIDURI','status'=>'Fail'],
            ['id'=>522,'name'=>'AFIQ','date'=>'Oct 07, 2025','time'=>'10:52:57 PM','amount'=>20,'provider'=>'CASH','status'=>'Paid'],
            ['id'=>465,'name'=>'FAIZ','date'=>'Oct 07, 2025','time'=>'13:45:15 PM','amount'=>30,'provider'=>'TAIB','status'=>'Paid'],
            ['id'=>512,'name'=>'DURRATUL','date'=>'Oct 07, 2025','time'=>'10:27:01 PM','amount'=>28,'provider'=>'TAIB','status'=>'Paid'],
            ['id'=>367,'name'=>'AMEER','date'=>'Oct 07, 2025','time'=>'08:25:01 PM','amount'=>25,'provider'=>'BIBD','status'=>'Paid'],
            ['id'=>234,'name'=>'HAZWAN','date'=>'Oct 06, 2025','time'=>'20:30:00 PM','amount'=>30,'provider'=>'CASH','status'=>'Paid'],
            ['id'=>323,'name'=>'SARAH','date'=>'Oct 06, 2025','time'=>'18:20:00 PM','amount'=>20,'provider'=>'BIBD','status'=>'Fail'],
            ['id'=>205,'name'=>'MOHAMMAD SAFWAN','date'=>'Oct 05, 2025','time'=>'10:02:21 PM','amount'=>40,'provider'=>'BIBD','status'=>'Paid'],
        ];

        return view('payments.index', compact('summary', 'transactions'));
    }
}
