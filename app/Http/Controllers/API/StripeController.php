<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Http\Controllers\API\BaseController;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Stripe\Checkout\Session as StripeSession;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;
use App\Helpers\FirebaseNotification;
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
            'success_url' =>
                route('checkout.success') .
                '?session_id={CHECKOUT_SESSION_ID}' .
                '&token=' .
                $token,
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

            return $this->error(
                'error',
                'error in getting user data',
                $response->status()
            );
        } catch (\Exception $e) {
            return $this->error('error', $e->getMessage(), 500);
        }
    }

    public function paymentSuccess(Request $request)
    {
        $sessionId = $request->get('session_id');
        $token = $request->get('token');

        if (!$sessionId || !$token) {
            return $this->error('error', 'Missing session_id or token', 400);
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $session = StripeSession::retrieve($sessionId);

            if ($session && $session->payment_status === 'paid') {
                $this->storeOrder($session, $token);
                $this->clearCart($token);
                return $this->success('success', 'Payment successful', 200);
            }

            return $this->error('error', 'Payment failed', 400);
        } catch (\Exception $e) {
            return $this->error('error', $e->getMessage(), 500);
        }
    }

    public function storeOrder($session, $token)
    {
        // // 1. بيانات المستخدم
        $userData = $this->getUserData($token);
        if (!$userData || !isset($userData['data']['ID'])) {
            return $this->error('error', 'User data not found', 400);
        }

        // 2. بيانات السلة
        $cartData = $this->getCart($token);

        if (!$cartData || empty($cartData['items'])) {
            return $this->error('error', 'Cart data not found', 400);
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
            env('WEBSITE_URL') .
                '/wp-json/wc/v3/orders?consumer_key=' .
                env('WOOCOMMERCE_KEY') .
                '&consumer_secret=' .
                env('WOOCOMMERCE_SECRET'),
            $order
        );

        // 7. النتيجة
        if ($response->successful()) {
            return $this->success('success', 'Order created successfully', 200);
        } else {
            return $this->error('error', 'Order creation failed', 400);
        }
    }

    public function paymentCancel()
    {
        return $this->error('error', 'Payment canceled', 400);
    }

    public function sendNotification(Request $request)
    {



        try {
            $response = FirebaseNotification::sendNotification(
                $request->input('token'),
                $request->input('title'),
                $request->input('body')
            );

            return response()->json(['message' => 'Notification sent!', 'firebase_response' => $response]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function clearCart($token)
    {

            $client = new Client();

            $response = $client->request(
                'POST',
                env('WEBSITE_URL') . '/wp-json/cocart/v2/cart/clear',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ],
                ]
            );

            $result = json_decode($response->getBody(), true);

            return $result;

    }

}
