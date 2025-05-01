<!-- resources/views/frontend/brands.blade.php -->
<div class="container my-5">
    <h2 class="text-center mb-4">Shop by Brand</h2>
    <div class="row">
        @foreach($brands as $brand)
        <div class="col-md-2 col-4 mb-4">
            <a href="{{ route('brand.products', $brand->id) }}" class="text-decoration-none">
                <div class="card border-0 text-center hover-shadow">
                    <img src="{{ asset('storage/' . $brand->brandImg) }}" class="card-img-top p-3"
                        alt="{{ $brand->brandName }}" style="height: 100px; object-fit: contain;">
                    <div class="card-body p-2">
                        <h6 class="card-title">{{ $brand->brandName }}</h6>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>