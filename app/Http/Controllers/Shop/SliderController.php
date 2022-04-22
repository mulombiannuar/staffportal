<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Slider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageData = [
			'page_name' => 'shop',
            'title' => 'Online Shop Sliders',
            'sliders' => Slider::orderBy('slider_id', 'desc')->get(),
        ];
        return view('shop.slider.index', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageData = [
			'page_name' => 'shop',
            'title' => 'Add New Shop Slider',
        ];
        return view('shop.slider.create', $pageData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // return $request;
        $request->validate([
            'title' => [
                'required', 
                'string', 
                'max:255'],
            'description' => [
                'required', 
                'string', 
                ],
            'image' => [
                'image', 
                'max:1999',
                'required',
                'dimensions:width=1366,height=800'],
            'link_text' => [
                'required',
              ],
            'link_url' => [
                'required', 
               ],
        ]);

        if($request->hasFile('image')) 
        {
            $fileNameWithExt = $request->file('image')->getClientOriginalName();

            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            
            $extension = $request->file('image')->getClientOriginalExtension();
            
            $sliderImage = $fileName.'_'.time().'.'.$extension;

            $request->file('image')->storeAs('public/assets/app/images/sliders', $sliderImage);
        }
        else
        {
            $sliderImage = 'motor.jpg';
        }

        $slider = new Slider();
        $slider->image = $sliderImage;
        $slider->title = $request->input('title');
        $slider->description= $request->input('description'); 
        $slider->link_text = $request->input('link_text');
        $slider->link_url = $request->input('link_url');
        $slider->user_id = Auth::user()->id;
        $slider->save();

        //Save audit trail
        $activity_type = 'New Slider Creation';
        $description = 'Successfully Created slider '.$slider->title;
        User::saveAuditTrail($activity_type, $description);
        
        return redirect(route('shop.sliders.index'))->with('success', 'Slider data saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pageData = [
			'page_name' => 'shop',
            'title' => 'Slider Details',
            'slider' => Slider::find($id)
        ];
        return view('shop.slider.show', $pageData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageData = [
			'page_name' => 'shop',
            'title' => 'Slider Details',
            'slider' => Slider::find($id)
        ];
        return view('shop.slider.edit', $pageData);
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
        // return $request;
        $request->validate([
            'title' => [
                'required', 
                'string', 
                'max:255'],
            'description' => [
                'required', 
                'string', 
                ],
            'image' => [
                'image', 
                'max:1999',
                'nullable',
                'dimensions:width=1366,height=800'],
            'link_text' => [
                'required',
              ],
            'link_url' => [
                'required', 
               ],
        ]);
        
        $slider = Slider::find($id);
        if($request->hasFile('image')) 
        {
             Storage::delete('public/assets/app/images/sliders/'.$slider->image);

            $fileNameWithExt = $request->file('image')->getClientOriginalName();

            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            
            $extension = $request->file('image')->getClientOriginalExtension();
            
            $sliderImage = $fileName.'_'.time().'.'.$extension;

            $request->file('image')->storeAs('public/assets/app/images/sliders', $sliderImage);
        }
        else
        {
            $sliderImage = $slider->image;
        }
        $slider->image = $sliderImage;
        $slider->title = $request->input('title');
        $slider->description= $request->input('description'); 
        $slider->link_text = $request->input('link_text');
        $slider->link_url = $request->input('link_url');
        $slider->save();

        //Save audit trail
        $activity_type = 'Slider Updation';
        $description = 'Successfully Updated slider '.$slider->title;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('shop.sliders.index'))->with('success', 'Slider data saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::find($id);

        //Save audit trail
        $activity_type = 'Slider Deletion';
        $description = 'Successfully deleted slider '.$slider->title;
        User::saveAuditTrail($activity_type, $description);

        Storage::delete('public/assets/app/images/sliders/'.$slider->image);
        $slider->delete();
        return back()->with('success', 'Slider deleted successfully');
    }

    public function publishSlider(Slider $slider)
    {
        $slider->status = 1;
        $slider->save();

        //Save audit trail
        $activity_type = 'Slider Publishing';
        $description = 'Successfully published slider '.$slider->title;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Slider published successfully');  
    }

     public function unPublishSlider(Slider $slider)
    {
        $slider->status = 0;
        $slider->save();

        //Save audit trail
        $activity_type = 'Slider Unpublishing';
        $description = 'Successfully unpublished slider '.$slider->title;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Slider unpublished successfully');  
    }
}