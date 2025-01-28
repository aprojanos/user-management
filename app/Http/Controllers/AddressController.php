<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\AddressType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AddressController extends Controller
{

    public function store(Request $request, $userId)
    {
        $legal = !empty($request['address_type']) && $request['address_type'] == AddressType::LEGAL->value;

        $validated = $request->validate([
            'country_code' => 'exists:countries,code',
            'zip_code' => 'integer|required',
            'street_address' => 'required',
            'contact_name' => 'required',
            'contact_phone' => 'required',
            'address_type' => ['required', Rule::in(array_column(AddressType::cases(), 'value'))],
            'city' => 'required',
            'company_name' => $legal ? 'required' : 'nullable',
            'tax_number' => $legal ? 'required' : 'nullable',
            'registration_number' => $legal ? 'required' : 'nullable',
            'bank_account_number' => $legal ? 'required' : 'nullable',
        ]);
        $validated['user_id'] = $userId;

        Address::create($validated);

        return back()->with('success', 'Address added successfully');
    }

    public function update(Request $request, $addressId)
    {
        $legal = !empty($request['address_type']) && $request['address_type'] == AddressType::LEGAL->value;

        $validated = $request->validate([
            'country_code' => 'exists:countries,code',
            'zip_code' => 'integer|required',
            'city' => 'required',
            'street_address' => 'required',
            'contact_name' => 'required',
            'contact_phone' => 'required',
            'address_type' => ['required', Rule::in(array_column(AddressType::cases(), 'value'))],
            'company_name' => $legal ? 'required' : 'nullable',
            'tax_number' => $legal ? 'required' : 'nullable',
            'registration_number' => $legal ? 'required' : 'nullable',
            'bank_account_number' => $legal ? 'required' : 'nullable',
        ]);


        $address = Address::find($addressId);
        $address->update($validated);

        return back()->with('success', 'Address updated successfully');
    }

    public function destroy(Address $address)
    {
        $address->delete();
        return back()->with('success', 'Address deleted');
    }

}
