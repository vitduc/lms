<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Display listing of courses
     */
    public function index(Request $request)
    {
        $query = Course::with(['instructor', 'category', 'level'])
            ->where('status', 'published');

        // Filter by category
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by level
        if ($request->has('level')) {
            $query->whereHas('level', function($q) use ($request) {
                $q->where('slug', $request->level);
            });
        }

        // Search
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter free/paid
        if ($request->has('price')) {
            if ($request->price === 'free') {
                $query->where('price', 0);
            } elseif ($request->price === 'paid') {
                $query->where('price', '>', 0);
            }
        }

        $courses = $query->paginate(12);

        return view('courses.index', compact('courses'));
    }

    /**
     * Show course details
     */
    public function show($slug)
    {
        $course = Course::with(['instructor', 'category', 'level', 'enrollments', 'reviews.user'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $isEnrolled = Auth::check() && $course->isEnrolledBy(Auth::id());

        $averageRating = $course->reviews()->avg('rating');
        $reviewsCount = $course->reviews()->count();

        return view('courses.show', compact('course', 'isEnrolled', 'averageRating', 'reviewsCount'));
    }

    /**
     * Enroll in a course
     */
    public function enroll(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đăng ký khóa học.');
        }

        $user = Auth::user();

        // Check if already enrolled
        if ($course->isEnrolledBy($user->id)) {
            return back()->with('info', 'Bạn đã đăng ký khóa học này rồi.');
        }

        // If course is free, enroll directly
        if ($course->isFree()) {
            CourseEnrollment::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'status' => 'active',
                'progress_percentage' => 0,
                'enrolled_at' => now(),
            ]);

            // Send notification
            $this->notificationService->sendEnrollmentNotification(
                $user,
                $course->title,
                $course->id
            );

            return redirect()->route('my-courses')
                ->with('success', 'Đăng ký khóa học thành công!');
        }

        // If course is paid, redirect to payment
        return redirect()->route('courses.payment', $course->id);
    }

    /**
     * Show payment page
     */
    public function payment($id)
    {
        $course = Course::findOrFail($id);

        if ($course->isFree()) {
            return redirect()->route('courses.show', $course->slug)
                ->with('info', 'Khóa học này miễn phí.');
        }

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thanh toán.');
        }

        $user = Auth::user();

        // Check if already enrolled
        if ($course->isEnrolledBy($user->id)) {
            return redirect()->route('courses.show', $course->slug)
                ->with('info', 'Bạn đã đăng ký khóa học này rồi.');
        }

        return view('courses.payment', compact('course'));
    }

    /**
     * Process payment
     */
    public function processPayment(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        if ($course->isFree()) {
            return back()->with('error', 'Khóa học này miễn phí.');
        }

        $user = Auth::user();

        // Check if already enrolled
        if ($course->isEnrolledBy($user->id)) {
            return back()->with('info', 'Bạn đã đăng ký khóa học này rồi.');
        }

        $request->validate([
            'payment_method' => 'required|in:credit_card,paypal,bank_transfer',
        ]);

        // Create order
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'total_amount' => $course->price,
            'discount_amount' => 0,
            'final_amount' => $course->price,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
        ]);

        // Create order item
        OrderItem::create([
            'order_id' => $order->id,
            'course_id' => $course->id,
            'course_title' => $course->title,
            'price' => $course->price,
            'discount' => 0,
            'subtotal' => $course->price,
        ]);

        // For demo purposes, we'll simulate payment success
        // In production, integrate with payment gateway (Stripe, PayPal, etc.)
        $transactionId = 'TXN-' . strtoupper(Str::random(15));

        // Create payment record
        $payment = Payment::create([
            'order_id' => $order->id,
            'transaction_id' => $transactionId,
            'amount' => $course->price,
            'payment_method' => $request->payment_method,
            'status' => 'completed', // In production, this would be 'pending' until gateway confirms
            'gateway' => 'demo',
            'paid_at' => now(),
        ]);

        // Update order status
        $order->update([
            'status' => 'completed',
            'paid_at' => now(),
        ]);

        // Enroll user in course
        CourseEnrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'active',
            'progress_percentage' => 0,
            'enrolled_at' => now(),
        ]);

        // Send notification
        $this->notificationService->sendEnrollmentNotification(
            $user,
            $course->title,
            $course->id
        );

        return redirect()->route('my-courses')
            ->with('success', 'Thanh toán thành công! Bạn đã được ghi danh vào khóa học.');
    }
}

