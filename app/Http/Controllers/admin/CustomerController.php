<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Traits\ResponseTrait;

class CustomerController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        return view('admin.customer.index');
    }

    // ======================
    // GET CUSTOMERS (AJAX)
    // ======================
    public function getCustomers(Request $request)
    {
        try {
            $customers = User::with(['orders']);
            return DataTables::of($customers)
                ->addIndexColumn()
                // CUSTOMER ID
                ->addColumn('customer_id', function ($row) {
                    return 'CUS-' . str_pad($row->id, 4, '0', STR_PAD_LEFT);
                })
                // NAME
                ->addColumn('name', function ($row) {
                    return $row->name ?? '-';
                })
                // EMAIL
                ->addColumn('email', function ($row) {
                    return $row->email ?? '-';
                })
                // PHONE
                ->addColumn('phone', function ($row) {
                    return $row->phone ?? '-';
                })
                // TOTAL ORDERS
                ->addColumn('orders_count', function ($row) {
                    return $row->orders->count();
                })
                // TOTAL SPENT
                ->addColumn('total_spent', function ($row) {
                    $total = $row->orders->sum('total');
                    return '$' . number_format($total, 2);
                })
                // ACTION
                ->addColumn('action', function ($row) {
                    return "
                        <button class='btn btn-sm btn-info viewCustomer' data-id='{$row->id}'>
                            <i class='fas fa-eye'></i>
                        </button>

                        <button class='btn btn-sm btn-danger deleteCustomer' data-id='{$row->id}'>
                            <i class='fas fa-trash'></i>
                        </button>
                    ";
                })
                ->rawColumns(['action'])
                ->make(true);

        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    // ======================
    // CUSTOMER DETAILS
    // ======================
    public function customerDetails(Request $request)
    {
        try {
            $customer = User::with('orders')->find($request->id);
            if (!$customer) {
                return $this->sendError('Customer not found');
            }
            return $this->sendResponse('Customer details', $customer);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    // ======================
    // DELETE CUSTOMER
    // ======================
    public function deleteCustomer(Request $request)
    {
        try {
            User::where('id', $request->id)->delete();
            return $this->sendSuccess('Customer deleted');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
