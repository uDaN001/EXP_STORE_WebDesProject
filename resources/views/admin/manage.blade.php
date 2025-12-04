@extends('layouts.app')

@section('title', 'Admin Manage - EXP GAME STORE')

@section('content')
    <div class="container">
        <h1 class="section-title">ADMIN: Manage Data</h1>

        <section style="margin-bottom: 2rem;">
            <h2 style="color: white; font-family: 'Orbitron', sans-serif;">Users</h2>
            <table class="table" style="width:100%; margin-bottom: 1rem;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Is Admin</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->is_admin ? 'Yes' : 'No' }}</td>
                            <td>
                                <a href="{{ url('/admin/users/' . $user->id . '/edit') }}" class="btn btn-primary">Edit</a>
                                <form action="{{ url('/admin/users/' . $user->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" onclick="return confirm('Delete user?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </section>

        <section style="margin-bottom: 2rem;">
            <h2 style="color: white; font-family: 'Orbitron', sans-serif;">Orders</h2>
            <table class="table" style="width:100%; margin-bottom: 1rem;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->customer->full_name ?? $order->customer->username ?? 'N/A' }}</td>
                            <td>₱{{ number_format($order->total_amount, 2) }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                            <td>
                                <button class="btn btn-primary" onclick="toggleEditOrder({{ $order->id }})">Edit</button>
                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
                                    style="display:inline-block;"
                                    onsubmit="return confirmDelete(event, 'order', {{ $order->id }})">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>

                        {{-- Inline edit row (hidden) --}}
                        <tr id="edit-order-{{ $order->id }}" class="edit-row"
                            style="display:none; background: rgba(255,255,255,0.03);">
                            <td colspan="5">
                                <form action="{{ route('orders.update', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div style="display:flex; gap:1rem; align-items:center;">
                                        <div>
                                            <label>Status</label>
                                            <select name="status">
                                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                                    Pending</option>
                                                <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid
                                                </option>
                                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>
                                                    Shipped</option>
                                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                                                    Completed</option>
                                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                                    Cancelled</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label>Payment Method</label>
                                            <input type="text" name="payment_method" value="{{ $order->payment_method }}" />
                                        </div>
                                        <div>
                                            <label>Total Amount</label>
                                            <input type="number" step="0.01" name="total_amount"
                                                value="{{ $order->total_amount }}" />
                                        </div>
                                        <div>
                                            <button class="btn btn-primary" type="submit">Save</button>
                                            <button type="button" class="btn btn-grey"
                                                onclick="toggleEditOrder({{ $order->id }})">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $orders->links() }}
        </section>

        <section>
            <h2 style="color: white; font-family: 'Orbitron', sans-serif;">Games</h2>
            <table class="table" style="width:100%; margin-bottom: 1rem;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Genre</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($games as $game)
                        <tr>
                            <td>{{ $game->id }}</td>
                            <td>{{ $game->title }}</td>
                            <td>{{ $game->genre }}</td>
                            <td>₱{{ number_format($game->price, 2) }}</td>
                            <td>
                                <button class="btn btn-primary" onclick="toggleEditGame({{ $game->id }})">Edit</button>
                                <form action="{{ route('admin.games.delete', $game->id) }}" method="POST"
                                    style="display:inline-block;"
                                    onsubmit="return confirmDelete(event, 'game', {{ $game->id }})">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>

                        {{-- Inline edit row for game --}}
                        <tr id="edit-game-{{ $game->id }}" class="edit-row"
                            style="display:none; background: rgba(255,255,255,0.03);">
                            <td colspan="5">
                                <form action="{{ route('admin.games.update', $game->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div style="display:flex; gap:1rem; align-items:center; flex-wrap:wrap;">
                                        <div>
                                            <label>Title</label>
                                            <input type="text" name="title" value="{{ $game->title }}" />
                                        </div>
                                        <div>
                                            <label>Genre</label>
                                            <input type="text" name="genre" value="{{ $game->genre }}" />
                                        </div>
                                        <div>
                                            <label>Price</label>
                                            <input type="number" step="0.01" name="price" value="{{ $game->price }}" />
                                        </div>
                                        <div>
                                            <label>Stock</label>
                                            <input type="number" name="stock" value="{{ $game->stock }}" />
                                        </div>
                                        <div style="display:flex; gap:8px; align-items:center;">
                                            <button class="btn btn-primary" type="submit">Save</button>
                                            <button type="button" class="btn btn-grey"
                                                onclick="toggleEditGame({{ $game->id }})">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $games->links() }}
        </section>

    </div>

    <div id="confirm-modal"
        style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); align-items:center; justify-content:center;">
        <div style="background:#111; padding:20px; border-radius:10px; width:90%; max-width:480px; text-align:center;">
            <p id="confirm-text" style="color:white; font-family:'Orbitron',sans-serif; font-size:18px;"></p>
            <div style="margin-top:16px; display:flex; gap:10px; justify-content:center;">
                <button id="confirm-yes" class="btn btn-danger">Yes, Delete</button>
                <button id="confirm-no" class="btn btn-grey">Cancel</button>
            </div>
        </div>
    </div>

    <script>
        function toggleEditOrder(id) {
            const row = document.getElementById('edit-order-' + id);
            if (!row) return;
            row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
            if (row.style.display === 'table-row') row.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        function toggleEditGame(id) {
            const row = document.getElementById('edit-game-' + id);
            if (!row) return;
            row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
            if (row.style.display === 'table-row') row.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        // Confirmation modal handling
        let pendingDelete = null;
        function confirmDelete(event, type, id) {
            event.preventDefault();
            pendingDelete = { form: event.target, type, id };
            const txt = document.getElementById('confirm-text');
            txt.textContent = `Are you sure you want to delete this ${type} (ID: ${id})? This action can be undone (soft-delete).`;
            document.getElementById('confirm-modal').style.display = 'flex';
            return false;
        }

        document.getElementById('confirm-no').addEventListener('click', function () {
            document.getElementById('confirm-modal').style.display = 'none';
            pendingDelete = null;
        });

        document.getElementById('confirm-yes').addEventListener('click', function () {
            if (pendingDelete && pendingDelete.form) {
                pendingDelete.form.submit();
            }
        });
    </script>
@endsection