<?php

namespace Tests\Feature;

use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_display_the_main_page_even_if_empty()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Buku Kas');
        $response->assertSee('Saldo Anda');
        $response->assertSee('Buku ini masih kosong');
    }

    /** @test */
    public function it_can_store_a_valid_transaction()
    {
        $response = $this->post('/transactions', [
            'type'        => 'keluar',
            'date'        => '2026-07-11',
            'category'    => 'Makanan',
            'description' => 'Makan Nasi Padang',
            'amount'      => 25000,
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('stamped', true);

        $this->assertDatabaseHas('transactions', [
            'type'        => 'keluar',
            'category'    => 'Makanan',
            'description' => 'Makan Nasi Padang',
            'amount'      => 25000,
        ]);
    }

    /** @test */
    public function it_can_calculate_totals_correctly()
    {
        Transaction::create([
            'type'     => 'masuk',
            'date'     => '2026-07-11',
            'category' => 'Gaji',
            'amount'   => 1500000,
        ]);

        Transaction::create([
            'type'     => 'keluar',
            'date'     => '2026-07-11',
            'category' => 'Makanan',
            'amount'   => 25000,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Rp1.475.000'); // Saldo
        $response->assertSee('Rp1.500.000'); // Pemasukan
        $response->assertSee('Rp25.000');   // Pengeluaran
    }

    /** @test */
    public function it_can_delete_a_transaction()
    {
        $transaction = Transaction::create([
            'type'     => 'masuk',
            'date'     => '2026-07-11',
            'category' => 'Bonus',
            'amount'   => 500000,
        ]);

        $this->assertDatabaseHas('transactions', ['id' => $transaction->id]);

        $response = $this->delete('/transactions/' . $transaction->id);

        $response->assertRedirect();
        $this->assertDatabaseMissing('transactions', ['id' => $transaction->id]);
    }
}
