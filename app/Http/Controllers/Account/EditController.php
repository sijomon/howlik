<?php
namespace App\Http\Controllers\Account;
use App\Larapen\Models\User;
use App\Http\Controllers\FrontController;
use Auth;
use Input;
use Validator;
use Response;
use Illuminate\Http\Request;
use Hash;
class EditController extends AccountBaseController
{
    public function details(Request $request)
    {
		//echo '<pre>';print_r($_POST);die;
        // Check if email has changed
        $email_changed = ($request->input('email') != $this->user->email);
        
        // validation
        $this->validate($request, [
            'gender' => 'required|not_in:0',
            'name' => 'required|max:100',
            /*'about' => 'required|max:200',*/
            'phone' => 'required|max:60',
            'email' => ($email_changed) ? 'required|email|unique:users,email' : 'required|email',
        ]);
        
        // update
        $user = User::find($this->user->id);
        $user->gender_id = $request->input('gender');
        $user->name = $request->input('name');
        $user->about = $request->input('about');
        $user->country_code = $request->input('country');
        $user->phone = $request->input('phone');
        $user->phone_hidden = $request->input('phone_hidden');
        $user->about = $request->input('about');
        if ($email_changed) {
            $user->email = $request->input('email');
        }
        $user->receive_newsletter = $request->input('receive_newsletter');
        $user->receive_advice = $request->input('receive_advice');
        $user->save();
        
        flash()->success(t("Your account details has updated successfully."));
        
        return redirect($this->lang->get('abbr') . '/account/edit');
    }
    
    public function settings(Request $request)
    {
        // validation
        $this->validate($request, [
        
            'password_current' => 'required|between:5,15',
            'password' => 'required|between:5,15|confirmed',
            'password_confirmation' => 'required|between:5,15',
        ]);
        
        // update
        $user = User::find($this->user->id);
		$user->comments_enabled = (int)$request->input('comments_enabled');
        
		if (Hash::check($request->input('password_current'), $user->password))
		{
			if ($request->has('password')) {
				
				$user->password = bcrypt($request->input('password'));
			}
			$user->save();
			
			flash()->success(t("Your account settings has updated successfully."));
			
        } else {
			
			flash()->error(t("The Current Password don't match."));
		}
        
        return redirect($this->lang->get('abbr') . '/account/edit');
    }
	
	public function dp_update(Request $request)
    {
		// validation 
        $this->validate($request, [
            'picture' => 'required|mimes:jpeg,bmp,png|max:5000'
        ]);
		
		$file = $request->file('picture');
		
		if($request->hasFile('picture')) {			
			
			$destinationPath	= public_path().'/uploads/pictures/dp'; // upload path
			$extension			= $file->getClientOriginalExtension(); // getting file extension
			$fileName			= time() . '.' . $extension; // renameing image
			$upload_success		= $file->move($destinationPath, $fileName); // uploading file to given path.
			
			// update
			$user = User::find($this->user->id);
			
			$user->photo	= $fileName;
			
			$user->save();
		}
        
        flash()->success(t("Your profile picture has updated successfully."));
        
        return redirect($this->lang->get('abbr') . '/account/edit');
        
    }
	
	public function dp_delete(Request $request)
    {
		// remove
		$user = User::find($this->user->id);
		$user->photo = '';
		$user->save();
		return response()->json('success');
    }
	
	public function in_settings(Request $request)
    {
        // update
		$user = User::find($this->user->id);
        $user->interests = serialize($request->input('interests'));
        $user->save();
        
        flash()->success(t("Your interest settings has updated successfully."));
        
        return redirect($this->lang->get('abbr') . '/account/edit');
    }
	
	public function pr_settings(Request $request)
    {
        // update
        $user = User::find($this->user->id);
        $user->find_friends = (int)$request->input('find_friends');
		$user->direct_messages = (int)$request->input('direct_messages');
		$user->profile_view = (int)$request->input('profile_view');
        $user->save();
        
        flash()->success(t("Your privacy settings has updated successfully."));
        
        return redirect($this->lang->get('abbr') . '/account/edit');
    }
	
	public function en_settings(Request $request)
    {
        // update
        $user = User::find($this->user->id);
        $email_notificationsA['receive_emails'] = (int)$request->input('receive_emails');
		$email_notificationsA['friend_requests'] = (int)$request->input('friend_requests');
		$email_notificationsA['messages'] = (int)$request->input('messages');
		$email_notificationsA['order_updates'] = (int)$request->input('order_updates');
		$email_notificationsA['disc_promo'] = (int)$request->input('disc_promo');
		$user->email_notifications = serialize($email_notificationsA);
        $user->save();
        
        flash()->success(t("Your email notification settings has updated successfully."));
        
        return redirect($this->lang->get('abbr') . '/account/edit');
    }
    
    public function preferences()
    {
        $data = [];
        
        return view('classified.account/home', $data);
    }
}
