<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderModel;
use App\Models\OrderDetailsModel;
use App\Models\PaymentModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CheckoutController extends Controller
{
    public function uploadForm(Request $request)
    {
        $cartJson = $request->input('cart_json');
        $cart = json_decode($cartJson, true) ?? [];

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'กรุณาเลือกหนังสือที่ต้องการชำระเงิน');
        }

        session()->put('checkout_cart', $cart);

        return view('checkout.upload', compact('cart'));
    }

    public function uploadSlip(Request $request)
    {
        $user = Auth::guard('web')->user() ?? Auth::guard('admin')->user();

        $request->validate([
            'slip' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $cart = session()->get('checkout_cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'ไม่พบรายการที่เลือก');
        }

        DB::beginTransaction();
        try {
            $path = $request->file('slip')->store('payments', 'public');
            $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['qty']);
            $shippingAddress = $user->user_address ?? '';

            // ✅ บันทึก order
            $order = OrderModel::create([
                'user_id' => $user->id,
                'order_status' => 'paid',
                'order_subtotal' => $subtotal,
                'order_discount' => 0,
                'order_amount' => $subtotal,
                'order_shipping_address' => $shippingAddress,
            ]);

            // ✅ บันทึก order details
            foreach ($cart as $item) {
                OrderDetailsModel::create([
                    'order_id' => $order->id,
                    'book_id'  => $item['id'],
                    'orderdetails_qty' => $item['qty'],
                    'orderdetails_unit_price' => $item['price'],
                    'orderdetails_total_price' => $item['price'] * $item['qty'],
                ]);
            }

            // ✅ บันทึก payment
            PaymentModel::create([
                'order_id' => $order->id,
                'pay_method' => 'promptpay',
                'pay_amount' => $subtotal,
                'pay_proof_path' => $path,
                'pay_paid_at' => now(),
            ]);

            // ✅ ล้าง session และส่ง id ที่จ่ายแล้วกลับไป
            session()->forget('checkout_cart');
            DB::commit();

            return redirect()->route('cart.index')
                ->with('success', 'อัปโหลดสลิปเรียบร้อยแล้ว')
                ->with('paid_ids', collect($cart)->pluck('id')->toArray());
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'เกิดข้อผิดพลาด: '.$e->getMessage());
        }
    }
}
