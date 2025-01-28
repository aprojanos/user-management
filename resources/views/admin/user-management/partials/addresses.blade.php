
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h3 class="font-semibold py-3 text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Addresses') }}</h3>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="address-list ">
            <table class="table" style="width:100%;text-align:left;">
                        <thead>
                            <tr>
                                <th>Country</th>
                                <th>City</th>
                                <th>Street</th>
                                <th>Contact Name</th>
                                <th>Contact Phone</th>
                                <th>Address Type</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($user->addresses as $address)
                            <tr class="even:bg-gray-50 odd:bg-white">
                                    <td>{{ $address->country->name }}</td>
                                    <td>{{ $address->city }}</td>
                                    <td>{{ $address->street_address }}</td>
                                    <td>{{ $address->contact_name }}</td>
                                    <td>{{ $address->contact_phone }}</td>
                                    <td>{{ $address->address_type }}</td>
                                    <td>
                                    <button
                                        class="text-white bg-green-700 hover:bg-green-800 focus:outline-none text-sm px-5 py-2.5 text-center me-2 mb-2"
                                        onclick="populateEditForm({{$address}}, 'edit');return false;"
                                    >{{ __('Edit') }}</button>
                                    
                                    <form action="{{ route('address.destroy', $address->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="text-white bg-red-700 hover:bg-red-800 focus:outline-none text-sm px-5 py-2.5 text-center me-2 mb-2"
                                            onclick="return confirm('Are you sure?')">{{ __('Delete') }}
                                        </button>
                                    </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>

            <h3 class="font-semibold text-l text-gray-800 dark:text-gray-200 leading-tight">{{ __('Add/Edit Address') }}</h3>
                <!-- create address form -->
                <form id="create-address-form" action="{{ route('address.store', $user->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="form-group">
                        <label for="country_code">{{ __('Country Code') }}</label>
                        <select name="country_code" id="create-country_code" class="form-control" required>
                            <option value="">{{ __('Select') }}</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country['code'] }}">{{ $country['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="zip_code">{{ __('Zip code') }}</label>
                        <input type="text" name="zip_code" id="create-zip_code" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="city">{{ __('City') }}</label>
                        <input type="text" name="city" id="create-city" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="street_address">{{ __('Street Address') }}</label>
                        <input type="text" name="street_address" id="create-street_address" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="contact_name">{{ __('Contact Name') }}</label>
                        <input type="text" name="contact_name" id="create-contact_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="contact_phone">{{ __('Contact Phone') }}</label>
                        <input type="text" name="contact_phone" id="create-contact_phone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="address_type">{{ __('Address Type') }}</label>
                        <select
                            name="address_type"
                            class="form-control"
                            onchange="showCreateLegalAddress(this.value)"
                            id="create-address_type"
                        >
                            @foreach ($addressTypes as $type)
                                <option value="{{ $type->value }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="create-legal-address" class="hidden">
                        <div class="form-group">
                            <label for="company_name">{{ __('Company Name') }}</label>
                            <input type="text" name="company_name" id="create-company_name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="tax_number">{{ __('Tax No.') }}</label>
                            <input type="text" name="tax_number" id="create-tax_number" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="registration_number">{{ __('Registrattion No.') }}</label>
                            <input type="text" name="registration_number" id="create-registration_number" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="bank_account_number">{{ __('Bank Account No.') }}</label>
                            <input type="text" name="bank_account_number" id="create-bank_account_number" class="form-control">
                        </div>
                    </div>
                    <button type="submit"
                        class="text-white bg-green-700 hover:bg-green-800 focus:outline-none text-sm px-5 py-2.5 text-center me-2 mb-2"
                    >Create Address</button>
                </form>
                <!-- edit address form -->
                <form id="edit-address-form" action="{{ route('address.update', ['user' => $user->id, 'address' => 'address_id_placeholder']) }}" method="POST" style="display:none">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="address_id" id="edit-address-id" value="">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">

                    <div class="form-group">
                        <label for="country_code">{{ __('Country') }}</label>
                        <select name="country_code" id="edit-country_code" class="form-control" required>
                            <option value="">{{ __('Select') }}</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country['code'] }}">{{ $country['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="zip_code">{{ __('Zip code') }}</label>
                        <input type="text" name="zip_code" id="edit-zip_code" class="form-control" value = "" required>
                    </div>
                    <div class="form-group">
                        <label for="city">{{ __('City') }}</label>
                        <input type="text" name="city" id="edit-city" class="form-control" value = "" required>
                    </div>
                    <div class="form-group">
                        <label for="street_address">{{ __('Street Address') }}</label>
                        <input type="text" name="street_address" id="edit-street_address" class="form-control" value = "" required>
                    </div>
                    <div class="form-group">
                        <label for="contact_name">{{ __('Contact Name') }}</label>
                        <input type="text" name="contact_name" id="edit-contact_name" class="form-control" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="contact_phone">{{ __('Contact Phone') }}</label>
                        <input type="text" name="contact_phone" id="edit-contact_phone" class="form-control" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="address_type">{{ __('Address Type') }}</label>
                        <select
                            name="address_type"
                            id="edit-address_type"
                            class="form-control"
                            onchange="showEditLegalAddress(this.value)
                        ">
                            @foreach ($addressTypes as $type)
                                <option value="{{ $type->value }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="edit-legal-address" class="hidden">
                        <div class="form-group">
                            <label for="company_name">{{ __('Company Name') }}</label>
                            <input type="text" name="company_name" id="edit-company_name" class="form-control" value = "">
                        </div>

                        <div class="form-group">
                            <label for="tax_number">{{ __('Tax No.') }}</label>
                            <input type="text" name="tax_number" id="edit-tax_number" class="form-control" value = "">
                        </div>
                        <div class="form-group">
                            <label for="registration_number">{{ __('Registrattion No.') }}</label>
                            <input type="text" name="registration_number" id="edit-registration_number" class="form-control" value = "">
                        </div>
                        <div class="form-group">
                            <label for="bank_account_number">{{ __('Bank Account No.') }}</label>
                            <input type="text" name="bank_account_number" id="edit-bank_account_number" class="form-control" value = "">
                        </div>
                    </div>

                    <button type="submit"
                        class="text-white bg-green-700 hover:bg-green-800 focus:outline-none text-sm px-5 py-2.5 text-center me-2 mb-2"
                    >Update Address</button>
                    <button onclick="showEditForm(false);return false;">Cancel</button>
                </form>

                <script>

                    // populate edit/create address fields
                    var updateFailed = '{{ old("address_id") }}' != '';
                    var createFailed = !updateFailed && '{{ old("user_id") }}' != '';
                    if (updateFailed || createFailed) {
                        var address = {
                            id: '{{ old("address_id") }}',
                            country_code: '{{ old("country_code") }}',
                            zip_code: '{{ old("zip_code") }}',
                            city: '{{ old("city") }}',
                            street_address: '{{ old("street_address") }}',
                            address_type: '{{ old("address_type") }}',
                            contact_name: '{{ old("contact_name") }}',
                            contact_phone: '{{ old("contact_phone") }}',
                            address_type: '{{ old("address_type") }}',
                            company_name: '{{ old("company_name") }}',
                            tax_number: '{{ old("tax_number") }}',
                            registration_number: '{{ old("registration_number") }}',
                            bank_account_number: '{{ old("bank_account_number") }}'
                        }
                        populateEditForm(address, updateFailed ? 'edit' : 'create');
                    }

                    function populateEditForm(address, prefix) {
                        console.log('populateEditForm', address, prefix);
                        document.getElementById(prefix + '-country_code').value = address.country_code;
                        document.getElementById(prefix + '-zip_code').value = address.zip_code;
                        document.getElementById(prefix + '-city').value = address.city;
                        document.getElementById(prefix + '-street_address').value = address.street_address;
                        document.getElementById(prefix + '-contact_name').value = address.contact_name;
                        document.getElementById(prefix + '-contact_phone').value = address.contact_phone;
                        document.getElementById(prefix + '-address_type').value = address.address_type;
                        document.getElementById(prefix + '-company_name').value = address.company_name;
                        document.getElementById(prefix + '-tax_number').value = address.tax_number;
                        document.getElementById(prefix + '-registration_number').value = address.registration_number;
                        document.getElementById(prefix + '-bank_account_number').value = address.bank_account_number;

                        if(prefix == 'edit') {
                            document.getElementById(prefix + '-address-id').value = address.id;
                            showEditLegalAddress(address.address_type);
                            // Update the form action URL
                            const form = document.getElementById('edit-address-form');
                            form.action = form.action.replace('address_id_placeholder', address.id);
                            showEditForm();
                        } else {
                            showCreateLegalAddress(address.address_type);
                            showEditForm(false);
                        }
                        
                    }
                    
                    function showEditForm(show) {
                        if (show == undefined) show = true;
                        document.getElementById('edit-address-form').style.display = show ? 'block' : 'none';
                        showCreateForm(!show);
                        setEditLegalFieldValidations();
                    }

                    function showCreateForm(show) {
                        if (show == undefined) show = true;
                        document.getElementById('create-address-form').style.display = show ? 'block' : 'none';
                        setCreateLegalFieldValidations();
                    }
                    function showCreateLegalAddress(addressType) {
                        document.getElementById('create-legal-address').style.display = addressType === 'legal' ? 'block' : 'none';
                        setCreateLegalFieldValidations();
                    }
                    function showEditLegalAddress(addressType) {
                        document.getElementById('edit-legal-address').style.display = addressType === 'legal' ? 'block' : 'none';
                        setEditLegalFieldValidations();
                    }

                    // form validations
                    function setCreateLegalFieldValidations() {
                        var required = document.getElementById('create-address_type').value == 'legal';
                        console.log('create requeired validation', required)
                        document.getElementById('create-company_name').required = required;
                        document.getElementById('create-tax_number').required = required;
                        document.getElementById('create-registration_number').required = required;
                        document.getElementById('create-bank_account_number').required = required;
                    }
                    function setEditLegalFieldValidations() {
                        console.log('edit requeired validation', required)
                        var required = document.getElementById('edit-address_type').value == 'legal';
                        document.getElementById('edit-company_name').required = required;
                        document.getElementById('edit-tax_number').required = required;
                        document.getElementById('edit-registration_number').required = required;
                        document.getElementById('edit-bank_account_number').required = required;
                    }
                </script>
            </h3>
        </div>
    </div>
</div>
