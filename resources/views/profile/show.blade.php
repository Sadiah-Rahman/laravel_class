<x-app-layout>
    <div class="py-12 max-w-5xl mx-auto">
        <div class="bg-white p-6 rounded shadow flex items-center gap-6">
            <div class="w-20 h-20 bg-gray-300 rounded-full flex items-center justify-center text-2xl">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div class="flex-1">
                <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
                <p class="text-gray-500">{{ $user->email }}</p>
                <p class="text-sm mt-1">{{ $user->bio }}</p>
                <div class="mt-2 font-bold">{{ $user->followers_count }} Followers</div>
            </div>
            <div>
                @auth
                    @if(Auth::id() !== $user->id)
                        @if($isFollowing)
                            <form action="{{ route('user.unfollow') }}" method="POST">
                                @csrf <input type="hidden" name="id" value="{{ $user->id }}">
                                <button class="bg-gray-500 text-white px-4 py-2 rounded">Unfollow</button>
                            </form>
                        @else
                            <form action="{{ route('user.follow') }}" method="POST">
                                @csrf <input type="hidden" name="id" value="{{ $user->id }}">
                                <button class="bg-blue-600 text-white px-4 py-2 rounded">Follow</button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('profile.edit') }}" class="border border-gray-300 px-4 py-2 rounded">Edit Profile</a>
                    @endif
                @endauth
            </div>
        </div>

        <h3 class="text-xl font-bold mt-8 mb-4">Posts</h3>
        @foreach($posts as $post)
            <div class="bg-white p-4 rounded shadow mb-4">
                <p>{{ $post->content }}</p>
                @if($post->image) <img src="{{ asset($post->image) }}" class="mt-2 h-40"> @endif
            </div>
        @endforeach
    </div>
</x-app-layout>