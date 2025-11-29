<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8 bg-white shadow-md rounded-lg p-6">
            
            <form method="POST" action="{{ route('post.update', $post->id) }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea name="content" required class="w-full border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500 h-32">{{ old('content', $post->content) }}</textarea>
                </div>

                @if($post->image)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Current Image</label>
                        <img src="{{ asset($post->image) }}" alt="Current Image" class="mt-2 rounded-md max-h-48 object-cover w-full">
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700">Replace image (optional)</label>
                    <input type="file" name="image" class="block w-full text-sm text-gray-700 mt-1">
                </div>

                <div class="flex gap-2 mt-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-semibold">
                        Save changes
                    </button>
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-md border hover:bg-gray-50 text-gray-700">
                        Cancel
                    </a>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>