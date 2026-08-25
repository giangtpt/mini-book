@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $book->title }}</h1>

        <p>
            <strong>Tác giả:</strong>
            {{ $book->author }}
        </p>

        <p>
            <strong>Thể loại:</strong>
            {{ $book->category->name }}
        </p>

        <p>
            <strong>Năm xuất bản:</strong>
            {{ $book->published_year ?? 'Chưa cập nhật' }}
        </p>

        <p>
            <strong>Trạng thái:</strong>
            {{ $book->status }}
        </p>

        <p>
            <strong>Mô tả:</strong>
            {{ $book->description ?? 'Không có mô tả' }}
        </p>

        <a href="{{ route('books.index') }}">
            ← Quay lại danh sách
        </a>
    </div>
@endsection