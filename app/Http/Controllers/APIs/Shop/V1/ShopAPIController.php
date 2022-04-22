<?php

namespace App\Http\Controllers\APIs\Shop\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCart;
use App\Http\Requests\PlaceBid;
use App\Http\Requests\SaveUserContact;
use App\Http\Requests\SearchProductByQuery;
use App\Http\Requests\Subscriber;
use App\Http\Resources\V1\BidResource;
use App\Http\Resources\V1\CartResource;
use App\Http\Resources\V1\ProductImageResurce;
use App\Http\Resources\V1\ProductResource;
use App\Http\Resources\V1\SliderResource;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use App\Models\Message;
use App\Models\Shop\Cart;
use App\Models\Shop\Category;
use App\Models\Shop\Contact;
use App\Models\Shop\Order;
use App\Models\Shop\Product;
use App\Models\Shop\Slider;
use App\Models\Shop\Subscriber as ShopSubscriber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ShopAPIController extends Controller
{
    public function getAllCategories()
    {
        return Category::getCategories();
    }

    public function getAllProducts()
    {
        return ProductResource::collection(Product::getProductsByStatus(1));
    }

    public function getProductBySlug($slug)
    {
        //return Product::getProductBySlug($slug);
        return ProductResource::collection(Product::getProductBySlug($slug));
    }

    public function getProductsByCategory($category)
    {
        return ProductResource::collection(Product::getProductsByCategory($category));
    }

    public function getAllSliders()
    {
        return SliderResource::collection(Slider::where('status', 1)->get());
    }

    public function getCounties()
    {
        return DB::table('counties')->orderBy('county_name', 'asc')->get();
    }

    public function searchProductByQuery(Request $request, $query)
    {
        return ProductResource::collection(Product::searchProductByQuery($query));
    }
    
    public function getProductImages($id)
    {
        $product = Product::find($id);
        return ProductImageResurce::collection($product->productImages);
    }

    public function saveUserContact(SaveUserContact $request)
    {
        //return 'Contact saved successfully';
        $message = new Message();
        $email = 'ictsupport@bimaskenya.com';
        $name = 'Bimas Customer Care';
        $contact = Contact::create($request->all());
        $contactMessage = 'Here is the contact message for '.strtoupper($contact->name).'('.strtolower($contact->email).') : '.$contact->message;

        // Send email to bimas emails including branch one
        $message->SendSystemEmail($name, $email, $contactMessage, $contact->subject);
        
        return Response::json([
            'status'  => 200,
            'message'  => 'success',
        ]);
    }

    public function addToCart(AddToCart $request)
    {
        $product = Cart::where([
            'product_id' => $request->product_id, 
            'customer_id' => $request->customer_id
        ])->first();

        if ($product) { return $product; }

        //Cart::create($request->all())
        return DB::table('carts')->insert([
            'product_id' => $request->input('product_id'),
            'customer_name' => $request->input('customer_name'),
            'customer_id' => $request->input('customer_id'),
            'customer_mobile' => $request->input('customer_mobile'),
            'bid_amount' => $request->input('bid_amount'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]) ;
    }

    public function removeFromCart($id)
    {
        DB::table('carts')->where('cart_id', $id)->delete();
        return Response::json([
            'status'  => 200,
            'message'  => 'success',
        ]);
    }

    public function getUserCart($user_id)
    {
        $userCarts = CartResource::collection(Cart::getUserCart($user_id, 0));;
        $cartSum = Cart::getUserCartTotalSum($user_id, 0);
        return  [
            'data' => $userCarts,
            'cartSum' => $cartSum
        ];
    }

    public function placeBid(PlaceBid $request)
    {
        //return $request;
        $carts = $request->input('carts');
        for ($s=0; $s <count($carts) ; $s++) 
        { 
            DB::table('carts')->where('cart_id', $carts[$s])->update(['status' => 1]);
            DB::table('orders')->insert([
                'cart_id' => $carts[$s],
                'bid_number' => Admin::getRandomNumbers(1000000,9999999),
                'customer_id' => $request->input('user_id'),
                'location' => $request->input('location'),
                'city' => $request->input('city'),
                'county' => $request->input('county'),
                'payment' => $request->input('payment'),
                'outpost' => Product::find(Cart::find($carts[$s])->product_id)->outpost,
                'date' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        $message = new Message();
        $email = 'ictsupport@bimaskenya.com';
        $name = 'Bimas Customer Care';
        $subject = 'New Customer Bidding Order';
        $contactMessage = 'New bidding order has been successfully placed by customer id '.$request->input('user_id');

        // Send email to bimas emails including branch one
        $message->SendSystemEmail($name, $email, $contactMessage, $subject);

        return Response::json([
            'status'  => 200,
            'message'  => 'success',
        ]);
    }

    public function getUserBids($user_id)
    {
        return BidResource::collection(Order::getUserBids($user_id));
    }

    public function getBidById($id)
    {
        return BidResource::collection(Order::getBidById($id));
    }

    public function subscribe(Subscriber $request)
    {
        $subscriber = DB::table('subscribers')->where('email', $request->email)->first();
        
        if(empty($subscriber)){
            DB::table('subscribers')->insert([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
       
        return Response::json([
            'status'  => 200,
            'message'  => 'success',
        ]);
    }

}