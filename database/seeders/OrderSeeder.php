<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role_id', Role::where('slug', 'admin')->first()->id)->first() ?? User::factory()->create([
            'role_id' => Role::where('slug', 'admin')->first()->id ?? Role::factory()->create(['slug' => 'admin'])->id
        ]);
        Order::factory()->count(10)->create([
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ])->each(function ($order) use ($admin) {
            $items = OrderItem::factory()->count(rand(1, 3))->create([
                'order_id' => $order->id,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);
            $subtotal = $items->sum('row_total');
            $tax_amount = $items->sum('tax_amount') * $items->sum('quantity');
            $discount_amount = $items->sum('discount_amount') * $items->sum('quantity');
            $shipping_amount = $order->shipping_amount;
            $order->update([
                'subtotal' => $subtotal,
                'tax_amount' => $tax_amount,
                'discount_amount' => $discount_amount,
                'total' => $subtotal - $discount_amount + $tax_amount + $shipping_amount,
                'total_paid' => $order->payment_status === 'paid' ? $subtotal - $discount_amount + $tax_amount + $shipping_amount : ($order->payment_status === 'partially_paid' ? $subtotal * 0.5 : 0),
            ]);
        });
    }
}
