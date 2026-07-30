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

            if (
                $startTime->between(
                    $now,
                    $notificationTime
                )
            ) {

                $user = $assignment->junior->user;

                if (!$user) {
                    continue;
                }

                foreach ($user->fcmTokens as $fcmToken) {

                    $firebase->send(
                        $fcmToken->token,
                        'Upcoming Task',
                        'Your "' .
                        $assignment->chore->chore_name .
                        '" task starts in 10 minutes.'
                    );

                }

                $notification_sent = $assignment->notification_sent;
                $notification_sent++;

                $assignment->update([
                    'notification_sent' => $notification_sent,
                ]);
            }
        }

        // return Command::SUCCESS;
    }
}
