<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'address',
        'latitude',
        'longitude',
        
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function calculateShippingFee(): int
    {
        $storeLat = -6.198545886119995; 
        $storeLng = 106.92558539799612;

        // Jika user belum memiliki koordinat, kita set default ongkir (misalnya flat 20k)
        if (is_null($this->latitude) || is_null($this->longitude)) {
            return 20000; 
        }

        // Hitung jarak dalam hitungan Kilometer
        $distance = $this->getDistanceInKm($storeLat, $storeLng, $this->latitude, $this->longitude);

        // Logika Ongkir
        $baseFee = 20000;
        
        if ($distance <= 10) {
            return $baseFee;
        }

        // Jika lebih dari 10km, sisa jaraknya dikali 5000. 
        // Menggunakan ceil() agar kelebihan koma (misal 10.2 km) dihitung masuk ke km berikutnya.
        $extraDistance = ceil($distance - 10);
        $extraFee = $extraDistance * 5000;

        return $baseFee + $extraFee;
    }

    /**
     * Menghitung jarak antara 2 titik koordinat (Haversine Formula)
     */
    private function getDistanceInKm($lat1, $lon1, $lat2, $lon2): float
    {
        $earthRadius = 6371; // Radius bumi dalam kilometer

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }


}
