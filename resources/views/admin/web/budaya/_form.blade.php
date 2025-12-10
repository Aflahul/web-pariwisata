<div class="mb-3">
    <label class="form-label">Kategori / Jenis Budaya</label>
    <select name="jenis" class="form-select" required>
        <option value="">-- Pilih Jenis --</option>

        @php
            $listJenis = [
                'tradisi' => 'Tradisi',
                'adat' => 'Adat & Upacara',
                'tarian' => 'Tarian',
                'musik' => 'Musik / Seni Pertunjukan',
                'kuliner' => 'Kuliner',
                'kerajinan' => 'Kerajinan',
                'sejarah' => 'Sejarah & Cerita Lokal',
            ];
        @endphp

        @foreach ($listJenis as $k => $v)
            <option value="{{ $k }}" {{ old('jenis', $budaya->jenis ?? '') == $k ? 'selected' : '' }}>
                {{ $v }}
            </option>
        @endforeach
    </select>

    @error('jenis')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Judul Budaya</label>
    <input type="text" name="judul" class="form-control" value="{{ old('judul', $budaya->judul ?? '') }}" required>

    @error('judul')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Ringkasan</label>
    <input type="text" name="ringkasan" class="form-control" value="{{ old('ringkasan', $budaya->ringkasan ?? '') }}"
        required>

    @error('ringkasan')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Deskripsi Lengkap</label>
    <textarea name="deskripsi" class="form-control" rows="6" required>{{ old('deskripsi', $budaya->deskripsi ?? '') }}</textarea>

    @error('deskripsi')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Lokasi (opsional)</label>
    <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $budaya->lokasi ?? '') }}">

    @error('lokasi')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Gambar Utama</label>
    <input type="file" name="gambar" class="form-control">

    @isset($budaya)
        <div class="mt-2">
            <img src="{{ asset('storage/' . $budaya->gambar) }}" class="img-thumbnail" width="150">
        </div>
    @endisset

    @error('gambar')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
        <option value="1" {{ old('status', $budaya->status ?? '') == 1 ? 'selected' : '' }}>Publish</option>
        <option value="0" {{ old('status', $budaya->status ?? '') == 0 ? 'selected' : '' }}>Draft</option>
    </select>

    @error('status')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
