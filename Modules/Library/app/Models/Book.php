<?php

namespace Modules\Library\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Library\Enums\BookStatus;
// use Modules\Library\Database\Factories\BookFactory;

class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'isbn',
        'title',
        'author',
        'publisher',
        'publication_year',
        'edition',
        'category',
        'language',
        'total_copies',
        'available_copies',
        'location_shelf',
        'price',
        'description',
        'cover_image',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'publication_year' => 'integer',
            'total_copies' => 'integer',
            'available_copies' => 'integer',
            'price' => 'decimal:2',
            'status' => BookStatus::class,
        ];
    }

    /**
     * Relationships
     */
    public function borrowings(): HasMany
    {
        return $this->hasMany(BookBorrowing::class);
    }

    public function activeBorrowings(): HasMany
    {
        return $this->hasMany(BookBorrowing::class)
            ->where('status', \Modules\Library\Enums\BorrowingStatus::ACTIVE);
    }

    /**
     * Computed Attributes
     */
    public function getBorrowedCopiesAttribute(): int
    {
        return $this->total_copies - $this->available_copies;
    }

    public function getIsAvailableAttribute(): bool
    {
        return $this->available_copies > 0 && $this->status === BookStatus::AVAILABLE;
    }

    /**
     * Query Scopes
     */
    public function scopeAvailable($query)
    {
        return $query->where('available_copies', '>', 0)
            ->where('status', BookStatus::AVAILABLE);
    }

    public function scopeUnavailable($query)
    {
        return $query->where(function ($q) {
            $q->where('available_copies', 0)
                ->orWhere('status', '!=', BookStatus::AVAILABLE);
        });
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByAuthor($query, string $author)
    {
        return $query->where('author', 'like', "%{$author}%");
    }

    // protected static function newFactory(): BookFactory
    // {
    //     // return BookFactory::new();
    // }
}
