<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\CRM\TicketCategory;
use App\Models\User;
use Illuminate\Http\Request;

class TicketCategoryController extends Controller
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
            'title' => 'Ticket Categories',
            'categories' => TicketCategory::getCategories(),
        ];
        return view('crm.ticket_categories', $pageData);
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
            'category_name' => 'required|string',
            'message_template' => 'required|string',
        ]);

        $category = new TicketCategory();
        $category->category_name = $request->category_name;
        $category->message_template = $request->message_template;
        $category->save();

        //Save audit trail
        $activity_type = 'Ticket Category Creation';
        $description = 'Successfully created new ticket category '.$category->category_name;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Successfully created new ticket category '.$category->category_name);
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
        $category = TicketCategory::find($id);
        $category->category_name = $request->category_name;
        $category->message_template = $request->message_template;
        $category->save();

        //Save audit trail
        $activity_type = 'Ticket Category Updation';
        $description = 'Successfully created new ticket category '.$category->category_name;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Successfully updated ticket category '.$category->category_name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TicketCategory::destroy($id);
        
        //Save audit trail
        $activity_type = 'Ticket Category Deletion';
        $description = 'Deleted ticket category successfully of the id '.$id;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Deleted Ticket category successfully');
    }
}