## Synopsis

Trait to automatically create a slug from the title on a Laravel model

## Example

Include the namespace at the top of your model file and 'use' the trait in your class like below.

```php
<?php
namespace App\Page;

use Stuartmccord\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use Sluggable;

    protected $fillable = [
        'title',
        'subtitle',
        'content'
    ];
}
```