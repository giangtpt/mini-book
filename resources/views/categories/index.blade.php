@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Danh sách Thể loại</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <a href="{{ route('categories.create') }}" class="btn">
            + Thêm thể loại
        </a>

        <table>
            <thead>
                <tr>
                    <th>Tên thể loại</th>
                    <th>Số sách</th>
                    <th>Hành động</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>

                        <td>{{ $category->books_count }}</td>

                        <td>
                            <a href="{{ route('categories.edit', $category) }}">
                                Sửa
                            </a>

                            <button
                                type="button"
                                onclick="openDeleteModal(
                                    '{{ $category->id }}',
                                    '{{ addslashes($category->name) }}'
                                )"
                                style="
                                    background: none;
                                    border: none;
                                    color: #d92d20;
                                    font-weight: 500;
                                    cursor: pointer;
                                "
                            >
                                Xóa
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $categories->links('pagination.custom') }}
    </div>

    <div class="modal-overlay" id="deleteModal">
        <div class="modal-box">
            <h3>Xác nhận xóa thể loại</h3>

            <p>
                Bạn có chắc muốn xóa thể loại
                <strong id="deleteCategoryName"></strong>
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
        function openDeleteModal(categoryId, categoryName) {
            document.getElementById('deleteCategoryName').textContent =
                '"' + categoryName + '"';

            document.getElementById('deleteForm').action =
                '/categories/' + categoryId;

            document.getElementById('deleteModal').classList.add('active');
        }

        function closeDeleteModal() {
            document
                .getElementById('deleteModal')
                .classList.remove('active');
        }
    </script>
@endsection