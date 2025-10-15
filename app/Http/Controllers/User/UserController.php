<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function UserLogout(Request $request) {
        Auth::guard('web')->logout(); 
        $request->session()->invalidate();  
        $request->session()->regenerateToken(); 
        return redirect('/login');
    }
     /// End Method 

     public function UserProfile(){
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('client.user_profile',compact('profileData'));

    }
     /// End Method 

        public function UserProfileStore(Request $request){
        $id = Auth::user()->id;
        $data = User::find($id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        $oldPhotPath = $data->photo;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('upload/admin_images'),$filename);
            $data->photo = $filename;

            if ($oldPhotPath && $oldPhotPath !== $filename) {
                $this->deleteOldImage($oldPhotPath);
            }            
        }

        $data->save();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }
    /// End Method 

    private function deleteOldImage(string $oldPhotPath): void {
        $fullPath = public_path('upload/admin_images/'.$oldPhotPath);
        if (file_exists($fullPath)) {
           unlink($fullPath);
        }
    }
     /// End Method 


      public function UserChangePassword(){
        return view('client.password_change');
     }
      /// End Method 

      public function UserPasswordUpdate(Request $request){
        $user = Auth::user();

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        if (!Hash::check($request->old_password ,$user->password )) {
           
            $notification = array(
            'message' => 'Old Password Does not Match!',
            'alert-type' => 'error'
            );

        return redirect()->back()->with($notification);
        }

        User::whereId($user->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        Auth::logout();

        $notification = array(
            'message' => 'Password Updated Successfully',
            'alert-type' => 'success'
            );

        return redirect()->route('login')->with($notification); 
      }
      /// End Method 


}
 