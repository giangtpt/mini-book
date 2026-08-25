@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Thêm Thể loại</h1>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST" class="book-form">
        @csrf
        <label>Tên thể loại <span class="required">*</span></label>
        <input type="text" name="name" value="{{ old('name') }}" required>
        <button type="submit">Lưu</button>
        <a href="{{ route('categories.index') }}">Hủy</a>
    </form>
</div>
@endsection