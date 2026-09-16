@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="book-detail">
            <h1>{{ $book->title }}</h1>

            <div class="detail-row">
                <span class="detail-label">Tác giả</span>
                <span class="detail-value">{{ $book->author }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Thể loại</span>
                <span class="detail-value">{{ $book->category->name }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Năm xuất bản</span>
                <span class="detail-value">
                    {{ $book->published_year ?? 'Chưa cập nhật' }}
                </span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Trạng thái</span>
                <span class="detail-value">{{ $book->status }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Mô tả</span>
                <span class="detail-value">
                    {{ $book->description ?? 'Không có mô tả' }}
                </span>
            </div>

            <div class="book-actions">
                <a href="{{ route('books.edit', $book) }}">Sửa</a>
                <a href="{{ route('books.index') }}">← Quay lại danh sách</a>
            </div>
        </div>
    </div>
@endsection