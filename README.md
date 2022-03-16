# LivewireStyleable

**Installing:**
```
composer require jey/livewire-styleable
```

**Using:**

```phpt
<?php

namespace App\View\Component;

use App\Models\Post;
use Jey\LivewireStyleable\HasStyle;
use Livewire\Component;

class LatestPosts extends Component
{

    use HasStyle;

    public function render()
    {
        return view('components.latest-posts', [
            'posts' => Post::published()
                ->latest()
                ->take(3)
                ->get(),
        ]);
    }
}
