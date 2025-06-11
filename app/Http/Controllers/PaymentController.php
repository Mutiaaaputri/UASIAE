<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
class PaymentController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'All payments retrieved successfully.',
            'data' => PaymentResource::collection(Payment::all())
        ]);
    }

    public function store(Request $request)
    {
        try {

            //try
            $request->merge([
                'transaction_id' => $request->transaction_id ?? 'TRX-' . Str::uuid(),
            ]);


            $validated = $request->validate([
                // 'user_id' => 'required|exists:users,id',
                'user_id' => 'required|numeric',

                'amount' => 'required|numeric',
                'currency' => 'required|string|size:3',
                'method' => 'required|string',
                'status' => 'required|string',
                'transaction_id' => 'required|string|unique:payments,transaction_id',
            ]);

            $payment = Payment::create($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Payment created successfully.',
                'data' => new PaymentResource($payment)
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function show($id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment not found.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Payment retrieved successfully.',
            'data' => new PaymentResource($payment)
        ]);
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment not found.',
            ], 404);
        }

        try {
            $validated = $request->validate([
                'amount' => 'sometimes|numeric',
                'currency' => 'sometimes|string|size:3',
                'method' => 'sometimes|string',
                'status' => 'sometimes|string',
            ]);

            $payment->update($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Payment updated successfully.',
                'data' => new PaymentResource($payment)
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function destroy($id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment not found.',
            ], 404);
        }

        $payment->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Payment deleted successfully.'
        ]);
    }
}
