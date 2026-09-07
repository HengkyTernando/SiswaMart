<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ulasan extends Model
{
    use HasFactory;

    /**
     * Nama tabel eksplisit — mencegah Laravel auto-pluralize ke 'ulasans'.
     */
    protected $table = 'ulasan';

    /**
     * Kolom yang boleh diisi secara massal.
     *
     * @var list<string>
     */
    protected $fillable = [
        'produk_id',
        'guest_username',
        'rating',
        'komentar',
        'status',
    ];

    /**
     * Cast tipe data kolom.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'rating' => 'integer',
        ];
    }

    // ─── Relasi ───────────────────────────────────────────────────────────────

    /**
     * Ulasan dimiliki oleh satu Produk.
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }
}
