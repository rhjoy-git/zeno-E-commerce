<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CustomerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = User::with('customerProfile')
            ->whereHas('role', function ($query) {
                $query->where('slug', 'customer');
            })->paginate(20);
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Get paginated customer data for DataTables
     */
    public function data(Request $request)
    {
        $query = User::with(['profile', 'orders'])
            ->whereHas('role', function ($q) {
                $q->where('slug', 'customer'); // Assuming you have a role system
            })
            ->select([
                'users.*',
                DB::raw('(SELECT COUNT(*) FROM invoices WHERE user_id = users.id) as orders_count'),
                DB::raw('(SELECT MAX(last_activity) FROM sessions WHERE user_id = users.id) as last_activity')
            ]);

        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('profile', function ($q) use ($search) {
                        $q->where('cus_phone', 'like', "%{$search}%")
                            ->orWhere('cus_name', 'like', "%{$search}%");
                    });
            });
        }

        // Status filter
        if ($request->has('status') && !empty($request->status)) {
            if ($request->status === 'active') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status === 'inactive') {
                $query->whereNull('email_verified_at');
            }
        }

        // Order by
        $query->orderBy('created_at', 'desc');

        // Pagination
        $perPage = $request->has('per_page') ? $request->per_page : 10;
        $customers = $query->paginate($perPage);

        return response()->json([
            'data' => $customers->items(),
            'current_page' => $customers->currentPage(),
            'last_page' => $customers->lastPage(),
            'total' => $customers->total(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'cus_name' => 'required|string|max:100',
            'cus_add' => 'required|string|max:500',
            'cus_city' => 'required|string|max:50',
            'cus_state' => 'nullable|string|max:50',
            'cus_postcode' => 'nullable|string|max:50',
            'cus_country' => 'nullable|string|max:50',
            'cus_phone' => 'nullable|string|max:50',
            'cus_fax' => 'nullable|string|max:50',
            'ship_name' => 'nullable|string|max:100',
            'ship_add' => 'nullable|string|max:100',
            'ship_city' => 'nullable|string|max:100',
            'ship_state' => 'nullable|string|max:100',
            'ship_postcode' => 'nullable|string|max:100',
            'ship_country' => 'nullable|string|max:100',
            'ship_phone' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role_id' => 2, // Assuming 2 is the customer role ID
                'email_verified_at' => now(), // Auto-verify admin-created accounts
            ]);

            $user->profile()->create([
                'cus_name' => $request->cus_name,
                'cus_add' => $request->cus_add,
                'cus_city' => $request->cus_city,
                'cus_state' => $request->cus_state,
                'cus_postcode' => $request->cus_postcode,
                'cus_country' => $request->cus_country,
                'cus_phone' => $request->cus_phone,
                'cus_fax' => $request->cus_fax,
                'ship_name' => $request->ship_name,
                'ship_add' => $request->ship_add,
                'ship_city' => $request->ship_city,
                'ship_state' => $request->ship_state,
                'ship_postcode' => $request->ship_postcode,
                'ship_country' => $request->ship_country,
                'ship_phone' => $request->ship_phone,
            ]);
        });

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $customer)
    {
        $customer->load('profile');
        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $customer)
    {
        $customer->load('profile');
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $customer)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $customer->id,
            'password' => 'nullable|string|min:8|confirmed',
            'cus_name' => 'required|string|max:100',
            'cus_add' => 'required|string|max:500',
            'cus_city' => 'required|string|max:50',
            'cus_state' => 'nullable|string|max:50',
            'cus_postcode' => 'nullable|string|max:50',
            'cus_country' => 'nullable|string|max:50',
            'cus_phone' => 'nullable|string|max:50',
            'cus_fax' => 'nullable|string|max:50',
            'ship_name' => 'nullable|string|max:100',
            'ship_add' => 'nullable|string|max:100',
            'ship_city' => 'nullable|string|max:100',
            'ship_state' => 'nullable|string|max:100',
            'ship_postcode' => 'nullable|string|max:100',
            'ship_country' => 'nullable|string|max:100',
            'ship_phone' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::transaction(function () use ($request, $customer) {
            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $updateData['password'] = bcrypt($request->password);
            }

            $customer->update($updateData);

            $profileData = [
                'cus_name' => $request->cus_name,
                'cus_add' => $request->cus_add,
                'cus_city' => $request->cus_city,
                'cus_state' => $request->cus_state,
                'cus_postcode' => $request->cus_postcode,
                'cus_country' => $request->cus_country,
                'cus_phone' => $request->cus_phone,
                'cus_fax' => $request->cus_fax,
                'ship_name' => $request->ship_name,
                'ship_add' => $request->ship_add,
                'ship_city' => $request->ship_city,
                'ship_state' => $request->ship_state,
                'ship_postcode' => $request->ship_postcode,
                'ship_country' => $request->ship_country,
                'ship_phone' => $request->ship_phone,
            ];

            if ($customer->profile) {
                $customer->profile->update($profileData);
            } else {
                $customer->profile()->create($profileData);
            }
        });

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $customer)
    {
        DB::transaction(function () use ($customer) {
            // Delete related records
            $customer->profile()->delete();

            // Delete invoices and related records
            $customer->invoices()->each(function ($invoice) {
                $invoice->products()->delete();
                $invoice->delete();
            });

            // Delete other related data
            $customer->reviews()->delete();
            $customer->wishlist()->delete();
            $customer->cart()->delete();

            // Finally delete the user
            $customer->delete();
        });

        return response()->json(['success' => true, 'message' => 'Customer deleted successfully']);
    }

    /**
     * Export customers to CSV
     */
    public function export(Request $request)
    {
        $fileName = 'customers_' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"             => "no-cache",
            "Cache-Control"      => "must-revalidate, post-check=0, pre-check=0",
            "Expires"            => "0"
        ];

        $query = User::with('profile')
            ->whereHas('role', function ($q) {
                $q->where('slug', 'customer');
            });

        // Apply filters if present
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('profile', function ($q) use ($search) {
                        $q->where('cus_phone', 'like', "%{$search}%")
                            ->orWhere('cus_name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status === 'inactive') {
                $query->whereNull('email_verified_at');
            }
        }

        $customers = $query->get();

        $columns = [
            'ID',
            'Name',
            'Email',
            'Phone',
            'Address',
            'City',
            'State',
            'Postcode',
            'Country',
            'Account Status',
            'Created At'
        ];

        $callback = function () use ($customers, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($customers as $customer) {
                $row = [
                    $customer->id,
                    $customer->name,
                    $customer->email,
                    $customer->profile->cus_phone ?? '',
                    $customer->profile->cus_add ?? '',
                    $customer->profile->cus_city ?? '',
                    $customer->profile->cus_state ?? '',
                    $customer->profile->cus_postcode ?? '',
                    $customer->profile->cus_country ?? '',
                    $customer->email_verified_at ? 'Verified' : 'Pending',
                    $customer->created_at->format('Y-m-d H:i:s'),
                ];

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
