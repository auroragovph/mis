<?php

namespace Modules\Messenger\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HumanResource\Entities\HR_Employee;
use Modules\Messenger\Entities\Messenger;

class MessengerController extends Controller
{
    public function index()
    {
        return view('messenger::index');
    }

    public function messages($id)
    {
        $receiver = HR_Employee::find($id);

        $convos = Messenger::whereIn('sender', [auth()->user()->employee_id, $id])
                            ->whereIn('receiver', [auth()->user()->employee_id, $id])
                            ->orderBy('created_at', 'ASC')
                            ->get();

        return view('messenger::index', [
            'receiver' => $receiver,
            'convos' => $convos
        ]);
    }

    public function send(Request $request, $id)
    {
        $con = Messenger::create([
            'sender' => auth()->user()->employee_id,
            'receiver' => $id,
            'message' => $request->post('message')
        ]);

        return response()->json([
            'message' => 'Message has been sent.',
            'convo' => [
                'text' => $request->post('message'),
                'time' => Carbon::parse($con->created_at)->format('Y-m-d h:i A'),
                'image' => asset('images/user-default.png')
            ]
        ], 200);

    }
}
