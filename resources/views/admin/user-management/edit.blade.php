<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h3 class="font-semibold py-3 text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Basic info') }}</h3>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <form id="edit-user-form" action="{{ route('admin.user-management.update', $user) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="username">{{ __('Username') }}</label>
                        <input type="text" name="username" id="username" class="form-control" value = "{{ $user->username }}"  required>
                    </div>
                    <div class="form-group">
                        <label for="email">{{ __('Email') }}</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
                    </div>
                    <div class="form-group">
                        <label for="phone_number">{{ __('Phone Number') }}</label>
                        <input type="text" name="phone_number" id="phone_number" class="form-control" value = "{{ $user->phone_number }}"  placeholder="+000 000000000">
                    </div>
                   <div class="form-group">
                        <label for="password">{{ __('Password (leave blank if you don\'t want to change it)') }}</label>
                        <input type="password" autocomplete="new-password" name="password" id="password" class="form-control" minlength="8">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"  minlength="8">
                    </div>
                    <div class="form-group">
                        <label for="status">{{ __('Status') }}</label>
                        <select name="status" id="status" class="form-control">
                            <option value="inactive" {{ $user->status === 'inactive' ? 'selected' : '' }} >{{ __('Inactive') }}</option>
                            <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                            <option value="banned"{{ $user->status === 'banned' ? 'selected' : '' }}>{{ __('Banned') }}</option>
                        </select>
                    </div>

                    {{-- Profile Picture --}}
                    <div class="mb-10">
                        <label for="profile_picture">{{ __('Profile Picture') }}</label><br>
                        @if ($user->getFirstMedia())
                            <img src="{{ $user->getFirstMedia()->getUrl('profile') }}"
                                alt="Profile"
                                class="mb-2"
                                style="max-width:200px; max-height: 200px">
                            <div><a href="{{ route('admin.user-management.remove-profile-picture', $user) }}" class="text-red-500 hover:underline">{{ __('Remove Picture') }}</a></div>
                        @endif

                        <input type="file" name="profile_picture" id="profile_picture" class="form-control">

                        <div id="image-preview" style="display:none;">
                          <img id="preview-image"  alt="Preview" style="max-width:200px; max-height: 200px">
                        </div>
                    </div>
                    <button onclick="submitUserForm()"
                        class="text-white bg-green-700 hover:bg-green-800 focus:outline-none text-sm px-5 py-2.5 text-center me-2 mb-2"
                    >{{ __('Update User') }}</button>
                </form>


                <form action="{{ route('admin.user-management.destroy', $user) }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="text-white bg-red-700 hover:bg-red-800 focus:outline-none text-sm px-5 py-2.5 text-center me-2 mb-2"
                        onclick="return confirm('Are you sure you want to delete this user?')">{{ __('Delete User') }}</button>
                </form>
            </div>
        </div>
    </div>

    <script>
      const input = document.getElementById('profile_picture');
      const preview = document.getElementById('image-preview');
      const previewImage = document.getElementById('preview-image');

      input.addEventListener('change', () => {
        const file = input.files[0];
        if (file) {
          const reader = new FileReader();

          reader.addEventListener('load', () => {
              console.log('file loaded');
            previewImage.src = reader.result;
            preview.style.display = 'block';
          });

          reader.readAsDataURL(file);
        }else {
            console.log('no file selected');
            preview.style.display = 'none';
        }
      });

      function submitUserForm() {
 
        let isValid = true;

        const phoneInput = document.getElementById('phone_number');
        if (!/^\+\d{1,3}\s?\d{1,14}$/.test(phoneInput.value)) {
            isValid = false;
            phoneInput.setCustomValidity('Invalid phone number format');
            phoneInput.focus();
        } else {
            phoneInput.setCustomValidity('');
        }

        const passwordInput = document.getElementById('password');
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        if(passwordInput.value !== passwordConfirmationInput.value) {
            isValid = false;
            passwordConfirmationInput.setCustomValidity('Password and Confirmation do not match');
            passwordConfirmationInput.focus();
        } else {
            passwordConfirmationInput.setCustomValidity('');
        }

        if (!isValid) {
            event.preventDefault();
        }
      }
    </script>


    @include('admin/user-management/partials/addresses')
</x-app-layout>
