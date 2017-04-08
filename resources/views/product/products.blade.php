<table id="products">
    <thead>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $product->getName() }}</td>
                <td>{{ round($product->getPriceWithDiscount(), 2) }}</td>
                <td>
                    <button v-on:click="buy('{{ $product->getId() }}')">Buy</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
