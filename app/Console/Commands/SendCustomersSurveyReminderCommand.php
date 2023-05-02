<?php

namespace App\Console\Commands;

use App\Models\CRM\CRMCustomer;
use App\Models\CRM\CustomerTicket;
use App\Models\Message;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendCustomersSurveyReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:customers-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send customers survey reminders sms';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tickets = DB::table('customer_tickets')
            ->join('ticket_survey', 'ticket_survey.ticket_id', '=', 'customer_tickets.ticket_id')
            ->where('reminder_count', '<', 3)
            ->where([
                'ticket_closed' => 1,
                'customer_sent_survey' => 1,
                'customer_responded_survey' => 0,
            ])->get();

        if ($tickets) {
            foreach ($tickets as $ticket) {
                //Send customer notification sms
                $customerData = CRMCustomer::find($ticket->customer_id);
                CustomerTicket::sendCustomerReminder($ticket->ticket_id, $customerData, $ticket->survey_message);
            }
        }

        // Send communication officer message
        $messageModel = new Message();
        $defaultUser = CustomerTicket::defaultUser();
        $communicationMessage = 'a total of ' . count($tickets) . ' reminders sent to customers today at ' . now();
        $messageModel->saveSystemMessage('Customers Survey Reminders', $defaultUser->mobile_no, $defaultUser->name, $communicationMessage, true);

        //Save audit trail
        $activity_type = 'Customers Survey Reminders';
        $description = 'Successfully customers tickets reminders notifications. ' . count($tickets) . ' records affected ';
        User::saveAutomaticAuditTrail($activity_type, $description);

        $this->info($description);
    }
}
