<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\CRM\TicketSource;
use App\Models\User;
use Illuminate\Http\Request;

class TicketSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageData = [
			'page_name' => 'crm',
            'title' => 'Ticket Sources',
            'sources' => TicketSource::getSources(),
        ];
        return view('crm.ticket_sources', $pageData);
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'source_name' => 'required|string',
            //'message_template' => 'required|string',
        ]);

        $source = new TicketSource();
        $source->source_name = $request->source_name;
        $source->save();

        //Save audit trail
        $activity_type = 'Ticket Source Creation';
        $description = 'Successfully created new ticket source '.$source->source_name;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Successfully created new ticket source '.$source->source_name);
    }

 
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'source_name' => 'required|string',
            //'message_template' => 'required|string',
        ]);

        $source = TicketSource::find($id);
        $source->source_name = $request->source_name;
        $source->save();

        //Save audit trail
        $activity_type = 'Ticket Source Updation';
        $description = 'Successfully Updated ticket source '.$source->source_name;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Successfully updated ticket source '.$source->source_name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TicketSource::destroy($id);
        
        //Save audit trail
        $activity_type = 'Ticket Source Deletion';
        $description = 'Deleted ticket Source successfully of the id '.$id;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Deleted Ticket Source successfully');
    }
}
