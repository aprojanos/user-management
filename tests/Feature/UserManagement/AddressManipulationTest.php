<?php

namespace Tests\Feature\UserManagement;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\User;
use App\Models\AddressType;
use App\Models\Address;
use App\Models\Country;

class AddressManipulationTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_address_individual(): void
    {
        $user = User::factory()->create();

        $activeUser = User::factory()->create(['status' => 'active']);
        $this->actingAs($activeUser);

        $address = Address::factory()->for($user)->create();

        $addressData = [
            'user_id' => $user->id,
            'country_code' => $address->country_code,
            'zip_code' => $address->zip_code,
            'city' => $address->city,
            'street_address' => $address->street_address,
            'contact_name' => $address->contact_name,
            'contact_phone' => $address->contact_phone,
            'address_type' => AddressType::INDIVIDUAL->value,
        ];
        $response = $this->post("/admin/address/{$user->id}", $addressData);
        $response->assertRedirect();

        $this->assertDatabaseHas('addresses', $addressData);


    }
    public function test_create_address_legal(): void
    {
        $user = User::factory()->create();

        $activeUser = User::factory()->create(['status' => 'active']);
        $this->actingAs($activeUser);

        $address = Address::factory()->for($user)->create();

        $addressData = [
            'user_id' => $user->id,
            'country_code' => $address->country_code,
            'zip_code' => $address->zip_code,
            'city' => $address->city,
            'street_address' => $address->street_address,
            'contact_name' => $address->contact_name,
            'contact_phone' => $address->contact_phone,
            'address_type' => AddressType::LEGAL->value,
            'company_name' => $address->company_name,
            'tax_number' => $address->tax_number,
            'registration_number' => $address->registration_number,
            'bank_account_number' => $address->bank_account_number,
        ];

        $response = $this->post("/admin/address/{$user->id}", $addressData);
        $response->assertRedirect();
        
        $this->assertDatabaseHas('addresses', $addressData);

    }
    public function test_update_address(): void
    {

      $user = User::factory()->create();
      $address = Address::factory()->for($user)->create();

      $activeUser = User::factory()->create(['status' => 'active']);
      $this->actingAs($activeUser);

      $updatedAddressData = [
          'user_id' => $user->id,
          'country_code' => 'HU',
          'zip_code' => '6722',
          'city' => 'Szeged',
          'street_address' => 'Attila utca 11',
          'contact_name' => 'Janos Apro',
          'contact_phone' => '+36313315815',
          'address_type' => AddressType::INDIVIDUAL->value,
      ];

      $response = $this->put("/admin/address/{$address->id}", $updatedAddressData);

      $response->assertRedirect();
      
      $updatedAddressData['id'] = $address->id;
      $this->assertDatabaseHas('addresses', $updatedAddressData);
    }
    public function test_delete_address(): void
    {
        $user = User::factory()->create();
        $address = Address::factory()->for($user)->create();

        $activeUser = User::factory()->create(['status' => 'active']);
        $this->actingAs($activeUser);


        $this->delete("/admin/address/{$address->id}");

        $this->assertSoftDeleted('addresses', ['id' => $address->id]);
    }
}
