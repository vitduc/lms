<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\CourseNotification;
use Illuminate\Support\Facades\Notification;

class NotificationService
{
    /**
     * Send notification to a specific user
     * 
     * @param User $user The user to send notification to
     * @param string $title Notification title
     * @param string $message Notification message
     * @param string|null $actionUrl Optional action URL
     */
    public function sendToUser(User $user, string $title, string $message, ?string $actionUrl = null)
    {
        $user->notify(new CourseNotification($title, $message, $actionUrl));
    }

    /**
     * Send notification to multiple users
     * 
     * @param array|Collection $users Collection of users
     * @param string $title Notification title
     * @param string $message Notification message
     * @param string|null $actionUrl Optional action URL
     */
    public function sendToUsers($users, string $title, string $message, ?string $actionUrl = null)
    {
        Notification::send($users, new CourseNotification($title, $message, $actionUrl));
    }

    /**
     * Send course enrollment notification to a user
     */
    public function sendEnrollmentNotification(User $user, $courseTitle, $courseId)
    {
        $this->sendToUser(
            $user,
            'Ghi danh thành công',
            "Bạn đã được ghi danh vào khóa học: {$courseTitle}",
            route('my-courses')
        );
    }

    /**
     * Send new lesson notification to enrolled users
     */
    public function sendNewLessonNotification($enrolledUsers, $courseTitle, $lessonTitle, $lessonId)
    {
        $this->sendToUsers(
            $enrolledUsers,
            'Bài học mới',
            "Khóa học {$courseTitle} có bài học mới: {$lessonTitle}",
            route('my-courses') // You can customize this URL
        );
    }

    /**
     * Send course completion notification
     */
    public function sendCourseCompletionNotification(User $user, $courseTitle, $courseId)
    {
        $this->sendToUser(
            $user,
            'Hoàn thành khóa học',
            "Chúc mừng! Bạn đã hoàn thành khóa học: {$courseTitle}",
            route('my-courses')
        );
    }
}

