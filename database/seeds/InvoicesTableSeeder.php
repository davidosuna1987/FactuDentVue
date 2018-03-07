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
            'user_id' => 1,
            'name' => 'Clinica dental infantil',
            'contact' => 'Elena Navarro García',
            'email' => 'ele.navarrogarcia@gmail.com',
            'nif' => '11111111A',
            'address' => 'Calle Amador Merino Reyna',
            'locality' => 'San Isidro',
            'province' => 'Lima',
            'country' => 'Perú',
            'post_code' => '15046',
            'phone' => '925250742'
        ]);

        foreach(range(1, 40) as $i):
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

            $date = (mt_rand(1,10)>5) ? strtotime(\Carbon::now()) : null;

            $dentist_percentage = 50;
            $sub_total = $invoice_lines->sum('total');
            $dentist_sub_total = $sub_total * $dentist_percentage / 100;
            $retention_percent = 15;
            $retention = $dentist_sub_total * $retention_percent / 100;
            $total = $dentist_sub_total  - $retention;

            $invoice = Invoice::create([
                'clinic_id' => 1,
                'invoice_no' => $i,
                'invoice_date' => strtotime('1-'.mt_rand(1,12).'-2017'),
                'payment_date' => $date,
                'dentist_percentage' => $dentist_percentage,
                'sub_total' => $sub_total,
                'total' => $total
            ]);

            $invoice->invoiceLines()->saveMany($invoice_lines);
        endforeach;
    }
}
