<?php
namespace App\Repositories\RequestService;

use App\Mail\RequestServiceMail;
use App\Models\RequestService;
use Illuminate\Support\Facades\Mail;

class RequestServiceRepository implements RequestServiceInterface
{
    public function store($request)
    {
        $requestService          = new RequestService();
        $requestService->user_id = $request->get('user')->id;
        $requestService->address = $request->address;
        $requestService->phone   = $request->phone;
        $requestService->service = $request->service;
        $requestService->save();
        $user = $request->get('user');
        $data = [
            'user_name'  => $user->name,
            'user_email' => $user->email,
            'phone'      => $request->phone,
            'address'    => $request->address,
            'service'    => $request->service,
        ];

        $admins = explode(',', env('ADMIN_EMAILS')); //
        Mail::to($admins)->send(new RequestServiceMail($data));

        return true;
    }
    public function about()
    {
        $sections = [
            [
                'title'   => 'About PoolPal',
                'content' => 'PoolPal is your trusted companion in pool care and maintenance. We provide innovative tools, expert guidance, and reliable services to ensure your swimming pool stays clean, safe, and inviting all year round.',
            ],
            [
                'title'   => 'Our Mission',
                'content' => 'To make pool ownership effortless and enjoyable by delivering high-quality products, smart solutions, and exceptional customer support tailored to every pool owner’s needs.',
            ],
            [
                'title'   => 'Our Vision',
                'content' => 'To become the go-to platform for pool care worldwide, empowering pool owners with knowledge, technology, and trusted services for a healthier and more enjoyable swimming experience.',
            ],
        ];

        return $sections;
    }
    public function contact()
    {
        $sections = [
            [
                'title'   => 'Contact Us',
                'content' => 'We are here to help you with any questions or concerns you may have. Reach out to us through the following channels:',
            ],
            [
                'title'   => 'Email',
                'content' => 'For general inquiries, please email us at <a href="mailto:ahmed.ali@techroute66.com">ahmed.ali@techroute66.com </a> We aim to respond within 24 hours.',
            ],
            [
                'title'   => 'Phone',
                'content' => 'You can call us at <a href="tel:+201112912233">+201112912233</a> during our business hours from 9 AM to 5 PM, Monday to Friday.',
            ],
            [
                'title'   => 'Support',
                'content' => 'For support, please visit our support page or contact us via our support email at <a href="mailto:ahmed.ali@techroute66.com">ahmed.ali@techroute66.com </a>',
            ],
        ];

        return $sections;
    }
    public function privacy()
    {
        $sections = [
            'title'   => 'Privacy Policy',
            'list'=> [
                'At PoolPal, your privacy is important to us. This policy explains how we collect, use, and protect your personal information when you use our services.',
                'We may collect personal information such as your name, email address, phone number, and pool details when you interact with our platform or request services.',
                'Your information is used to provide and improve our services, communicate with you, process service requests, and send important updates. We do not sell or share your personal data with third parties except as required by law or to fulfill our services.',
                'We implement industry-standard security measures to protect your data from unauthorized access, alteration, or disclosure.',
                'You have the right to access, update, or delete your personal information. To exercise these rights, please contact us at <a href="mailto: ahmed.ali@techroute66.com">ahmed.ali@techroute66.com</a>.',
                'We may update this privacy policy from time to time. Any changes will be posted on this page with an updated effective date.',
            ]
        ];

        return $sections;
    }

}
