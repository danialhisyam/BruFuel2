<div style="position:absolute; left:20px; top:509px; width:389px; height:145px; background:rgba(217,217,217,0.10); border-radius:15px; overflow-x:auto; display:flex; gap:12px; padding:10px; white-space:nowrap;">

    @foreach($vehicles as $v)
        <div style="min-width:115px;height:135px;background:rgba(217,217,217,0.10);border-radius:10px;position:relative;text-align:center;">
            <img src="{{ $v->image ? asset('storage/'.$v->image) : asset('images/car_placeholder.png') }}" 
                 style="width:115px;height:85px;border-radius:8px;object-fit:cover;">
            <div style="color:rgba(255,255,255,0.8);font-size:14px;font-family:Poppins;font-weight:600;margin-top:4px;">
                {{ $v->license_plate }}
            </div>
            <div style="display:flex;justify-content:center;gap:6px;margin-top:2px;">
                <button wire:click="openModal({{ $v->id }})" style="font-size:11px;color:#FFE100;">Edit</button>
                <button wire:click="delete({{ $v->id }})" style="font-size:11px;color:#FF5555;">Delete</button>
            </div>
        </div>
    @endforeach

    <!-- Add vehicle button -->
    <div wire:click="openModal()" style="min-width:115px;height:135px;background:rgba(217,217,217,0.10);border-radius:10px;display:flex;flex-direction:column;align-items:center;justify-content:center;cursor:pointer;">
        <svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M22.5 45C10.0745 45 0 34.9269 0 22.5C0 10.0731 10.0745 0 22.5 0C34.9269 0 45 10.0731 45 22.5C45 34.9269 34.9269 45 22.5 45ZM22.5 5.625C13.1809 5.625 5.625 13.1809 5.625 22.5C5.625 31.8191 13.1809 39.375 22.5 39.375C31.8205 39.375 39.375 31.8191 39.375 22.5C39.375 13.1809 31.8205 5.625 22.5 5.625ZM25.3125 33.75H19.6875V25.3125H11.25V19.6875H19.6875V11.25H25.3125V19.6875H33.75V25.3125H25.3125V33.75Z" fill="white" fill-opacity="0.15"/>
        </svg>
    </div>
</div>

<!-- Modal Popup -->
@if($showModal)
<div class="fixed inset-0 bg-black/60 flex items-center justify-center z-50">
    <div class="bg-[#0A0F1D] rounded-3xl p-6 w-[360px] relative">
        <h2 class="text-white text-lg font-semibold mb-4">{{ $vehicleId ? 'Edit Vehicle' : 'Add Vehicle' }}</h2>

        <input type="text" wire:model="license_plate" placeholder="License Plate" class="w-full mb-3 p-2 rounded bg-gray-800 text-white text-sm border-none outline-none">
        <input type="text" wire:model="vehicle_type" placeholder="Vehicle Type" class="w-full mb-3 p-2 rounded bg-gray-800 text-white text-sm">
        <div class="flex gap-2 mb-3">
            <input type="text" wire:model="make" placeholder="Make" class="flex-1 p-2 rounded bg-gray-800 text-white text-sm">
            <input type="text" wire:model="model" placeholder="Model" class="flex-1 p-2 rounded bg-gray-800 text-white text-sm">
        </div>
        <input type="text" wire:model="color" placeholder="Color" class="w-full mb-3 p-2 rounded bg-gray-800 text-white text-sm">
        <input type="file" wire:model="image" accept="image/*" class="w-full text-sm text-gray-400 mb-3">

        <div class="flex justify-between mt-4">
            <button wire:click="$set('showModal', false)" class="bg-gray-700 text-white px-4 py-2 rounded">Cancel</button>
            <button wire:click="save" class="bg-[#760000] text-white px-4 py-2 rounded font-semibold">Save</button>
        </div>
    </div>
</div>
@endif
