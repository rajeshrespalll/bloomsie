@extends('layouts.proddesign')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Your Cart') }}
        </h2>
    </x-slot>

    <div class="menu-section">
        <h2>Products</h2>

        <div class="cart-container">
            <h1>Your Cart</h1>
            <div class="cart-header">
                <div></div>
                <div class="label">Price:</div>
                <div class="label">Quantity:</div>
                <div class="label">Total:</div>
            </div>
            @foreach ($products as $product)
                <div class="cart-row">
                    <div class="cart-item">
                        <img src="/product_image/{{ $product->product_image }}" alt="image" class="image">
                        <h3>{{ $product->product_name }}</h3>
                    </div>
                    <div class="cart-details">
                        <div>${{ $product->product_price }}</div>
                        <input type="number" class="quantity" value="1" min="1">
                        <div>${{ $product->product_price }}</div>
                        <div class="cart-actions">
                            <button class="btn">Remove</button>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="cart-actions">
                <button class="btn">Checkout</button>
            </div>
        </div>
    </div>
</x-app-layout>
