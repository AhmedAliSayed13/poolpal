<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Http\Controllers\API\BaseController;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Stripe\Checkout\Session as StripeSession;
class StripeController extends BaseController
{
    public function checkout(Request $request)
    {
        $token = $request->bearerToken();
        $cartData = $this->getCart($token);

        $lineItems = [];
        foreach ($cartData['items'] as $item) {
            $productName = $item['name'];
            $unitAmount = (int) $item['price'];
            $quantity = (int) $item['quantity']['value'];

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd', // ✅ تم التغيير هنا
                    'product_data' => [
                        'name' => $productName,
                    ],
                    'unit_amount' => $unitAmount,
                ],
                'quantity' => $quantity,
            ];
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}' . '&token=' . $token,
            'cancel_url' => route('checkout.cancel'),
        ]);

        return $this->success(
            ['checkout_url' => $session->url],
            'retrieve checkout url successfully'
        );
    }

    public function getCart($token)
    {
        $client = new Client();
        $response = $client->request(
            'GET',
            env('WEBSITE_URL') . '/wp-json/cocart/v2/cart',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token, // لو الكارت مربوط بالمستخدم
                    'Accept' => 'application/json',
                ],
            ]
        );
        $cartData = json_decode($response->getBody(), true);

        return $cartData;
    }

    public function getUserData($token)
    {
        $url = env('WEBSITE_URL') . '/wp-json/custom/v1/user-profile';

        try {
            $response = Http::withToken($token)->get($url);

            if ($response->successful()) {
                $cartData = json_decode($response->getBody(), true);

                return $cartData;
            }

            return [
                'error' => true,
                'message' => 'فشل في جلب بيانات المستخدم',
                'status' => $response->status(),
            ];
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function paymentSuccess(Request $request)
    {
        $sessionId = $request->get('session_id');
        $token = $request->get('token');

        if (!$sessionId || !$token) {
            return '❌ لم يتم الدفع بعد.';
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $session = StripeSession::retrieve($sessionId);

            if ($session && $session->payment_status === 'paid') {
                return  $this->storeOrder($session, $token);
                return 'ok1';

                return '✅ تم الدفع بنجاح.';
            }

            return '❌ لم يتم الدفع بعد.';
        } catch (\Exception $e) {
            return '⚠️ خطأ أثناء معالجة الدفع: ' . $e->getMessage();
        }
    }

    public function storeOrder($session, $token)
    {
        // // 1. بيانات المستخدم
        $userData = $this->getUserData($token);
        if (!$userData || !isset($userData['data']['ID'])) {
            return response()->json(
                ['message' => 'فشل في جلب بيانات المستخدم'],
                400
            );
        }

        // 2. بيانات السلة
        $cartData = $this->getCart($token);

        if (!$cartData || empty($cartData['items'])) {
            return response()->json(['message' => 'السلة فارغة'], 400);
        }


        // 3. تحويل عناصر السلة إلى line_items
        $lineItems = [];

        foreach ($cartData['items'] as $item) {
            $lineItems[] = [
                'product_id' =>
                    $item['meta']['variation']['parent_id'] ?? $item['id'],
                'variation_id' => $item['id'], // في حالة المنتج متغير
                'quantity' => $item['quantity']['value'],
            ];
        }


        // 4. الشحن
        $shippingLines = [];


        // 5. تجهيز الطلب النهائي
        $order = [
            'customer_id' => $userData['data']['ID'],
            'payment_method' => 'cod', // أو stripe
            'payment_method_title' => 'Cash on Delivery',
            'set_paid' => true,
            'billing' => $userData['data']['billing'],
            'shipping' => $userData['data']['shipping'],
            'line_items' => $lineItems,
            'shipping_lines' => $shippingLines,
        ];

        // 6. إرسال الطلب إلى WooCommerce
        $response = Http::post(
            env('WEBSITE_URL') . '/wp-json/wc/v3/orders?consumer_key=' . env('WOOCOMMERCE_KEY') . '&consumer_secret=' . env('WOOCOMMERCE_SECRET'),
            $order
            );


        // 7. النتيجة
        if ($response->successful()) {
            return response()->json(
                [
                    'message' => '✅ تم إنشاء الطلب بنجاح'
                ],
                201
            );
        } else {
            return response()->json(
                [
                    'message' => '❌ فشل في إنشاء الطلب',
                    'error' => $response->json(),
                ],
                $response->status()
            );
        }
    }

    public function paymentCancel()
    {
        return '❌ تم إلغاء الدفع.';
    }
}
