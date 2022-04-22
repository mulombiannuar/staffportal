<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
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
            'title' => 'Product Categories',
            'categories' => Category::getCategories(),
        ];
        return view('shop.categories', $pageData);
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
            'image' => [
                'image', 
                'max:1999',
                'required',
                'dimensions:width=800,height=500'],
        ]);

        if($request->hasFile('image')) 
        {
            $fileNameWithExt = $request->file('image')->getClientOriginalName();

            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            
            $extension = $request->file('image')->getClientOriginalExtension();
            
            $categoryImage = $fileName.'_'.time().'.'.$extension;

            $request->file('image')->storeAs('public/assets/app/images/products', $categoryImage);
        }
        else
        {
            $categoryImage = 'motor.jpg';
        }

        DB::table('categories')->insert([
            'image' => $categoryImage,
            'name' => $request->input('name'),
            'created_at' => Carbon::now()
        ]);

        //Save audit trail
        $activity_type = 'New Category Creation';
        $description = 'Successfully Created category '.$request->input('name');
        User::saveAuditTrail($activity_type, $description);
        
        return back()->with('success', 'Category data saved successfully');
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
            'image' => [
                'image', 
                'max:1999',
                'required',
                'dimensions:width=800,height=500'],
        ]);
        
        $category = Category::find($id);

        if($request->hasFile('image')) 
        {
            Storage::delete('public/assets/app/images/products/'.$category->image);

            $fileNameWithExt = $request->file('image')->getClientOriginalName();

            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            
            $extension = $request->file('image')->getClientOriginalExtension();
            
            $categoryImage = $fileName.'_'.time().'.'.$extension;

            $request->file('image')->storeAs('public/assets/app/images/products', $categoryImage);
        }
        else
        {
            $categoryImage = $category->image;
        }

        
        DB::table('categories')->where('category_id', $id)->update([
            'name' => $request->input('name'),
            'updated_at' => Carbon::now(),
            'image' => $categoryImage,
        ]);

         //Save audit trail
         $activity_type = 'Category Updation';
         $description = 'Successfully updated Category '.$request->input('name');
         User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Category data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        //Save audit trail
        $activity_type = 'Category Deletion';
        $description = 'Successfully deleted category '.$category->name;
        User::saveAuditTrail($activity_type, $description);

        $category->delete();
        return back()->with('success', 'Category deleted successfully');
    }
}