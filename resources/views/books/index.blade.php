@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Danh sách Sách</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('books.create') }}" class="btn">
            + Thêm sách
        </a>

        <form
            method="GET"
            action="{{ route('books.index') }}"
            class="filter-bar"
        >
            <input
                type="text"
                name="search"
                placeholder="Tìm theo tên sách..."
                value="{{ request('search') }}"
            >

            <select name="category_id">
                <option value="">
                    -- Tất cả thể loại --
                </option>

                @foreach ($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        {{ request('category_id') == $category->id ? 'selected' : '' }}
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <select name="status">
                <option value="">
                    -- Tất cả trạng thái --
                </option>

                @foreach (['Want to Read', 'Reading', 'Read'] as $status)
                    <option
                        value="{{ $status }}"
                        {{ request('status') == $status ? 'selected' : '' }}
                    >
                        {{ $status }}
                    </option>
                @endforeach
            </select>

            <button type="submit">
                Lọc
            </button>

            <a href="{{ route('books.index') }}">
                Xóa lọc
            </a>
        </form>

        <div class="book-grid">
            @forelse ($books as $book)
                <div class="book-card">
                    <h3>{{ $book->title }}</h3>

                    <p>
                        <strong>Tác giả:</strong>
                        {{ $book->author }}
                    </p>

                    <p>
                        <strong>Thể loại:</strong>
                        {{ $book->category->name }}
                    </p>

                    <p>
                        <strong>Trạng thái:</strong>
                        {{ $book->status }}
                    </p>

                    <div class="book-actions">
                        <a href="{{ route('books.show', $book) }}">
                            Xem
                        </a>

                        <a href="{{ route('books.edit', $book) }}">
                            Sửa
                        </a>

                        <button
                            type="button"
                            onclick="openDeleteModal(
                                '{{ $book->id }}',
                                '{{ addslashes($book->title) }}'
                            )"
                            style="
                                background: none;
                                border: none;
                                color: #d92d20;
                                font-size: 13.5px;
                                font-weight: 600;
                                cursor: pointer;
                                padding: 0;
                            "
                        >
                            Xóa
                        </button>
                    </div>
                </div>
            @empty
                <p>Không có sách nào.</p>
            @endforelse
        </div>

        {{ $books->links('pagination.custom') }}
    </div>

    <div class="modal-overlay" id="deleteModal">
        <div class="modal-box">
            <h3>Xác nhận xóa sách</h3>

            <p>
                Bạn có chắc muốn xóa sách
                <strong id="deleteBookTitle"></strong>
                không?
            </p>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')

                <div class="modal-actions">
                    <button
                        type="button"
                        class="modal-btn-cancel"
                        onclick="closeDeleteModal()"
                    >
                        Hủy
                    </button>

                    <button
                        type="submit"
                        class="modal-btn-danger"
                    >
                        Xác nhận xóa
                    </button>
                </div>
            </form>
        </div>
    </div>

<script>
    function openDeleteModal(bookId, bookTitle) {
        document.getElementById('deleteBookTitle').textContent =
            '"' + bookTitle + '"';

        document.getElementById('deleteForm').action =
            '/books/' + bookId;

        document.getElementById('deleteModal').classList.add('active');
    }

    function closeDeleteModal() {
        document
            .getElementById('deleteModal')
            .classList.remove('active');
    }
</script>
@endsection