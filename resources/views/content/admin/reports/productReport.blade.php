<div class="card-body">

    <table class="table table-bordered table-striped">
        <thead>
            <tr class="bg-primary ">
                <th class="text-white">No</th>
                <th class="text-white">Judul Buku</th>
                <th class="text-white">Total Dibeli</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->title }}</td>
                    <td>{{ $product->total_sold }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">
                        Tidak ada data penjualan
                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>

</div>
