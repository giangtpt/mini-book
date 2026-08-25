<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mini Book Management</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            margin: 0;
            background: #f6f7fb;
            color: #1f2328;
            -webkit-font-smoothing: antialiased;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 32px 24px;
        }

        .main-nav {
            background: linear-gradient(135deg, #1f2937, #111827);
            padding: 18px 28px;
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .main-nav a {
            color: #d1d5db;
            text-decoration: none;
            font-weight: 500;
            font-size: 15px;
            transition: color 0.2s ease;
        }

        .main-nav a:hover {
            color: #fff;
        }

        .main-nav a:first-child {
            font-weight: 700;
            color: #fff;
            font-size: 16px;
        }

        h1 {
            font-size: 25px;
            font-weight: 700;
            margin: 0 0 22px;
            letter-spacing: -0.02em;
        }

        .alert-success,
        .alert-error {
            padding: 13px 16px;
            border-radius: 10px;
            margin: 0 0 18px;
            font-size: 14px;
            border: 1px solid transparent;
        }

        .alert-success {
            background: #ecfdf3;
            color: #027a48;
            border-color: #abefc6;
        }

        .alert-error {
            background: #fef3f2;
            color: #b42318;
            border-color: #fda29b;
        }

        .alert-error ul {
            margin: 0;
            padding-left: 18px;
        }

        .btn {
            display: inline-block;
            padding: 11px 20px;
            background: #4f46e5;
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition:
                transform 0.15s ease,
                box-shadow 0.15s ease,
                background 0.15s ease;
            box-shadow: 0 1px 2px rgba(79, 70, 229, 0.3);
        }

        .btn:hover {
            background: #4338ca;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.35);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow:
                0 1px 2px rgba(16, 24, 40, 0.05),
                0 1px 3px rgba(16, 24, 40, 0.06);
        }

        th,
        td {
            padding: 14px 18px;
            text-align: left;
            font-size: 14px;
        }

        th {
            background: #f9fafb;
            color: #6b7280;
            font-weight: 600;
            font-size: 11.5px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        tbody tr {
            border-top: 1px solid #f0f1f3;
            transition: background 0.15s ease;
        }

        tbody tr:hover {
            background: #fafbff;
        }

        td a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: 600;
            margin-right: 14px;
        }

        td a:hover {
            text-decoration: underline;
        }

        td button {
            background: none;
            border: none;
            color: #d92d20;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            padding: 0;
        }

        td button:hover {
            text-decoration: underline;
        }

        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 20px 0;
            background: #fff;
            padding: 16px;
            border-radius: 14px;
            box-shadow:
                0 1px 2px rgba(16, 24, 40, 0.05),
                0 1px 3px rgba(16, 24, 40, 0.06);
        }

        .filter-bar input,
        .filter-bar select {
            padding: 10px 13px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            background: #f9fafb;
            transition: border-color 0.15s ease;
        }

        .filter-bar input:focus,
        .filter-bar select:focus {
            outline: none;
            border-color: #4f46e5;
            background: #fff;
        }

        .filter-bar button {
            padding: 10px 18px;
            background: #1f2937;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s ease;
        }

        .filter-bar button:hover {
            background: #111827;
        }

        .filter-bar a {
            align-self: center;
            font-size: 14px;
            color: #6b7280;
            text-decoration: none;
        }

        .filter-bar a:hover {
            text-decoration: underline;
        }

        .book-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            margin-top: 20px;
        }

        .book-card {
            background: #fff;
            border-radius: 16px;
            padding: 20px;
            flex: 1 1 280px;
            max-width: 320px;
            box-shadow:
                0 1px 2px rgba(16, 24, 40, 0.05),
                0 1px 3px rgba(16, 24, 40, 0.06);
            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease;
            border-top: 3px solid #4f46e5;
        }

        .book-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(16, 24, 40, 0.1);
        }

        .book-card h3 {
            margin: 0 0 12px;
            font-size: 17px;
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        .book-card p {
            margin: 5px 0;
            font-size: 13.5px;
            color: #4b5563;
            line-height: 1.5;
        }

        .book-card p strong {
            color: #1f2328;
            font-weight: 600;
        }

        .book-actions {
            display: flex;
            gap: 16px;
            margin-top: 16px;
            padding-top: 14px;
            border-top: 1px solid #f0f1f3;
        }

        .book-actions a {
            color: #4f46e5;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 600;
        }

        .book-actions a:hover {
            text-decoration: underline;
        }

        .book-actions form button {
            background: none;
            border: none;
            color: #d92d20;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            padding: 0;
        }

        .book-actions form button:hover {
            text-decoration: underline;
        }

        .book-form {
            display: flex;
            flex-direction: column;
            gap: 6px;
            max-width: 480px;
            background: #fff;
            padding: 28px;
            border-radius: 16px;
            box-shadow:
                0 1px 2px rgba(16, 24, 40, 0.05),
                0 1px 3px rgba(16, 24, 40, 0.06);
        }

        .book-form label {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-top: 10px;
        }

        .required {
            color: #d92d20;
            margin-left: 2px;
        }

        .book-form input,
        .book-form select,
        .book-form textarea {
            padding: 11px 13px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            background: #f9fafb;
            transition: border-color 0.15s ease;
        }

        .book-form input:focus,
        .book-form select:focus,
        .book-form textarea:focus {
            outline: none;
            border-color: #4f46e5;
            background: #fff;
        }

        .book-form textarea {
            min-height: 90px;
            resize: vertical;
        }

        .book-form button {
            margin-top: 18px;
            padding: 12px;
            background: #4f46e5;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s ease;
        }

        .book-form button:hover {
            background: #4338ca;
        }

        .book-form a {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
            color: #6b7280;
            text-decoration: none;
        }

        .book-form a:hover {
            text-decoration: underline;
        }

        nav[role="navigation"] {
            margin-top: 24px;
            display: flex;
            justify-content: center;
        }

        nav[role="navigation"] span,
        nav[role="navigation"] a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 10px;
            margin: 0 3px;
            border-radius: 8px;
            font-size: 13.5px;
            text-decoration: none;
            color: #4b5563;
            background: #fff;
            border: 1px solid #e5e7eb;
            transition: background 0.15s ease;
        }

        nav[role="navigation"] a:hover {
            background: #f3f4f6;
        }

        nav[role="navigation"] span[aria-current="page"] span {
            background: #4f46e5 !important;
            color: #fff !important;
            border: none;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(17, 24, 39, 0.5);
            align-items: center;
            justify-content: center;
            z-index: 100;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-box {
            background: #fff;
            border-radius: 14px;
            padding: 28px;
            max-width: 380px;
            width: 90%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .modal-box h3 {
            margin: 0 0 12px;
            font-size: 18px;
        }

        .modal-box p {
            margin: 0 0 20px;
            font-size: 14px;
            color: #4b5563;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
        }

        .modal-actions button,
        .modal-actions a {
            flex: 1;
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            border: none;
        }

        .modal-btn-cancel {
            background: #f3f4f6;
            color: #374151;
        }

        .modal-btn-danger {
            background: #d92d20;
            color: #fff;
        }

        @media (max-width: 600px) {
            .book-grid {
                flex-direction: column;
            }

            .book-card {
                max-width: 100%;
            }

            .main-nav {
                gap: 18px;
                padding: 16px 20px;
            }
        }
    </style>
</head>

<body>

    <nav class="main-nav">
        <a href="{{ route('books.index') }}">📚 Mini Book</a>
        <a href="{{ route('books.index') }}">Sách</a>
        <a href="{{ route('categories.index') }}">Thể loại</a>
    </nav>

    <div class="container">
        @yield('content')
    </div>

</body>

</html>