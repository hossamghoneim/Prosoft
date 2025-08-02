<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::insert([
            [
                'title' => 'Headquarters',
                'address' => "Smart Village,\nA25-B107 - 1st Floor,\nKm 28 Cairo - Alexandria Desert Rd\nGiza,\nEgypt",
                'latitude' => 30.0787215,
                'longitude' => 30.9996055,
                'iframe_url' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13810.159431568636!2d30.999605493017146!3d30.078721481686934!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14585b91cca2b39d%3A0xf106c6d2d954f164!2sSmart%20Village%2C%20Kerdasa%2C%20Giza%20Governorate%203630106!5e0!3m2!1sen!2seg!4v1754158366834!5m2!1sen!2seg" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
                'order' => 1,
            ],
            [
                'title' => 'Logistics office',
                'address' => "38 Ahmed Orabi Street,\nMohandiseen,\nGiza,\nEgypt",
                'latitude' => 30.0769299,
                'longitude' => 31.2042501,
                'iframe_url' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3452.602382810044!2d31.20425007611361!3d30.07692991702975!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1458411815595555%3A0x136589d640710445!2sAhmed%20Orabi%20St.!5e0!3m2!1sen!2seg!4v1754158401315!5m2!1sen!2seg" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
                'order' => 2,
            ],
        ]);
    }
}
