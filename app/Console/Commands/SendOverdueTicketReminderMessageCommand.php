<?php

namespace App\Console\Commands;

use App\Http\Controllers\CRM\CustomerTicketController;
use App\Models\CRM\CustomerTicket;
use App\Models\Message;
use App\Models\User;
use Illuminate\Console\Command;

class SendOverdueTicketReminderMessageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:overdue-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send overdue tickets reminder notification message';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $affected_rows = 0;
        $customerTicketController = new CustomerTicketController();
        $tickets = CustomerTicket::getCustomerTicketsByActiveStatus(0, 1);

        try {
            foreach ($tickets as $ticket) {
                $data = $customerTicketController->getTicketOverdueHours($ticket->ticket_id, $ticket->created_at);
                if (!empty($data)) {
                    $customerTicketController->sendOverdueTicketReminderMessage($ticket->ticket_id, $data['hours']);
                    $affected_rows = $affected_rows + 1;
                }
            }
        } catch (\Throwable $th) {
            file_put_contents(storage_path('logs/system_logs.txt'), $th . " \n", FILE_APPEND);
        }

        // Send communication officer message
        $messageModel = new Message();
        $defaultUser = CustomerTicket::defaultUser();
        $communicationMessage = 'a total of ' . $affected_rows . ' tickets are overdue as at ' . now();
        $messageModel->saveSystemMessage('Overdue Message Reminder', $defaultUser->mobile_no, $defaultUser->name, $communicationMessage, true);

        //Save audit trail
        $activity_type = 'Overdue Tickets Reminders';
        $description = 'Successfully sent overdue customer tickets reminders. ' . $affected_rows . ' records affected ';
        User::saveAutomaticAuditTrail($activity_type, $description);

        $this->info($description);
    }
}
