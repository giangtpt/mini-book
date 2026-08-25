@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sửa Thể loại</h1>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.update', $category) }}" method="POST" class="book-form">
        @csrf
        @method('PUT')
        <label>Tên thể loại <span class="required">*</span></label>
        <input type="text" name="name" value="{{ old('name', $category->name) }}" required>
        <button type="submit">Cập nhật</button>
        <a href="{{ route('categories.index') }}">Hủy</a>
    </form>
</div>
@endsection