<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\CvpPackage;
use App\Models\PaidPackage;
use App\Models\StaffPackage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CVPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return CvpPackage::getProductsDetails();
        $pageData = [
			'page_name' => 'packages',
            'title' => 'Staff CVP Packages',
            'products' => CvpPackage::getProductsDetails(),
        ];
        return view('admin.packages.index', $pageData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($product_id)
    {
        //Get beneficiaries by product id and branch id
        
        $cvp = new CvpPackage();
        $pageData = [
			'page_name' => 'packages',
            'title' => 'Create User CVP Package',
            'branches' => Admin::getBranches(),
            'packages' =>  $cvp->getProductPackages($product_id),
            'product' => DB::table('cvp_products')->where('product_id', $product_id)->first()
        ];
        return view('admin.packages.create', $pageData);
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
            'user_id' => [
                'required', 
                'integer', 
            ],
            'package' => [
                'required',
                'integer',
            ],
            'product' => [
                'required',
                'integer',
            ],
        ]);

        $product = $request->input('product');
        $user_id = $request->input('user_id');
        $user_exists = StaffPackage::where(['user_id' => $user_id, 'product' => $product])->first();

        if($user_exists)
        return redirect(route('admin.packages.index'))->with('danger', 'This user already exists in this list of package');
        
        //return $request;
        $package = new StaffPackage();
        $package->product = $product;
        $package->user_id = $user_id;
        $package->package = $request->input('package');
        $package->created_by = Auth::user()->id;
        $package->save();

        //Save audit trail
        $activity_type = 'Staff Package Creation';
        $description = 'Successfully created new CVP Staff Package for user id '. $package->user_id;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.packages.index'))->with('success', 'Successfully created new Staff CVP Package for the selected user ');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cvp = new CvpPackage();
        $package = StaffPackage::getPackageById($id);
        $pageData = [
            'packageData' => $package,
			'page_name' => 'packages',
            'title' => 'User CVP Package',
            'branches' => Admin::getBranches(),
            'packages' =>  $cvp->getProductPackages($package->product),
            'product' => DB::table('cvp_products')->where('product_id', $package->product)->first()
        ];
        return view('admin.packages.edit', $pageData);
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
            'package' => [
                'required',
                'integer',
            ],
        ]);
        //return $request;
        $package = StaffPackage::find($id);
        $package->package = $request->input('package');
        $package->save();

        //Save audit trail
        $activity_type = 'Staff Package Updation';
        $description = 'Successfully created updated CVP Staff Package of id '. $id;
        User::saveAuditTrail($activity_type, $description);

        return redirect(route('admin.packages.index'))->with('success', 'Successfully updated Staff CVP Package for the selected user ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PaidPackage::where('staff_id', $id)->delete();
        StaffPackage::find($id)->delete();

        //Save audit trail
        $activity_type = 'Staff Package Deletion';
        $description = 'Deleted Staff CVP Package successfully';
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Deleted CVP Package successfully');
    }

    ///////////CVP Pacckages
    public function packages()
    {
        $pageData = [
			'page_name' => 'packages',
            'title' => 'Safaricom CVP Packages',
            'products' => Admin::getCvpProducts(),
            'packages' => CvpPackage::getPackages()
        ];
        return view('admin.packages.packages', $pageData);
    }

    public function storePackage(Request $request)
    {
        $request->validate([
            'value' => [
                'required', 
                'string', 
            ],
            'amount' => [
                'required',
                'numeric',
            ],
            'product' => [
                'required',
                'integer',
            ],
        ]);
        //return $request;
        $package = new CvpPackage();
        $package->product = $request->input('product');;
        $package->value = $request->input('value');
        $package->amount = $request->input('amount');
        $package->created_by = Auth::user()->id;
        $package->save();

        //Save audit trail
        $activity_type = 'Package Creation';
        $description = 'Successfully created new CVP Package of value '. $package->value;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Successfully created new CVP Package of value '. $package->value);
    }

    public function updatePackage(Request $request, $id)
    {
        $request->validate([
            'value' => [
                'required', 
                'string', 
            ],
            'amount' => [
                'required',
                'numeric',
            ],
        ]);
        //return $request;
        $package = CvpPackage::find($id);
        $package->value = $request->input('value');
        $package->amount = $request->input('amount');
        $package->created_by = Auth::user()->id;
        $package->save();

        //Save audit trail
        $activity_type = 'Package Updation';
        $description = 'Successfully updated CVP Package of value '. $package->value;
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Successfully updated CVP Package of value '. $package->value);
    }

    public function destroyPackage($id)
    {
        CvpPackage::find($id)->delete();

        //Save audit trail
        $activity_type = 'Package Deletion';
        $description = 'Deleted CVP Package successfully';
        User::saveAuditTrail($activity_type, $description);

        return back()->with('success', 'Deleted CVP Package successfully');
    }
}