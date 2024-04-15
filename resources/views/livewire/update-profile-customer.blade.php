
<x-jet-form-section submit="update" class="mb-6">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        @if(is_null($customer['name']))
             <!-- Name busisne-->
             <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="name" value="Business name" />
                <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="customer.supplier_business_name"  />
                <x-jet-input-error for="customer.supplier_business_name" class="mt-2" />
            </div>
        @else
            <!-- Name -->
            <div class="col-span-3 sm:col-span-2">
                <x-jet-label for="first_name" value="Name" />
                <x-jet-input id="first_name" type="text" class="mt-1 block w-full" wire:model.defer="customer.first_name"  />
                <x-jet-input-error for="customer.first_name" class="mt-2" />
            </div> 
            <div class="col-span-3 sm:col-span-2">
                <x-jet-label for="last_name" value="Last name" />
                <x-jet-input id="last_name" type="text" class="mt-1 block w-full" wire:model.defer="customer.last_name"  />
                <x-jet-input-error for="customer.last_name" class="mt-2" />
            </div> 
        @endif

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="customer.zip_code" value="Zip code" />
             <select  wire:model="customer.zip_code">
                <option value="" selected disabled>Select an option</option>
                <option value="80104">80104 - Castle Rock</option>
                <option value="80108">80108 -Castle Rock</option>
                <option value="80109">80109 -Castle Rock</option>
             </select>
            
            <x-jet-input-error for="customer.zip_code" class="mt-2" />
        </div> 

         <!-- Documento de identidad -->
         <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="Address" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="customer.address_line_1"  />
            <x-jet-input-error for="customer.address_line_1" class="mt-2" />
        </div>

        <!-- Teléfono --> 
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="mobile" value="Phone" />
            <x-jet-input id="mobile" type="text" class="mt-1 block w-full" wire:model.defer="customer.mobile" autocomplete="mobile" />
            <x-jet-input-error for="customer.mobile" class="mt-2" />
        </div> 
    </x-slot>

    <x-slot name="actions" >
        <!-- <x-jet-action-message class="mr-3" on="saved">
            Guardado
        </x-jet-action-message> -->
        @if($is_active)
          <span class="mr-2">{{ __('Saved.') }}</span>

        @endif
        <x-jet-button wire:loading.attr="disabled">
            <i class="las la-save"></i> {{ __('Save') }}
        </x-jet-button>
    </x-slot>
 
</x-jet-form-section>