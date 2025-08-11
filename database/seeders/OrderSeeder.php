<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Role;
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
        ])->each(function ($order) {
            // Create 1-3 order items per order
            $items = OrderItem::factory()->count(rand(1, 3))->create([
                'order_id' => $order->id,
                'created_by' => $order->created_by,
                'updated_by' => $order->updated_by,
            ]);

            // Update order totals based on items
            $subtotal = $items->sum('row_total');
            $tax_amount = $items->sum('tax_amount') * $items->sum('quantity');
            $discount_amount = $items->sum('discount_amount') * $items->sum('quantity');
            $shipping_amount = $order->shipping_amount;

            $order->update([
                'subtotal' => $subtotal,
                'tax_amount' => $tax_amount,
                'discount_amount' => $discount_amount,
                'total' => $subtotal - $discount_amount + $tax_amount + $shipping_amount,
                'total_paid' => $order->status === 'delivered' ? $subtotal - $discount_amount + $tax_amount + $shipping_amount : 0,
            ]);
        });
    }
}