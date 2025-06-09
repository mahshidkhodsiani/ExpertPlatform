<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExpertise extends Model
{
    use HasFactory;

    // Make sure your fillable array includes 'category_id'
    protected $fillable = [
        'user_id',
        'title',
        'body',
        'category_id', // Make sure this is present if you allow mass assignment
        'image_path_1',
        'image_path_2',
        'image_path_3',
    ];

    /**
     * Get the user that owns the expertise.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that this expertise belongs to.
     * Define the relationship to the Category model.
     */
    public function category()
    {
        // An expertise belongs to one category.
        // The foreign key is 'category_id' on the user_expertises table.
        // The local key (on the categories table) is 'id' by default.
        return $this->belongsTo(Category::class);
    }
}
