<?php

namespace App\Console\Commands;

use App\Models\Assignment;
use App\Services\FirebaseNotificationService;
use Carbon\Carbon;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('notify')]
#[Description('Command description')]
class SendUpcomingTaskNotifications extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(FirebaseNotificationService $firebase)
    {
        $now = Carbon::now();
        $today = Carbon::today()->toDateString();

        $notificationTime = $now->copy()->addMinutes(10);

        $assignments = Assignment::with([
            'junior',
            'chore',
        ])
        ->where('status', 0)
        // ->where('notification_sent', 0)
        // ->whereDate(
        //     'created_at',
        //     $now->toDateString()
        // )
        ->whereHas('schedule', function ($q) use ($today) {
            $q->where('schedule_date', $today);
        })
        ->get();

        foreach ($assignments as $assignment) {

            $startTime = Carbon::parse(
                $assignment->chore->start_time
            );

            $endTime = Carbon::parse(
                $assignment->chore->end_time
            );

            if (
                $startTime->between(
                    $now,
                    $notificationTime
                ) && $assignment->notification_sent == 0
            ) {

                $user = $assignment->junior->user;

                if (!$user) {
                    continue;
                }

                foreach ($user->fcmTokens as $fcmToken) {

                    $firebase->send(
                        $fcmToken->token,
                        $assignment->chore->chore_name,
                        'Your chore for today is "' .
                        $assignment->chore->chore_name .
                        '". Don\'t forget to complete it.'
                    );

                }

                $assignment->update([
                    'notification_sent' => 1,
                ]);
            }

            if (
                $endTime->isBefore(
                    $now
                )
            ) {

                $user = $assignment->junior->user;

                if (!$user) {
                    continue;
                }

                foreach ($user->fcmTokens as $fcmToken) {

                    $firebase->send(
                        $fcmToken->token,
                        $assignment->chore->chore_name,
                        'Your "' .
                        $assignment->chore->chore_name .
                        '" chore is overdue!'
                    );

                }
            }
        }

        // return Command::SUCCESS;
    }
}
