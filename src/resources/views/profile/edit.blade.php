@extends('layouts.app')

@section('content')
<div class="container">
    <h2>プロフィール設定</h2>
    <form action="/mypage/profile" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group text-center">
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像" class="mb-2" style="max-width: 150px;">
            <div>
                <label class="btn btn-primary" for="profile_image">
                    画像を選択する
                    <input type="file" class="form-control-file" id="profile_image" name="profile_image" style="display: none;">
                </label>
            </div>
        </div>
        
        <div class="form-group">
            <label for="name">ユーザー名</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        </div>
        
        <div class="form-group">
            <label for="postal_code">郵便番号</label>
            <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" required>
        </div>
        
        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $user->address) }}" required>
        </div>
        
        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" class="form-control" id="building" name="building" value="{{ old('building', $user->building) }}">
        </div>
        
        <button type="submit" class="btn btn-primary">更新する</button>
    </form>
</div>
@endsection