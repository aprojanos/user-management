<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\AddressType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AddressController extends Controller
{

    /**
     * Store a new address for a user.
     *
     * This function validates the input, creates a new address in the database,
     * and returns a redirect response with a success message.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing the address data
     * @param int $userId The ID of the user to associate the address with
     * @return \Illuminate\Http\RedirectResponse A redirect response with a success message
     */
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

    /**
     * Update an existing address.
     *
     * This function validates the input, updates the address in the database,
     * and returns a redirect response with a success message.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing the updated address data
     * @param int $addressId The ID of the address to be updated
     * @return \Illuminate\Http\RedirectResponse A redirect response with a success message
     */
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

    /**
     * Delete an existing address.
     *
     * This function deletes the specified address from the database and returns
     * a redirect response with a success message.
     *
     * @param \App\Models\Address $address The address to be deleted
     * @return \Illuminate\Http\RedirectResponse A redirect response with a success message
     */
    public function destroy(Address $address)
    {
        $address->delete();
        return back()->with('success', 'Address deleted');
    }

}
