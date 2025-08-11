<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role_id', Role::where('slug', 'admin')->first()->id)->first() ?? User::factory()->create([
            'role_id' => Role::where('slug', 'admin')->first()->id ?? Role::factory()->create(['slug' => 'admin'])->id
        ]);

        // Create additional order items for existing orders
        Order::inRandomOrder()->take(5)->get()->each(function ($order) use ($admin) {
            OrderItem::factory()->count(rand(1, 2))->create([
                'order_id' => $order->id,
                'created_by' => $admin->id,
                'updated_by' => $admin->id,
            ]);

            // Update order totals
            $items = $order->orderItems;
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
