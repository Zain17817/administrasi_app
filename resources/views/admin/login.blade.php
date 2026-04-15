@extends('layouts.app')

@section('title', 'Login Admin')

@section('content')
    <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4"><i class="fas fa-user-shield"></i> Login Admin</h2>
        @if(session('error'))
            <div class="bg-red-100 text-red-800 p-3 rounded-lg mb-4">{{ session('error') }}</div>
        @endif
        <form action="{{ route('admin.login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block font-medium text-gray-700">Username</label>
                <input type="text" name="username" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block font-medium text-gray-700">Password</label>
                <input type="password" name="password" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
            </div>
            <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 rounded-xl">Login</button>
        </form>
    </div>
@endsection