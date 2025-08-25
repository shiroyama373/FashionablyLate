<div class="modal-body-content">
    <div class="contact-details-list">
        <div class="detail-item">
            <div class="contact-detail-row">
                <div class="contact-label">お名前</div>
                <div class="contact-value">{{ $contact->last_name }} {{ $contact->first_name }}</div>
            </div>
            <div class="contact-detail-row">
                <div class="contact-label">性別</div>
                <div class="contact-value">{{ $contact->gender }}</div>
            </div>
            <div class="contact-detail-row">
                <div class="contact-label">メールアドレス</div>
                <div class="contact-value">{{ $contact->email }}</div>
            </div>
            <div class="contact-detail-row">
                <div class="contact-label">お問い合わせの種類</div>
                <div class="contact-value">{{ $contact->category->name ?? '未設定' }}</div>
            </div>
            <div class="contact-detail-row">
                <div class="contact-label">住所</div>
                <div class="contact-value">{{ $contact->address }}</div>
            </div>
            <div class="contact-detail-row">
                <div class="contact-label">建物名</div>
                <div class="contact-value">{{ $contact->building }}</div>
            </div>
            <div class="contact-detail-row">
                <div class="contact-label">電話番号</div>
                <div class="contact-value">{{ $contact->tel1 }}-{{ $contact->tel2 }}-{{ $contact->tel3 }}</div>
            </div>
            <div class="contact-detail-row">
                <div class="contact-label">お問い合わせ内容</div>
                <div class="contact-value">{!! nl2br(e($contact->content)) !!}</div>
            </div>
            <div class="contact-detail-row">
                <div class="contact-label">登録日</div>
                <div class="contact-value">{{ $contact->created_at->format('Y年m月d日 H:i') }}</div>
            </div>
        </div>
    </div>
    <div class="modal-actions">
        <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" class="delete-contact">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-btn">
                削除<span>&times;</span>
            </button>
        </form>
    </div>
</div>