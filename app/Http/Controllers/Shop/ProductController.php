<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Shop\Category;
use App\Models\Shop\Product;
use App\Models\Shop\ProductImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
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
            'title' => 'Motorbikes for Disposal',
            'products' => Product::getProducts(),
        ];
        return view('shop.product.index', $pageData);
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
            'title' => 'Add New Motorbike',
            'categories' => Category::getCategories(),
            'branches' => Admin::getBranches(),
            'types' => Admin::getMotorTypes(),
            'user' => User::getUserById(Auth::user()->id),
        ];
        return view('shop.product.create', $pageData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;
        $request->validate([
            'outpost_id' => [
                'required', 
                'integer', 
            ],
            'branch' => [
                'required',
                'integer',
            ],
            'user_id' => [
                'required',
                'integer',
            ],
            'category' => [
                'required',
                'integer',
            ],
            'name' => [
                'required',
                'string',
            ],
            'chassis_number' => [
                'required',
                'string',
            ],
            'reg_no' => [
                'required',
                'string',
            ],
            'mileage' => [
                'required',
                'numeric',
            ],
            'type' => [
                'required',
                'string',
            ],
            'color' => [
                'required',
                'string',
            ],
            'engine' => [
                'required',
                'string',
            ],
            'client_name' => [
                'required',
                'string',
            ],
            'client_id' => [
                'required',
                'numeric',
                'digits:7'
            ],
            'condition' => [
                'required',
                'string',
            ],
            'location' => [
                'required',
                'string',
            ],
            'mobile_no' => [
                'required',
                'numeric',
                'digits:10'
            ],
            'loan_amount' => [
                'required',
                'string',
            ],
            'principal_amount' => [
                'required',
                'string',
            ],
            'loan_balance' => [
                'required',
                'string',
            ],
            'date_purchased' => [
                'required',
                'string',
            ],
            'purchase_price' => [
                'required',
                'string',
            ],
            'disposal_price' => [
                'required',
                'string',
            ],
            'additional_info' => [
                'required',
                'string',
            ],
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if($request->hasFile('image')) 
        {
            $image = $request->file('image');

            $fileNameWithExt = $image->getClientOriginalName();

            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            
            $extension = $image->getClientOriginalExtension();

            $input['file'] = $fileName.'_'.time().'.'.$extension;;
            
            $destinationPath = public_path('/storage/assets/app/images/products');

            $imgFile = Image::make($image->getRealPath());

            $imgFile->resize(800, 500, function ($constraint) {
                $constraint->aspectRatio();

            })->save($destinationPath.'/'.$input['file']);
            
            $destinationPath = public_path('/storage/assets/app/images/thumbnails');

            $image->move($destinationPath, $input['file']);
        }
        else
        {
            $input['file'] = 'motor.jpg';
        }

        $product = new Product();
        $product->images = $input['file'];
        $product->product_name = $request->input('name');
        $product->officer = $request->input('user_id');
        $product->chassis_number = $request->input('chassis_number');
        $product->mileage = $request->input('mileage');
        $product->category = $request->input('category');
        $product->type = $request->input('type');
        $product->color = $request->input('color');
        $product->outpost = $request->input('outpost_id');
        $product->engine = $request->input('engine');
        $product->condition = $request->input('condition');
        $product->reg_no = $request->input('reg_no');
        $product->purchase_price = $request->input('purchase_price');
        $product->disposal_price = $request->input('disposal_price');
        $product->location = $request->input('location');
        $product->date_purchased = $request->input('date_purchased');
        $product->additional_info = $request->input('additional_info');
        $product->client_name = $request->input('client_name');
        $product->client_id = $request->input('client_id');
        $product->mobile_no = $request->input('mobile_no');
        $product->loan_amount = $request->input('loan_amount');
        $product->principal_amount = $request->input('principal_amount');
        $product->loan_balance = $request->input('loan_balance');
        $product->slug = SlugService::createSlug(Product::class, 'slug', $request->input('name'));
        $product->created_by = Auth::user()->id;
        $product->save();

        //Save audit trail
        $activity_type = 'Shop Product Creation';
        $description = 'Successfully created new shop product '.$product->product_name;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('shop.products.show', $product->product_id))->with('success', 'You have successfully added new product. Proceed to add images for this product');
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
            'title' => 'Product Details',
            'product' => Product::getProductById($id),
            'images' => Product::find($id)->productImages
        ];
        return view('shop.product.show', $pageData);
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
            'title' => 'Edit Product Details',
            'product' => Product::getProductById($id),
            'categories' => Category::getCategories(),
            'branches' => Admin::getBranches(),
            'types' => Admin::getMotorTypes()
        ];
        return view('shop.product.edit', $pageData);
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
        //return $request;
        $request->validate([
            'outpost_id' => [
                'required', 
                'integer', 
            ],
            'branch' => [
                'required',
                'integer',
            ],
            'user_id' => [
                'required',
                'integer',
            ],
            'category' => [
                'required',
                'integer',
            ],
            'name' => [
                'required',
                'string',
            ],
            'chassis_number' => [
                'required',
                'string',
            ],
            'reg_no' => [
                'required',
                'string',
            ],
            'mileage' => [
                'required',
                'numeric',
            ],
            'type' => [
                'required',
                'string',
            ],
            'color' => [
                'required',
                'string',
            ],
            'engine' => [
                'required',
                'string',
            ],
            'client_name' => [
                'required',
                'string',
            ],
            'client_id' => [
                'required',
                'numeric',
                'digits:7'
            ],
            'condition' => [
                'required',
                'string',
            ],
            'location' => [
                'required',
                'string',
            ],
            'mobile_no' => [
                'required',
                'numeric',
                'digits:10'
            ],
            'loan_amount' => [
                'required',
                'string',
            ],
            'principal_amount' => [
                'required',
                'string',
            ],
            'loan_balance' => [
                'required',
                'string',
            ],
            'date_purchased' => [
                'required',
                'string',
            ],
            'purchase_price' => [
                'required',
                'string',
            ],
            'disposal_price' => [
                'required',
                'string',
            ],
            'additional_info' => [
                'required',
                'string',
            ],
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $product = Product::find($id);

        if($request->hasFile('image')) 
        {
            Storage::delete('public/assets/app/images/products/'.$product->images);
            Storage::delete('public/assets/app/images/thumbnails/'.$product->images);

            $image = $request->file('image');

            $fileNameWithExt = $image->getClientOriginalName();

            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            
            $extension = $image->getClientOriginalExtension();

            $input['file'] = $fileName.'_'.time().'.'.$extension;;
            
            $destinationPath = public_path('/storage/assets/app/images/products');

            $imgFile = Image::make($image->getRealPath());

            $imgFile->resize(800, 500, function ($constraint) {
                $constraint->aspectRatio();

            })->save($destinationPath.'/'.$input['file']);
            
            $destinationPath = public_path('/storage/assets/app/images/thumbnails');

            $image->move($destinationPath, $input['file']);
        }
        else
        {
            $input['file'] =  $product->images ;
        }

        $product->images = $input['file'];
        $product->product_name = $request->input('name');
        $product->officer = $request->input('user_id');
        $product->chassis_number = $request->input('chassis_number');
        $product->mileage = $request->input('mileage');
        $product->category = $request->input('category');
        $product->type = $request->input('type');
        $product->color = $request->input('color');
        $product->outpost = $request->input('outpost_id');
        $product->engine = $request->input('engine');
        $product->condition = $request->input('condition');
        $product->reg_no = $request->input('reg_no');
        $product->purchase_price = $request->input('purchase_price');
        $product->disposal_price = $request->input('disposal_price');
        $product->location = $request->input('location');
        $product->date_purchased = $request->input('date_purchased');
        $product->additional_info = $request->input('additional_info');
        $product->client_name = $request->input('client_name');
        $product->client_id = $request->input('client_id');
        $product->mobile_no = $request->input('mobile_no');
        $product->loan_amount = $request->input('loan_amount');
        $product->principal_amount = $request->input('principal_amount');
        $product->loan_balance = $request->input('loan_balance');
        $product->slug = SlugService::createSlug(Product::class, 'slug', $request->input('name'));
        $product->save();

        //Save audit trail
        $activity_type = 'Shop Product Updation';
        $description = 'Successfully updated shop product '.$product->product_name;
        User::saveAuditTrail($activity_type, $description);

        ##return back()->with('success', 'You have successfully updated product details');
        return redirect(route('shop.products.index', $product->product_id))->with('success', 'YYou have successfully updated product details');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ProductImage::where('product_id', $id)->delete();
        $product = Product::find($id);

        //Save audit trail
        $activity_type = 'Product Deletion';
        $description = 'Successfully deleted product '.$product->product_name;
        User::saveAuditTrail($activity_type, $description);

        Storage::delete('public/assets/app/images/products/'.$product->images);
        Storage::delete('public/assets/app/images/thumbnails/'.$product->images);
        $product->delete();
        return back()->with('success', 'Product data deleted successfully');
    }

    public function publishproduct(Product $product)
    {
        $product->status = 1;
        $product->save();

        //Save audit trail
        $activity_type = 'Product Publishing';
        $description = 'Successfully published product '.$product->product_name;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Product published successfully');  
    }

    public function unPublishProduct(Product $product)
    {
        $product->status = 0;
        $product->save();

        //Save audit trail
        $activity_type = 'Product Unpublishing';
        $description = 'Successfully unpublished product '.$product->product_name;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Product unpublished successfully');  
    }

    public function saveProductImage(Request $request)
    {
        $request->validate([
            'product_id' => [
                'required', 
                'integer', 
            ],
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if($request->hasFile('image')) 
        {
            $image = $request->file('image');

            $fileNameWithExt = $image->getClientOriginalName();

            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            
            $extension = $image->getClientOriginalExtension();

            $input['file'] = $fileName.'_'.time().'.'.$extension;;
            
            $destinationPath = public_path('/storage/assets/app/images/products');

            $imgFile = Image::make($image->getRealPath());

            $imgFile->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();

            })->save($destinationPath.'/'.$input['file']);
            
            $destinationPath = public_path('/storage/assets/app/images/thumbnails');

            $image->move($destinationPath, $input['file']);
        }
        else
        {
            $input['file'] = 'motor.jpg';
        }

        $image = new ProductImage();
        $image->image = $input['file'];
        $image->product_id = $request->input('product_id');
        $image->created_by = Auth::user()->id;
        $image->save();

        //Save audit trail
        $activity_type = 'Product Image Creation';
        $description = 'Successfully added new shop product image';
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'You have successfully added new product');
    }

    public function deleteProductImage($id)
    {
        $image = ProductImage::find($id);

        //Save audit trail
        $activity_type = 'Product Image Deletion';
        $description = 'Successfully deleted product image';
        User::saveAuditTrail($activity_type, $description);

        Storage::delete('public/assets/app/images/products/'.$image->image);
        Storage::delete('public/assets/app/images/thumbnails/'.$image->image);
        $image->delete();
        return back()->with('success', 'Product image data deleted successfully');
    }
}