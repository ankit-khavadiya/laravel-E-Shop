<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        return view('admin.payment.index');
    }

    // =========================
    // GET PAYMENTS (DATATABLE)
    // =========================
    public function getPayments(Request $request)
    {
        try {
            $payments = Payment::with(['order']);

            if ($request->status && $request->status != 'all') {
                $payments->where('status', $request->status);
            }

            return DataTables::of($payments)
                ->addIndexColumn()
                ->addColumn('transaction_id', function ($row) {
                    return $row->payment_id ?? 'TXN-' . str_pad($row->id, 5, '0', STR_PAD_LEFT);
                })
                ->addColumn('order_number', function ($row) {
                    return 'ORD-' . str_pad($row->order_id, 4, '0', STR_PAD_LEFT);
                })
                ->addColumn('customer', function ($row) {
                    $name = $row->order?->name ?? '-';
                    $email = $row->order?->email ?? '-';
                    return "
                        <div>
                            <strong>{$name}</strong><br>
                            <small>{$email}</small>
                        </div>
                    ";
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y');
                })
                ->editColumn('amount', function ($row) {
                    return '$' . number_format($row->amount, 2);
                })
                ->addColumn('method', function ($row) {
                    return strtoupper($row->method);
                })
                ->addColumn('status_badge', function ($row) {
                    $class = match ($row->status) {
                        'success' => 'success',
                        'pending' => 'warning',
                        'failed' => 'danger',
                        default => 'secondary',
                    };
                    return "<span class='badge bg-$class'>" . ucfirst($row->status) . "</span>";
                })
                ->addColumn('action', function ($row) {
                    return "
                        <button class='btn btn-sm btn-info viewPayment' data-id='{$row->id}'>
                            <i class='fas fa-eye'></i>
                        </button>
                        <div class='dropdown d-inline'>
                            <button class='btn btn-sm btn-primary dropdown-toggle' data-bs-toggle='dropdown'>Action</button>
                            <ul class='dropdown-menu'>
                                <li><a class='dropdown-item updatePaymentStatus' data-id='{$row->id}' data-status='pending'>Pending</a></li>
                                <li><a class='dropdown-item updatePaymentStatus' data-id='{$row->id}' data-status='success'>Success</a></li>
                                <li><a class='dropdown-item updatePaymentStatus' data-id='{$row->id}' data-status='failed'>Failed</a></li>
                                <li><hr class='dropdown-divider'></li>
                                <li><button class='dropdown-item text-danger deletePayment' data-id='{$row->id}'>Delete</button></li>
                            </ul>
                        </div>
                    ";
                })
                ->rawColumns(['customer', 'status_badge', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    // =========================
    // UPDATE PAYMENT STATUS
    // =========================
    public function updateStatus(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:payments,id',
                'status' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            $payment = Payment::find($request->id);
            $payment->status = $request->status;
            $payment->save();

            return $this->sendSuccess('Payment status updated');

        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    // =========================
    // DELETE PAYMENT
    // =========================
    public function deletePayment(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:payments,id'
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->errors());
            }

            Payment::where('id', $request->id)->delete();

            return $this->sendSuccess('Payment deleted');

        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    // =========================
    // VIEW PAYMENT DETAILS
    // =========================
    public function paymentDetails(Request $request)
    {
        try {

            $payment = Payment::with('order')->find($request->id);

            return $this->sendResponse('Payment details', $payment);

        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
