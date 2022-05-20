<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Shop\Category;
use App\Models\Shop\Contact;
use App\Models\Shop\Order;
use App\Models\Shop\Product;
use App\Models\Shop\Slider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index()
    {
      //return $this->getUsersData()->count; 
      $pageData = [
         'title' => 'Bimas Online Shop',
         'page_name' => 'shop',
         'stats' => [
           'users' => 0,
           'messages' => Contact::count(),
           'orders' => Order::count(),
           'products' => Product::count(),
           'sliders' => Slider::count(),
           'categories' => Category::count(),
         ],
       ];
       return view('shop.index', $pageData);
    }

    public function messages()
    {
        $pageData = [
          'page_name' => 'shop',
          'title' => 'Shop Visitors Messages',
          'contacts'=> Contact::getContacts(),
        ];
        return view('shop.messages', $pageData);
    }

    public function orders()
    {
       //return Order::getDistinctUserBids();  
       $pageData = [
              'page_name' => 'shop',
              'title' => 'Motorbike Bidding Orders',
              'products' => Order::getDistinctUserBids(),
              'user' => User::getUserById(Auth::user()->id),
          ];
        return view('shop.order.index', $pageData);
    }

    public function ordersByProductId($product_id)
    {
      //return Order::getBidsByProduct($product);
      $product = Product::find($product_id) ;
      $pageData = [
              'page_name' => 'shop',
              'title' =>ucwords($product->reg_no) . ' - ' . ucwords($product->product_name),
              'products' => Order::getBidsByProduct($product_id),
          ];
        return view('shop.order.product_bids', $pageData);
    }

    public function getOrderById($id)
    {
        $pageData = [
            'page_name' => 'shop',
            'title' => 'User Bidding Orders',
            'product' => Order::getBidById($id)[0],
        ];
        return view('shop.order.show', $pageData);
    }

    public function users()
    {
      //$usersData = $this->getUsersData();
      $pageData = [
        'page_name' => 'shop',
        'title' => 'User Registrations',
        'users' => []
      ];
      return view('shop.users', $pageData);
    }

    public function getUsersData()
    {
      $remote_url = env('REMOTE_URL');
      $client = new Client(); 
      $url = $remote_url."api/shop/v1/get-users";
      
      $response = $client->request('GET', $url, [
          'verify' => false,
          'headers' => [
            'Content-Type' => 'application/json', 
            'Accept' => 'application/json'
          ],
      ]);
      
      $responseBody = json_decode($response->getBody());

      return $responseBody;
    }
}