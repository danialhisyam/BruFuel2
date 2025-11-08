<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;

class VehicleManager extends Component
{
    use WithFileUploads;

    public $vehicles = [];
    public $showModal = false;
    public $vehicleId, $license_plate, $vehicle_type, $make, $model, $color, $image;

    public function mount()
    {
        $this->vehicles = Vehicle::where('user_id', Auth::id())->get();
    }

    public function openModal($id = null)
    {
        if ($id) {
            $v = Vehicle::find($id);
            $this->vehicleId = $v->id;
            $this->license_plate = $v->license_plate;
            $this->vehicle_type = $v->vehicle_type;
            $this->make = $v->make;
            $this->model = $v->model;
            $this->color = $v->color;
        } else {
            $this->reset(['vehicleId','license_plate','vehicle_type','make','model','color','image']);
        }
        $this->showModal = true;
    }

    public function save()
    {
        $data = $this->validate([
            'license_plate' => 'required|string|max:20',
            'vehicle_type' => 'required|string',
            'make' => 'required|string',
            'model' => 'required|string',
            'color' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($this->image) {
            $data['image'] = $this->image->store('vehicles', 'public');
        }

        Vehicle::updateOrCreate(
            ['id' => $this->vehicleId],
            array_merge($data, ['user_id' => Auth::id()])
        );

        $this->showModal = false;
        $this->mount(); // refresh list
    }

    public function delete($id)
    {
        Vehicle::where('id', $id)->delete();
        $this->mount();
    }

    public function render()
    {
        return view('livewire.vehicle-manager');
    }
}
