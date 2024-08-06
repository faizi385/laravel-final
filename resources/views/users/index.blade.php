@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-white mt-4">Manage Users</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- DataTable Initialization -->
    <table class="table table-striped table-hover" id="usersTable">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <!-- Action Buttons with Confirmation -->
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
</div>
@endsection

@push('styles')
<style>
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #ddd !important;
        border-radius: 4px !important;
        padding: 8px 12px !important;
        background-color: #f9f9f9 !important;
        margin-left: 5px !important;
        font-size: 0.875rem !important;
        transition: border-color 0.3s ease !important, box-shadow 0.3s ease !important;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #007bff !important;
        box-shadow: 0 0 0 2px rgba(38, 143, 255, 0.25) !important;
        outline: none !important;
    }
</style>

@endpush


@push('scripts')
<!-- jQuery (necessary for DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

<script>
$(document).ready(function() {
    $('#usersTable').DataTable({
        paging: true,   // Enable pagination
        searching: true // Enable search box
    });
});
</script>
@endpush
