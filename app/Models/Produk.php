<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    use HasFactory;

    /**
     * Nama tabel eksplisit — mencegah Laravel auto-pluralize ke 'produks'.
     */
    protected $table = 'produk';

    /**
     * Kolom yang boleh diisi secara massal.
     *
     * @var list<string>
     */
    protected $fillable = [
        'penjual_id',
        'kategori_id',
        'nama',
        'slug',
        'deskripsi',
        'harga',
        'stok',
        'label_promosi',
        'foto_utama',
        'status',
        'views',
    ];

    /**
     * Cast tipe data kolom.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'harga' => 'decimal:2',
        ];
    }

    // ─── Relasi ───────────────────────────────────────────────────────────────

    /**
     * Produk dimiliki oleh satu Penjual.
     */
    public function penjual(): BelongsTo
    {
        return $this->belongsTo(Penjual::class);
    }

    /**
     * Produk termasuk dalam satu Kategori.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    /**
     * Satu Produk memiliki banyak Ulasan.
     */
    public function ulasan(): HasMany
    {
        return $this->hasMany(Ulasan::class);
    }

    /**
     * Rata-rata rating dari ulasan yang disetujui.
     */
    public function getAverageRatingAttribute(): float
    {
        return (float) $this->ulasan()->where('status', 'disetujui')->avg('rating') ?: 0.0;
    }

    /**
     * Jumlah ulasan yang disetujui.
     */
    public function getReviewCountAttribute(): int
    {
        return $this->ulasan()->where('status', 'disetujui')->count();
    }
}
