<?php

namespace App\Controllers;

use App\Models\ContactModel;

class Contact extends BaseController
{
    /**
     * Handle the submission of the contact form from the public website.
     * This method validates the input and saves the lead to the database.
     */
    public function submit()
    {
        // 1. Set up validation rules to ensure data is clean and safe
        $rules = [
            'full_name'     => 'required|min_length[3]|max_length[100]',
            'phone'         => 'required|min_length[7]|max_length[20]',
            'practice_area' => 'required',
            'description'   => 'required|min_length[10]'
        ];

        // 2. Run the validation against the POST data
        if (!$this->validate($rules)) {
            // If validation fails, redirect back with an error message
            return redirect()->to('contact')->with('error', 'Please fill all fields correctly. Description must be at least 10 characters.');
        }

        $contactModel = new ContactModel();

        // 3. Prepare the data array to insert into the database
        $data = [
            'full_name'     => $this->request->getPost('full_name'),
            'phone'         => $this->request->getPost('phone'),
            'practice_area' => $this->request->getPost('practice_area'),
            'description'   => $this->request->getPost('description'),
            'status'        => 'New' // Default status for new leads
        ];

        // 4. Save the lead to the database
        $contactModel->insert($data);

        // 5. Redirect back to the contact page with a success message (SweetAlert will show it)
        return redirect()->to('contact')->with('success', 'Thank you! Your consultation request has been submitted. Our team will contact you shortly.');
    }
}
