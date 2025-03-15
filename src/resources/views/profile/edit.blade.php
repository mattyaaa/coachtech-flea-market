@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile/edit.css') }}">
@endsection

@section('content')
<div class="profile-edit-container">
    <h2 class="profile-edit-title">プロフィール設定</h2>
    <form action="/mypage/profile" method="POST" enctype="multipart/form-data" class="profile-edit-form">
        @csrf
        @method('PUT')
        
        <div class="form-group profile-edit-image-group">
            <img id="profile-image-preview" src="{{ asset('storage/' . $profile->profile_image) }}" alt="プロフィール画像" class="profile-edit-image mb-2">
            <label class="btn btn-primary profile-edit-image-btn" for="profile_image">
                画像を選択する
                <input type="file" class="form-control-file profile-edit-file-input" id="profile_image" name="profile_image" style="display: none;" onchange="previewImage(event)">
            </label>
             @error('profile_image')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group profile-edit-field-group">
            <label for="name" class="profile-edit-label">ユーザー名</label>
            <input type="text" class="form-control profile-edit-input" id="name" name="name" value="{{ old('name', $profile->name) }}" required autocomplete="name">
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group profile-edit-field-group">
            <label for="postal_code" class="profile-edit-label">郵便番号</label>
            <input type="text" class="form-control profile-edit-input" id="postal_code" name="postal_code" value="{{ old('postal_code', $profile->postal_code) }}" required autocomplete="postal-code">
            @error('postal_code')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group profile-edit-field-group">
            <label for="address" class="profile-edit-label">住所</label>
            <input type="text" class="form-control profile-edit-input" id="address" name="address" value="{{ old('address', $profile->address) }}" required autocomplete="street-address">
            @error('address')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group profile-edit-field-group">
            <label for="building" class="profile-edit-label">建物名</label>
            <input type="text" class="form-control profile-edit-input" id="building" name="building_name" value="{{ old('building_name', $profile->building_name) }}" autocomplete="address-line2">
            @error('building')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <button type="submit" class="btn btn-primary profile-edit-submit-btn">更新する</button>
    </form>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('profile-image-preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        document.getElementById('profile_image').addEventListener('change', previewImage);
    });
</script>