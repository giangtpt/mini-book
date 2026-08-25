@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sửa Sách</h1>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('books.update', $book) }}" method="POST" class="book-form">
        @csrf
        @method('PUT')

        <label>Tên sách <span class="required">*</span></label>
        <input type="text" name="title" value="{{ old('title', $book->title) }}" required>

        <label>Tác giả <span class="required">*</span></label>
        <input type="text" name="author" value="{{ old('author', $book->author) }}" required>

        <label>Thể loại <span class="required">*</span></label>
        <select name="category_id" required>
            <option value="">-- Chọn thể loại --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <label>Mô tả</label>
        <textarea name="description">{{ old('description', $book->description) }}</textarea>

        <label>Năm xuất bản</label>
        <input type="number" name="published_year" value="{{ old('published_year', $book->published_year) }}">

        <label>Trạng thái <span class="required">*</span></label>
        <select name="status" required>
            @foreach (['Want to Read', 'Reading', 'Read'] as $status)
                <option value="{{ $status }}" {{ old('status', $book->status) == $status ? 'selected' : '' }}>
                    {{ $status }}
                </option>
            @endforeach
        </select>

        <button type="submit">Cập nhật</button>
        <a href="{{ route('books.index') }}">Hủy</a>
    </form>
</div>
@endsection