@extends('admin.admin')

@section('styles')

<style>
    body, .container, .sidebar, #messages {
        background-color: #FEFAE0;
    }

    html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    overflow: hidden; /* Biar gak muncul scroll page */
}

    .container {
          height: 100vh;
        max-width: 1200px;
          margin: 0;
        margin-top: 20px;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .row {
        display: flex;
        height: 100%;
    margin: 0;
    }

    .sidebar {
            height: 100%;
        width: 260px;
        padding: 20px;
        border-right: 1px solid #e5e7eb;
        overflow-y: auto;
    }

    .content-area {
        flex: 1;
         padding: 0;
    display: flex;
    flex-direction: column;
        background-color: #fff;
        box-shadow: inset 0 0 10px rgba(0,0,0,0.05);
        height: 100%;
    }

    h5 {
        font-weight: 600;
        margin-bottom: 15px;
        color: #1A3636;
    }

    #users {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .user-item {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 10px 12px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #1A3636;
        text-decoration: none;
        transition: all 0.2s ease-in-out;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .user-item:hover {
        background-color: #f1f5f9;
        border-color: #cbd5e1;
    }

    .user-item.active {
        background-color: #40534C;
        border-color: #F2EED7;
        font-weight: 600;
    }

    .avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #cbd5e1;
    }

    .chat-header {
        display: flex;
        align-items: center;
        padding: 15px;
        background-color: #fff;
        border-bottom: 1px solid #eee;
    }

    #messages {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .message {
        display: flex;
        width: 100%;
    }

    .message-bubble {
        max-width: 65%;
        padding: 12px 18px;
        border-radius: 20px;
        font-size: 0.95rem;
        position: relative;
        word-wrap: break-word;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        animation-duration: 0.3s;
        animation-fill-mode: both;
    }

    .message-bubble.user {
        background-color: #ffffff;
        color: #1e293b;
        border-top-left-radius: 4px;
        align-self: flex-start;
        border: 1px solid #e2e8f0;
        animation: bubbleInLeft 0.3s ease-out;
    }

    .message-bubble.admin {
        background-color: #1A3636;
        color: #ffffff;
        border-top-right-radius: 4px;
        align-self: flex-end;
        border: 1px solid #1A3636;
        animation: bubbleInRight 0.3s ease-out;
    }

    .message-bubble small {
        font-size: 0.7rem;
        color: #cbd5e1;
        margin-top: 6px;
        display: block;
        text-align: right;
    }

    .input-area {
        display: flex;
        padding: 12px 16px;
        background-color: #f8fafc;
        border-top: 1px solid #e5e7eb;
    }

    .form-control {
        border-radius: 25px;
        padding: 10px 16px;
        border: 1px solid #cbd5e1;
        flex: 1;
        margin-right: 12px;
        background-color: #fff;
        box-shadow: none;
    }

    .btn-primary {
        border-radius: 25px;
        padding: 10px 22px;
        background-color: #1A3636;
        border: none;
        color: #fff;
        font-weight: 500;
    }

    .btn-primary:hover {
        background-color: #162e2e;
    }

    .message-options {
        top: 8px;
        right: 12px;
    }

    .dropdown-menu {
        font-size: 0.85rem;
        min-width: 140px;
    }

    @keyframes bubbleInLeft {
        0% { opacity: 0; transform: translateX(-20px) scale(0.95); }
        100% { opacity: 1; transform: translateX(0) scale(1); }
    }

    @keyframes bubbleInRight {
        0% { opacity: 0; transform: translateX(20px) scale(0.95); }
        100% { opacity: 1; transform: translateX(0) scale(1); }
    }

    @media (max-width: 768px) {
        .row {
            flex-direction: column;
            height: auto;
        }

        .sidebar {
            width: 100%;
            border-right: none;
            border-bottom: 1px solid #ffffff;
        }
        .content-area {
            height: auto;
        }
        
        #messages {
            max-height: 300px;
        }
    }
    
    input[type="file"].form-control {
        padding: 8px 12px;
        border-radius: 25px;
        border: 1px solid #cbd5e1;
        background-color: #fff;
        font-size: 14px;
        color: #1e293b;
        height: auto;
        box-shadow: none;
        line-height: 1.5;
        max-width: 200px;
        flex-shrink: 0;
    }
    
    </style>

@section('content')
<div class="container-fluid">
    <div class="row" style="height: 100vh;">
        <!-- Sidebar User -->
        <div class="col-md-3 bg-light p-3" style="overflow-y: auto;">
            <h5>Daftar Pengguna</h5>
            <div id="users">
                @foreach($pengguna as $user)
                    <a href="{{ route('admin.cs.index', $user->id_pengguna) }}" class="user-item {{ $selected_pengguna && $user->id_pengguna == $selected_pengguna->id_pengguna ? 'active' : '' }}">
                       <img src="{{ asset($user->foto_profil) }}"
     alt="Foto Profil"
     class="avatar"
     onerror="this.onerror=null; this.src='{{ asset('images/user.png') }}';">



                                            
                        <span>{{ $user->username }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Chat Content -->
        <div class="col-md-9 d-flex flex-column p-0">
            @if($selected_pengguna)
                <div class="bg-white p-2 border-bottom d-flex align-items-center">
                    <img src="{{ asset($selected_pengguna->foto_profil) }}"
     alt="Avatar"
     class="avatar"
     width="50"
     height="50"
     onerror="this.onerror=null; this.src='{{ asset('images/icon.png') }}';">


                    <h5 class="ms-2 mb-0">  {{ $selected_pengguna->username }}</h5>
                </div>

                <div id="messages" class="p-3" style="max-height: calc(100vh - 220px); overflow-y: auto;">
                    @foreach($messages as $message)
    <div class="message d-flex {{ $message->sender_name == 'Admin' ? 'justify-content-end' : 'justify-content-start' }}">
        <div class="message-bubble {{ $message->sender_name == 'Admin' ? 'admin' : 'user' }} position-relative">
            
            {{-- Cek apakah pesan ini adalah gambar --}}
            @php
    $path = $message->message;
    $isImage = Str::startsWith($path, 'chat_images/') && preg_match('/\.(jpg|jpeg|png|gif)$/i', $path);
    $isFile = Str::startsWith($path, 'chat_files/');
@endphp

@if($isImage)
    <img src="{{ asset($path) }}" alt="Gambar"
         class="chat-image-thumbnail"
         style="max-width: 200px; border-radius: 8px; cursor: pointer;">
@elseif($isFile)
    <a href="{{ asset($path) }}" target="_blank" style="color: #0d6efd;">
        📄 {{ basename($path) }}
    </a>
@else
    {{ $message->message }}
@endif
            <small>{{ \Carbon\Carbon::parse($message->created_at)->format('d M Y, H:i') }}</small>

            @if($message->sender_name == 'Admin')
            <div class="dropdown message-options" style="position: absolute; top: 5px; right: 10px;">
                <a href="#" class="text-dark" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item copy-message" href="#" data-message="{{ $message->message }}">Salin</a></li>
                    <li><a class="dropdown-item delete-message" href="#" data-id="{{ $message->id }}">Hapus</a></li>
                </ul>
            </div>
            @endif
        </div>
    </div>
@endforeach
<!-- Modal untuk perbesar gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-transparent border-0">
      <div class="modal-body text-center">
        <img id="modalImage" src="" class="img-fluid rounded shadow" alt="Preview Gambar">
      </div>
    </div>
  </div>
</div>


                </div>

                <div class="p-3 border-top bg-light">
    <form id="chat-form" method="POST" action="{{ route('admin.cs.send') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id_pengguna" value="{{ $selected_pengguna->id_pengguna }}">

    <div class="input-group align-items-center gap-2">
        <input type="file" name="upload" id="uploadFile" class="d-none"
            accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.zip,.rar">

        <label for="uploadFile" class="btn btn-outline-secondary d-flex align-items-center justify-content-center"
            style="width: 42px; height: 42px; border-radius: 50%;">
            <i class="fas fa-paperclip"></i>
        </label>

        <input type="text" name="message" id="message-input" class="form-control" placeholder="Ketik pesan...">
        <button type="submit" id="send-message" class="btn btn-secondary">Kirim</button>
    </div>

    <div id="file-preview" style="margin-top: 10px;"></div>
</form>
</div>

    <!-- ✅ Tempat preview muncul -->
    <div id="preview" class="mt-3"></div>
</form>


                    </form>
                </div>
            @else
                <div class="d-flex justify-content-center align-items-center flex-grow-1">
                    <p class="text-muted">Pilih pengguna untuk melihat percakapan.</p>
                </div>
            @endif
        </div>
    </div>
</div>


@if($selected_pengguna)
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;

        const id_pengguna = {{ $selected_pengguna->id_pengguna }};
        const messageInput = document.getElementById('message-input');
        const messageBox = document.getElementById("messages");
        const sendButton = document.getElementById('send-message');
        const uploadInput = document.getElementById('uploadFile');
        const form = document.getElementById('chat-form');
        const previewBox = document.getElementById('file-preview');

        if (sendButton && messageInput) {
            sendButton.addEventListener('click', function (e) {
                e.preventDefault();

                const formData = new FormData(form);

                axios.post(form.action, formData)
                    .then(() => {
                        messageInput.value = '';
                        if (uploadInput) uploadInput.value = '';
                        if (previewBox) previewBox.innerHTML = '';
                        window.location.reload();
                    }).catch(error => {
                        console.error('Gagal kirim pesan:', error.response?.data || error.message);
                        alert('Gagal mengirim pesan.');
                    });
            });
        }

        // Preview file saat dipilih
        if (uploadInput) {
            uploadInput.addEventListener('change', function () {
                const file = uploadInput.files[0];
                previewBox.innerHTML = '';

                if (!file) return;

                const fileType = file.type;
                if (fileType.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.style.maxWidth = '150px';
                    img.style.borderRadius = '8px';
                    img.style.marginTop = '10px';
                    previewBox.appendChild(img);
                } else {
                    previewBox.innerHTML = `<p style="margin-top:10px;">📄 File: ${file.name}</p>`;
                }
            });
        }

        // Scroll ke bawah otomatis saat halaman dimuat
        if (messageBox) {
            messageBox.scrollTop = messageBox.scrollHeight;
        }

        // Copy pesan
        document.querySelectorAll('.copy-message').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const message = this.dataset.message;
                navigator.clipboard.writeText(message).then(() => {
                    alert('Pesan disalin ke clipboard');
                });
            });
        });

        // Hapus pesan
        document.querySelectorAll('.delete-message').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const id = this.dataset.id;

                if (confirm('Yakin ingin menghapus pesan ini?')) {
                    axios.post('/admin/cs/message/delete', { id: id })
                        .then(() => window.location.reload())
                        .catch(error => {
                            console.error(error);
                            alert('Gagal menghapus pesan.');
                        });
                }
            });
        });

        // Modal gambar
        const imageModal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');

        if (imageModal) {
            imageModal.addEventListener('show.bs.modal', function (event) {
                const trigger = event.relatedTarget;
                const imgSrc = trigger.getAttribute('data-img');
                modalImage.src = imgSrc;
            });
        }
    });
</script>


        
@endif
@endsection
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">