<?php

use App\Clinic;
use App\Invoice;
use App\InvoiceLine;
use Faker\Factory;
use Illuminate\Database\Seeder;

class InvoicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $clinic = Clinic::create([
            'user_id' => 2,
            'name' => 'Clínica Test Uno',
            'contact' => 'Contacto clínica test uno',
            'email' => 'clinicauno@test.com',
            'nif' => '11111111A',
            'address' => 'Calle Bélgica 14',
            'locality' => 'Valencia',
            'province' => 'Valencia',
            'country' => 'España',
            'post_code' => 46021,
            'phone' => '666666666',
            'fax' => '777777777',
            'percentage' => 50,
            'active' => true
        ]);

        foreach(range(1, 12) as $i):
            $invoice_lines = collect();

            foreach(range(1, mt_rand(2, 10)) as $j):
                // $price = $faker->numberBetween(100, 1000);
                // $quantity = $faker->numberBetween(1, 20);
                $price = $j*10;
                $quantity = $j;

                $invoice_lines->push(new InvoiceLine([
                    // 'description' => $faker->sentence,
                    'description' => 'Línea de pedido'.$j,
                    'quantity' => $quantity,
                    'unit_price' => $price,
                    'total' => ($quantity * $price)
                ]));
            endforeach;

            $sub_total = $invoice_lines->sum('total');
            $retention_percent = 15;
            $retention = $sub_total * $retention_percent / 100;
            $total = $sub_total - $retention;

            $date = ($i%2==0) ? strtotime(\Carbon\Carbon::now()) : null;

            $invoice = Invoice::create([
                'clinic_id' => 1,
                'invoice_no' => $faker->numberBetween(10000, 999999),
                'invoice_date' => strtotime('1-'.$i.'-2017'),
                'payment_date' => $date,
                'sub_total' => $sub_total,
                'total' => $total
            ]);

            $invoice->invoiceLines()->saveMany($invoice_lines);
        endforeach;
    }
}
