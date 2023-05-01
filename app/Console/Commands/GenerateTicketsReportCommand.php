<?php

namespace App\Console\Commands;

use App\Models\CRM\CustomerTicket;
use App\Models\Message;
use App\Models\User;
use Illuminate\Console\Command;

class GenerateTicketsReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:tickets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate tickets report and send to email';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $date = date_create(date('Y-m-d'))->modify('-3 days')->format('Y-m-d');
        $yesterday = date_create(date('Y-m-d'))->modify('-1 days')->format('Y-m-d');

        $tickets_data = [
            'all_tickets' => CustomerTicket::getCustomerTicketsByDate($yesterday),
            'overdue_tickets' => CustomerTicket::getCustomerOverdueTicketsByDate($date),
            'closed_tickets' => CustomerTicket::getCustomerTicketsByStatusAndDate(1, $yesterday),
            'completed_surveys' => CustomerTicket::getSurveyDataByDate(1, $yesterday),
            'pending_surveys' => CustomerTicket::getSurveyDataByDate(0, $yesterday),
        ];

        //Send report to email
        $messageModel = new Message();
        $defaultUser = CustomerTicket::defaultUser();
        $emailSubject = 'Customer Tickets Report for ' . $yesterday;
        $messageModel->SendTicketsReportEmail($defaultUser->name, $defaultUser->office_email, $emailSubject, $emailSubject, $tickets_data);

        //Save audit trail
        $activity_type = 'Customer Tickets Report';
        $description = 'Successfully generated customer tickets report for ' . $yesterday;
        User::saveAutomaticAuditTrail($activity_type, $description);

        $this->info($description);
    }
}
