# LivewireStyleable

**Installing:**
```
composer require jey/livewire-styleable
```
___
**Using:**

Component class:
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

```

Blade template
```
<div>
    <div class="row">
        @foreach($posts as $post)
            <div class="col-xs-1 col-md-3 col-lg-4 mb-3">
                <div class="card">
                    <img src="{{ $post->image_url }}" alt="" class="card-img">
                    <div class="card-body" style="">
                        {{ $post->description }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<style scoped lang="scss">
    .card {
        border-radius: 1rem;
        overflow: hidden;
        $card-color: red;
        .card-body {
            color: $card-color;
        }
    }
</style>
