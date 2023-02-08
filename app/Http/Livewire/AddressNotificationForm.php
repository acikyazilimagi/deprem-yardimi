<?php

namespace App\Http\Livewire;

use App\Models\Data;
use App\Models\Location;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class AddressNotificationForm extends Component
{
    use WithRateLimiting;

    public string $city = '';

    public string $district = '';

    public string $neighbourhood = '';

    public string $source = '';

    public string $street = '';

    public string $apartment = '';

    public string $apartmentNo = '';

    public string $floor = '';

    public string $nameSurname = '';

    public string $phoneNumber = '';

    public string $directions = '';

    public function render()
    {
        return view('livewire.address-notification-form');
    }

    public function getCities()
    {
        return Location::pluck('city')
            ->unique()
            ->selectOptions();
    }

    public function getDistricts()
    {
        return filled($this->city)
            ? Location::where('city', $this->city)
                ->pluck('district')
                ->unique()
                ->selectOptions()
            : [];
    }

    public function getNeighbourhoods()
    {
        return filled($this->city) && filled($this->district)
            ? Location::where('city', $this->city)
                ->where('district', $this->district)
                ->pluck('street')
                ->unique()
                ->selectOptions()
            : [];
    }

    public function submit()
    {
        $this->validate([
            'city' => 'required',
            'district' => 'required',
            'neighbourhood' => 'required',
            'source' => 'required',
            'street' => 'required',
            'apartment' => 'required',
        ], messages: [
            'required' => 'Bu alan zorunludur',
        ]);

        try {
            $this->rateLimit(5);
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent(
                'formSubmitted',
                [
                    'title' => 'Hata',
                    'message' => 'Bir süre sonra tekrar deneyiniz',
                    'status' => 'error',
                ]
            );

            return;
        }

        $insert = Data::create([
            'city' => $this->city,
            'district' => $this->district,
            'street' => $this->neighbourhood,
            'street2' => $this->street,
            'apartment' => $this->apartment,
            'apartment_no' => $this->apartmentNo,
            'apartment_floor' => $this->floor,
            'phone' => $this->phoneNumber,
            'address' => $this->directions,
            'fullname' => $this->nameSurname,
            'source' => $this->source,
        ]);

        Cache::forget('cities_');

        $this->dispatchBrowserEvent(
            'formSubmitted',
            $insert ? [
                'title' => 'Kayıt Başarılı',
                'message' => 'Veri başarıyla eklendi',
                'status' => 'success',
            ] : [
                'title' => 'Kayıt Başarısız',
                'message' => 'Veri eklenirken bir hata oluştu',
                'status' => 'error',
            ]
        );
    }

    public function clearForm()
    {
        $this->reset();
    }
}
