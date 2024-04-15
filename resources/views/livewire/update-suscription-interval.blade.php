<div class="grid grid-cols-2 gap-6 text-gray-700">
    <div>
        <p class="text-lg font-semibold uppercase">Subscription</p>
        <p class="text-sm">{{$transaction->recur_interval}} day interval</p>
    </div>
    <div class="pr-5">
        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 ">Select the frequency:</label>
        <select  wire:model="frequency" aria-label="frequency" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
            <option value="" disabled >Select on option</option>
            <option value="7"> Weekly </option>
            <option value="14">Every 2 weeks</option>
            <option value="21">Every 3 weeks</option>
            <option value="28">Every 4 weeks</option>
        </select>
        <x-jet-input-error for="frequency" />
        <x-jet-button class="mt-3" wire:click="save"  wire:loading.attr="disabled">Save Frequency</x-jet-button>
    </div>
</div> 