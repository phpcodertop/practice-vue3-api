<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContactsController extends Controller
{

    public function index()
    {
        $contacts = auth()->user()->contacts;
        return DataTables::of($contacts)->make();
    }

    public function show(Contact $contact)
    {
        return response()->json($contact, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
        ]);

       // upload the image
        $image = $request->file('image');
        $fileName = null;
        if ($image) {
            $fileName = time().'.'. $image->extension();
            $image->move(public_path('uploads/contacts'), $fileName);
            $fileName = 'uploads/contacts/'.$fileName;
        }

        $contact = Contact::create([
            'user_id' => auth()->id(),
            'image' => $fileName,
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => isUndefined($request->input('email')),
            'phone' => isUndefined($request->input('phone')),
            'landline' => isUndefined($request->input('landline')),
            'extra' => isUndefined($request->input('extra')),
        ]);

        return response()->json([
            'contact' => $contact,
            'message' => 'Contact Added Successfully.',
        ], 201);
    }

    public function update(Contact $contact, Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
        ]);

        // upload the image
        $image = $request->file('image');
        $data = array();
        if ($image && $image !== 'undefined') {
            $fileName = time().'.'. $image->extension();
            $image->move(public_path('uploads/contacts'), $fileName);
            $fileName = 'uploads/contacts/'.$fileName;
            if (isset($contact->originalImage)) {
                unlink("$contact->originalImage");
            }
            $data['image'] = $fileName;
        }

        $data['first_name'] = $request->input('first_name');
        $data['last_name'] = $request->input('last_name');
        $data['email'] = isUndefined($request->input('email'));
        $data['phone'] = isUndefined($request->input('phone'));
        $data['landline'] = isUndefined($request->input('landline'));
        $data['extra'] = isUndefined($request->input('extra'));


        $contact->update($data);

        return response()->json([
            'contact' => $contact,
            'message' => 'Contact Updated Successfully.',
        ], 200);
    }

    public function destroy(Contact $contact)
    {
        if (isset($contact->originalImage)) {
            unlink("$contact->originalImage");
        }
        $contact->delete();
        return response()->json([], 200);
    }

}
