<?php

namespace App\Http\Controllers;

use App\Models\Stall;
use App\Models\StallUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StallVisitorsExport;

class StallController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $stalls = Stall::all();
    //     return view('admin.stall.index', compact('stalls'));
    // }

    // public function index(Request $request)
    // {
    //     $stalls = Stall::orderBy('id', 'desc')->paginate(10)->appends($request->all());
    //     return view('admin.stall.index', compact('stalls'));
    // }
    
    public function index(Request $request)
    {
        $query = Stall::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('stall_no', 'like', '%' . $search . '%')
                    ->orWhere('stall_name', 'like', '%' . $search . '%')
                    ->orWhere('business', 'like', '%' . $search . '%')
                    ->orWhere('stall_user_name', 'like', '%' . $search . '%')
                    ->orWhere('mobile', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('website', 'like', '%' . $search . '%');
            });
        }

        $stalls = $query->orderBy('id', 'desc')->paginate(10)->appends($request->all());
        return view('admin.stall.index', compact('stalls'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.stall.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'stall_no' => 'required|string|unique:stalls,stall_no',
            'stall_name' => 'required|string|max:255',
            'business' => 'nullable|string|max:255',
            'stall_user_name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'email' => 'required|email|unique:stalls,email',
            'password' => 'required|string|min:8',
            'website' => 'nullable|string',
        ]);

        $stall = new Stall;
        $stall->stall_no = $request->stall_no;
        $stall->stall_name = $request->stall_name;
        $stall->business = $request->business;
        $stall->stall_user_name = $request->stall_user_name;
        $stall->mobile = $request->mobile;
        $stall->email = $request->email;
        $stall->password = bcrypt($request->password);
        if ($request->website && !str_contains($request->website, '@')) {
            if (!preg_match("~^(?:f|ht)tps?://~i", $request->website)) {
                $request->merge([
                    'website' => 'https://' . $request->website
                ]);
            }
        }

        $stall->website = $request->website;
        $stall->save();

        return redirect()->route('stalls.index')->with('success', 'Stall created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $stall = Stall::findOrFail($id);
        return view('admin.stall.edit', compact('stall'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $stall = Stall::findOrFail($id);

        $request->validate([
            'stall_no' => 'required|string|unique:stalls,stall_no,' . $stall->id,
            'stall_name' => 'required|string|max:255',
            'business' => 'nullable|string|max:255',
            'stall_user_name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'email' => 'required|email|unique:stalls,email,' . $stall->id,
            'password' => 'nullable|string|min:8',
            'website' => 'nullable|string',
        ]);

        $stall->stall_no = $request->stall_no;
        $stall->stall_name = $request->stall_name;
        $stall->business = $request->business;
        $stall->stall_user_name = $request->stall_user_name;
        $stall->mobile = $request->mobile;
        $stall->email = $request->email;
        if ($request->password) {
            $stall->password = bcrypt($request->password);
        }
        $stall->website = $request->website;
        $stall->save();

        return redirect()->route('stalls.index')->with('success', 'Stall updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stall = Stall::findOrFail($id);
        $stall->delete();

        return redirect()->route('stalls.index')->with('success', 'Stall deleted successfully.');
    }

//   public function exportVisitors(Request $request,$stall_id)
//     {
//       // dd($request->date);
//         return Excel::download(
//             new StallVisitorsExport($stall_id, $request->date),
//             'visitors.xlsx'
//         );
//     }


public function exportVisitors(Request $request, $stall_id)
{
    $date = $request->date;

   
    $stall = Stall::find($stall_id);

   
    $stallName = $stall ? $stall->stall_name : 'stall'.$stall_id;

 
    $fileName = $stallName . '(' . $date . ').xlsx';

    return Excel::download(
        new StallVisitorsExport($stall_id, $date),
        $fileName
    );
}

    /**
     * API Login for stall.
     */
    public function apiLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $stall = Stall::where('email', $request->email)->first();

        if (!$stall || !Hash::check($request->password, $stall->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = Str::random(64);
        $stall->api_token = $token;
        $stall->save();

        return response()->json(['token' => $token, 'stall' => $stall]);
    }

    // public function apiScanUser(Request $request)
    // {
    //     try {
    //         $authHeader = $request->header('Authorization');

    //         if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
    //             return response()->json([
    //                 'success' => false,
    //                 'status_code' => 401,
    //                 'message' => 'Authorization token not provided or invalid'
    //             ], 401);
    //         }

    //         $token = str_replace('Bearer ', '', $authHeader);

    //         $stall = Stall::where('api_token', $token)->first();

    //         if (!$stall) {
    //             return response()->json([
    //                 'success' => false,
    //                 'status_code' => 404,
    //                 'message' => 'Token not found'
    //             ], 404);
    //         }

    //         $request->validate([
    //             'user_id' => 'required|integer|exists:users,id',
    //         ]);

    //         $user = User::find($request->user_id);

    //         $stallUser = new StallUser();
    //         $stallUser->stall_id = $stall->id;
    //         $stallUser->user_id = $request->user_id;
    //         $stallUser->scanned_at = now();
    //         $stallUser->save();

    //         return response()->json([
    //             'success' => true,
    //             'status_code' => 200,
    //             'message' => 'User scanned successfully',
    //             'data' => [
    //                 'stall_id' => $stall->id,
    //                 'user_id' => $request->user_id,
    //                 'scanned_at' => $stallUser->scanned_at,
    //             ]
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'status_code' => 500,
    //             'message' => 'Scan failed',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }
    
    
    public function apiScanUser(Request $request)
{
    try {

        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json([
                'success' => false,
                'status_code' => 401,
                'message' => 'Authorization token not provided or invalid'
            ], 401);
        }

        $token = str_replace('Bearer ', '', $authHeader);
        $stall = Stall::where('api_token', $token)->first();

        if (!$stall) {
            return response()->json([
                'success' => false,
                'status_code' => 404,
                'message' => 'Token not found'
            ], 404);
        }

        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $user = User::find($request->user_id);

        // ⛔ Check if user already scanned in same Stall and same Date
        $alreadyScanned = StallUser::where('stall_id', $stall->id)
            ->where('user_id', $user->id)
            ->whereDate('scanned_at', now()->toDateString())
            ->first();

        if ($alreadyScanned) {
            return response()->json([
                'success' => false,
                'status_code' => 409,
                'message' => 'User already scanned today for this stall'
            ], 409);
        }

        // If not scanned → Insert record
        $stallUser = new StallUser();
        $stallUser->stall_id = $stall->id;
        $stallUser->user_id = $user->id;
        $stallUser->scanned_at = now();
        $stallUser->save();

        return response()->json([
            'success' => true,
            'status_code' => 200,
            'message' => 'User scanned successfully',
            'data' => [
                'stall_id' => $stall->id,
                'user_id' => $user->id,
                'scanned_at' => $stallUser->scanned_at,
            ]
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'status_code' => 500,
            'message' => 'Scan failed',
            'error' => $e->getMessage()
        ], 500);
    }
}

    
    
    
    public function apiUserlist(Request $request)
    {
        $users = StallUser::where('stall_id',  $request->stall_id)
            ->whereDate('scanned_at', $request->date)
            ->with('user')
            ->orderBy('id', 'desc') // DESCENDING ORDER
            ->paginate(50);   
           // ->get();

        return response()->json([
            'success' => true,
            'status_code' => 200,
            'message' => 'User list',
            'data' => $users
        ]);
    }
    
    
    
        public function apiUserExportList(Request $request)
    {
        $users = StallUser::where('stall_id',  $request->stall_id)
            ->whereDate('scanned_at', $request->date)
            ->with('user')
            ->get();
    
        return response()->json([
            'success' => true,
            'status_code' => 200,
            'message' => 'User list',
            'data' => $users
        ]);
    }


    public function apiLogout(Request $request)
    {
        try {
            $authHeader = $request->header('Authorization');

            if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
                return response()->json([
                    'success' => false,
                    'status_code' => 401,
                    'message' => 'Authorization token not provided or invalid'
                ], 401);
            }

            $token = str_replace('Bearer ', '', $authHeader);

            $stall = Stall::where('api_token', $token)->first();

            if (!$stall) {
                return response()->json([
                    'success' => false,
                    'status_code' => 404,
                    'message' => 'Token not found'
                ], 404);
            }

            $stall->api_token = null;
            $stall->save();

            return response()->json([
                'success' => true,
                'status_code' => 200,
                'message' => 'Logout successful'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status_code' => 500,
                'message' => 'Logout failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
