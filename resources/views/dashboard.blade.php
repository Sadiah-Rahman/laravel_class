<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <form method="POST" action="{{ route('post.store') }}" enctype="multipart/form-data">
                    @csrf
                    <textarea name="content" placeholder="What's on your mind?" class="w-full border-gray-300 rounded-md mb-2"></textarea>
                    <input type="file" name="image" class="mb-2 text-sm">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Post</button>
                </form>
            </div>

            @foreach($posts as $post)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-4">
                <div class="flex justify-between">
                    <div class="font-bold text-lg">
                        <a href="{{ route('user.show', $post->user_id) }}" class="hover:underline">
                            {{ $post->user->name }}
                        </a>
                        <span class="text-xs text-gray-500 font-normal">{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                    @if(Auth::id() === $post->user_id)
                        <div class="flex gap-2">
                             <a href="{{ route('post.edit', $post->id) }}" class="text-blue-500 text-sm">Edit</a>
                             <form action="{{ route('post.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Delete?');">
                                @csrf 
                                <button type="submit" class="text-red-500 text-sm">Delete</button>
                             </form>
                        </div>
                    @endif
                </div>
                
                <p class="mt-2">{{ $post->content }}</p>
                
                @if($post->image)
                    <img src="{{ asset($post->image) }}" class="mt-4 max-h-96 rounded">
                @endif
            </div>
            @endforeach

        </div>
    </div>
</x-app-layout>