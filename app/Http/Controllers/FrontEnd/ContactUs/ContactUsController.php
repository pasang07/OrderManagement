<?php

namespace App\Http\Controllers\FrontEnd\ContactUs;

use App\Http\Requests\FrontEnd\ContactUs\ContactUsRequest;
use App\Models\Model\SuperAdmin\Contact\Contact;
use App\Models\Model\SuperAdmin\Seo\Seo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class ContactUsController extends Controller
{
    public function index()
    {
        $data['model'] = Seo::where('slug', 'contact-us')->first();
        if($data['model']) {
            $data['meta_title'] = $data['model']->seo_title ? $data['model']->seo_title : $data['model']->title;
            $data['meta_keywords'] = $data['model']->seo_keywords;
            $data['meta_description'] = $data['model']->seo_description;
        }
        return view('front-end.contact-us.index',$data);
    }
    public function mail(ContactUsRequest $request)
    {
        $data=array(
            'name'=>$request->name,
            'from'=>$request->contact_email,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'subject'=>$request->subject,
            'content'=>$request->message,
        );
//        dd($data);
        $contactDetails = new Contact();
        $contactDetails->name = $request->name;
        $contactDetails->email = $request->contact_email;
        $contactDetails->phone = $request->phone;
        $contactDetails->address = $request->address;
        $contactDetails->subject = $request->subject;
        $contactDetails->content = $request->message;

        if($contactDetails->save()){
            Mail::send('emails.contact-mail',$data,function ($message) use ($data){
                $message->from($data['from']);
                $message->to(SITE_MAIL_EMAIL);
//                $message->bcc([SITE_FIRST_MAIL_EMAIL,SITE_SEC_MAIL_EMAIL]);
                $message->subject($data['subject']. ' - '.SITE_TITLE);
            });
            return Redirect::back()->with('messages', 'Thank you for messaging us. We will contact you very soon !');
        }

        return Redirect::back()->with('messages', 'Thank you for messaging us. We will contact you very soon !');
    }
}
