<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Pesan Validasi Bahasa Indonesia
    |--------------------------------------------------------------------------
    */

    'accepted'             => 'Isian :attribute harus diterima.',
    'active_url'           => 'Isian :attribute bukan URL yang valid.',
    'after'                => 'Isian :attribute harus tanggal setelah :date.',
    'after_or_equal'       => 'Isian :attribute harus tanggal setelah atau sama dengan :date.',
    'alpha'                => 'Isian :attribute hanya boleh berupa huruf.',
    'alpha_dash'           => 'Isian :attribute hanya boleh berupa huruf, angka, tanda hubung, dan garis bawah.',
    'alpha_num'            => 'Isian :attribute hanya boleh berupa huruf dan angka.',
    'array'                => 'Isian :attribute harus berupa array.',
    'before'               => 'Isian :attribute harus tanggal sebelum :date.',
    'before_or_equal'      => 'Isian :attribute harus tanggal sebelum atau sama dengan :date.',
    'between'              => [
        'numeric' => 'Isian :attribute harus antara :min dan :max.',
        'file'    => 'Ukuran file :attribute harus antara :min dan :max kilobyte.',
        'string'  => 'Isian :attribute harus antara :min dan :max karakter.',
        'array'   => 'Isian :attribute harus memiliki :min sampai :max item.',
    ],
    'boolean'              => 'Isian :attribute harus benar atau salah.',
    'confirmed'            => 'Konfirmasi :attribute tidak cocok.',
    'date'                 => 'Isian :attribute bukan tanggal yang valid.',
    'date_format'          => 'Isian :attribute tidak cocok dengan format :format.',
    'different'            => 'Isian :attribute dan :other harus berbeda.',
    'digits'               => 'Isian :attribute harus terdiri dari :digits digit.',
    'digits_between'       => 'Isian :attribute harus antara :min dan :max digit.',
    'dimensions'           => 'Isian :attribute memiliki dimensi gambar tidak valid.',
    'distinct'             => 'Isian :attribute memiliki nilai duplikat.',
    'email'                => 'Isian :attribute harus berupa alamat email valid.',
    'exists'               => 'Isian :attribute tidak valid.',
    'file'                 => 'Isian :attribute harus berupa file.',
    'filled'               => 'Isian :attribute harus diisi.',
    'image'                => 'Isian :attribute harus berupa gambar.',
    'in'                   => 'Isian :attribute tidak valid.',
    'in_array'             => 'Isian :attribute tidak ada di :other.',
    'integer'              => 'Isian :attribute harus berupa angka bulat.',
    'ip'                   => 'Isian :attribute harus berupa alamat IP.',
    'json'                 => 'Isian :attribute harus berupa JSON valid.',
    'max'                  => [
        'numeric' => 'Isian :attribute tidak boleh lebih dari :max.',
        'file'    => 'Ukuran file :attribute tidak boleh lebih dari :max kilobyte.',
        'string'  => 'Isian :attribute tidak boleh lebih dari :max karakter.',
        'array'   => 'Isian :attribute tidak boleh lebih dari :max item.',
    ],
    'mimes'                => 'File :attribute harus bertipe: :values.',
    'mimetypes'            => 'File :attribute harus bertipe: :values.',
    'min'                  => [
        'numeric' => 'Isian :attribute minimal :min.',
        'file'    => 'Ukuran file :attribute minimal :min kilobyte.',
        'string'  => 'Isian :attribute minimal :min karakter.',
        'array'   => 'Isian :attribute minimal memiliki :min item.',
    ],
    'not_in'               => 'Isian :attribute tidak valid.',
    'numeric'              => 'Isian :attribute harus berupa angka.',
    'present'              => 'Isian :attribute harus ada.',
    'regex'                => 'Format isian :attribute tidak valid.',
    'required'             => 'Kolom :attribute wajib diisi.',
    'required_if'          => 'Kolom :attribute wajib diisi bila :other adalah :value.',
    'required_unless'      => 'Kolom :attribute wajib diisi kecuali :other ada dalam :values.',
    'required_with'        => 'Kolom :attribute wajib diisi bila terdapat :values.',
    'required_with_all'    => 'Kolom :attribute wajib diisi bila terdapat :values.',
    'required_without'     => 'Kolom :attribute wajib diisi bila tidak terdapat :values.',
    'required_without_all' => 'Kolom :attribute wajib diisi bila tidak satupun dari :values ada.',
    'same'                 => 'Isian :attribute dan :other harus sama.',
    'size'                 => [
        'numeric' => 'Isian :attribute harus berukuran :size.',
        'file'    => 'Ukuran file :attribute harus :size kilobyte.',
        'string'  => 'Isian :attribute harus berjumlah :size karakter.',
        'array'   => 'Isian :attribute harus mengandung :size item.',
    ],
    'string'               => 'Isian :attribute harus berupa teks.',
    'timezone'             => 'Isian :attribute harus berupa zona waktu valid.',
    'unique'               => 'Isian :attribute sudah digunakan.',
    'uploaded'             => 'Gagal mengunggah :attribute.',
    'url'                  => 'Format :attribute tidak valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Nama Kolom
    |--------------------------------------------------------------------------
    */

    'attributes' => [
        'nama'      => 'nama',
        'kategori'  => 'kategori',
        'lokasi'    => 'lokasi',
        'maps_url'  => 'link Google Maps',
        'gambar'    => 'gambar',
        'gambar.*'  => 'file gambar',
        'deskripsi' => 'deskripsi',
        'kontak'    => 'kontak',
        'judul'     => 'judul',
        'file_path' => 'file gambar',
        'video_url' => 'URL video',
        'alamat'    => 'alamat',
    ],

];
