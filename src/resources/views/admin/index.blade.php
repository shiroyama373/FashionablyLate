@extends('layouts.app')

@section('title', 'お問い合わせ管理画面')

@section('header-links')
<form method="POST" action="{{ route('logout') }}" class="logout-form">
    @csrf
    <button type="submit" class="link-button">logout</button>
</form>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="admin-container">
    <h1>Admin</h1>

    {{-- 検索フォーム --}}
    <form method="GET" action="{{ route('admin.contacts.index') }}" class="search-form">
        <div class="search-group">
            <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="名前やメールアドレスを入力してください">

            <select name="gender">
                <option value="">性別</option>
                <option value="男性" @selected(request('gender') === '男性')>男性</option>
                <option value="女性" @selected(request('gender') === '女性')>女性</option>
                <option value="その他" @selected(request('gender') === 'その他')>その他</option>
            </select>

            <select name="category">
                <option value="">お問い合わせの種類</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>

            <input type="date" name="date" value="{{ request('date') }}">

            <button type="submit" class="btn-search">検索</button>
            <a href="{{ route('admin.contacts.index') }}" class="btn-reset">リセット</a>
        </div>
    </form>

    {{-- エクスポートボタンとページネーション --}}
    <div class="actions-wrapper">
        <form method="GET" action="{{ route('admin.export') }}" class="export-form">
            <input type="hidden" name="keyword" value="{{ request('keyword') }}">
            <input type="hidden" name="gender" value="{{ request('gender') }}">
            <input type="hidden" name="category" value="{{ request('category') }}">
            <input type="hidden" name="date" value="{{ request('date') }}">
            <button type="submit" class="btn btn-export">エクスポート</button>
        </form>

        <div class="pagination-wrapper">
            {{ $contacts->links() }}
        </div>
    </div>

    {{-- 一覧テーブル --}}
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>お名前</th>
                    <th>性別</th>
                    <th>メールアドレス</th>
                    <th>お問い合せの種類</th>
                    <th>詳細</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contacts as $contact)
                <tr>
                    <td>{{ $contact->last_name }} {{ $contact->first_name }}</td>
                    <td>{{ $contact->gender }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->category->name ?? '' }}</td>
                    <td>
                        <button type="button" class="btn btn-info btn-sm btn-detail" data-id="{{ $contact->id }}">
                            詳細
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


{{-- モーダルウィンドウ --}}
    <div id="modal-overlay" class="modal-overlay" style="display:none;">
        <div class="modal-content">
        <button class="modal-close">&times;</button>
            <div id="modal-body">読み込み中...</div>
        </div>
    </div>

    {{-- 削除確認モーダルウィンドウ --}}
<div id="delete-modal-overlay" class="modal-overlay" style="display:none;">
    <div class="modal-content">
        <div class="modal-body-content" style="text-align: center;">
            <h3>本当に削除しますか？</h3>
            <p>この操作は元に戻せません。</p>
            <div class="modal-actions">
                <form id="delete-form" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn-cancel" style="background-color: #ccc; color: #333; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-right: 10px;">
                        キャンセル
                    </button>
                    <button type="button" class="delete-btn">削除</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // モーダル要素の取得
    const detailModal = document.getElementById('modal-overlay');
    const deleteModal = document.getElementById('delete-modal-overlay');
    const detailModalBody = document.getElementById('modal-body');
    const deleteForm = document.getElementById('delete-form');
    
    // 詳細モーダルと削除確認モーダルを閉じるためのボタン
    document.querySelectorAll('.modal-close').forEach(closeBtn => {
        closeBtn.addEventListener('click', () => {
            detailModal.style.display = 'none';
            deleteModal.style.display = 'none';
        });
    });

     // モーダル外をクリックして閉じる処理
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', e => {
            if (e.target === overlay) {
                detailModal.style.display = 'none';
                deleteModal.style.display = 'none';
            }
        });
    });

    // 詳細ボタンをクリックしたときの処理
    document.querySelectorAll('.btn-detail').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const url = `/admin/contacts/${id}`;

            // 詳細モーダルにコンテンツをロード
            fetch(url)
                .then(res => res.text())
                .then(html => {
                    detailModalBody.innerHTML = html;
                    detailModal.style.display = 'flex';
                });
        });
    });

    // 削除ボタン（動的コンテンツ対応）
    document.addEventListener('click', function(e) {
        if (e.target.matches('.delete-btn')) {
            e.preventDefault();

            const isDeleteModalButton = e.target.closest('#delete-modal-overlay');

            if (isDeleteModalButton) {
                // 削除確認モーダル内の「削除」ボタンがクリックされた場合
                document.getElementById('delete-form').submit(); // フォームを送信
            } else {
                // 詳細モーダルから「削除」ボタンがクリックされた場合
                const id = e.target.dataset.id;
                deleteForm.action = `/admin/contacts/${id}`;
                detailModal.style.display = 'none';
                deleteModal.style.display = 'flex';
            }
        }
    });
// 削除確認モーダルのキャンセル
const cancelButton = deleteModal.querySelector('.btn-cancel');
    cancelButton.addEventListener('click', () => {
        deleteModal.style.display = 'none';
    });



    // エクスポートボタン：検索条件をコピー
    const exportButton = document.querySelector('.btn-export');
    if (exportButton) {
        exportButton.addEventListener('click', function() {
            const searchForm = document.querySelector('.search-form');
            const exportForm = document.querySelector('.export-form');
            exportForm.keyword.value = searchForm.keyword.value;
            exportForm.gender.value = searchForm.gender.value;
            exportForm.category.value = searchForm.category.value;
            exportForm.date.value = searchForm.date.value;
        });
    }
});
</script>
@endsection