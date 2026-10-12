<!DOCTYPE html>
<html>
<head>
    <title>Toko Online (Stateless)</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Daftar Produk</h1>
    <ul>
        @foreach ($products as $product)
            <li>
                {{ $product['name'] }} - Rp{{ number_format($product['price'], 0, ',', '.') }}
                <button onclick="addToCart({{ $product['id'] }})">Tambah ke Keranjang</button>
            </li>
        @endforeach
    </ul>

    <h2>Keranjang Belanja</h2>
    <div id="cart-items">
        <p>Keranjang kosong.</p>
    </div>
    <p><strong>Total: Rp<span id="cart-total">0</span></strong></p>

    <script>
        let cart = {};

        function addToCart(productId) {
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ product_id: productId, cart: cart }),
            })
                .then(response => response.json())
                .then(data => renderCart(data));
        }

        function updateCart(productId, quantity) {
            fetch('/cart/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ product_id: productId, quantity: quantity, cart: cart }),
            })
                .then(response => response.json())
                .then(data => renderCart(data));
        }

        function renderCart(data) {
            cart = {};
            const container = document.getElementById('cart-items');
            container.innerHTML = '';

            if (data.items.length === 0) {
                container.innerHTML = '<p>Keranjang kosong.</p>';
            }

            data.items.forEach(item => {
                cart[item.id] = item.quantity;

                const row = document.createElement('div');
                row.innerHTML =
                    item.name + ' - Rp' + item.price +
                    ' <button onclick="updateCart(' + item.id + ', ' + (item.quantity - 1) + ')">-</button> ' +
                    item.quantity +
                    ' <button onclick="updateCart(' + item.id + ', ' + (item.quantity + 1) + ')">+</button>' +
                    ' = Rp' + item.subtotal;
                container.appendChild(row);
            });

            document.getElementById('cart-total').textContent = data.total;
        }
    </script>
</body>
</html>
