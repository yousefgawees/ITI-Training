<!DOCTYPE html>
<html>
<head>

    <title>All Posts</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-gray-100">


<div class="mx-auto max-w-7xl px-4 py-10">


    <!-- Navbar -->

    <div class="mb-8 flex items-center justify-between rounded-xl bg-white p-5 shadow-sm">

        <div>

            <h1 class="text-xl font-bold text-gray-900">
                ITI Blog
            </h1>

            @auth

                <p class="text-sm text-gray-600">
                    Welcome, {{ auth()->user()->name }}
                </p>

            @endauth

        </div>


        <div class="flex items-center gap-3">

            @guest

                <a
                    href="{{ route('login') }}"
                    class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white"
                >
                    Login
                </a>

                <a
                    href="{{ route('register') }}"
                    class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700"
                >
                    Register
                </a>

            @else

                <form action="{{ route('logout') }}" method="POST">

                    @csrf

                    <button
                        type="submit"
                        class="rounded-lg bg-gray-800 px-4 py-2 text-sm font-medium text-white hover:bg-gray-900"
                    >
                        Logout
                    </button>

                </form>

            @endguest

        </div>

    </div>


    <!-- Header -->

    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-3xl font-bold text-gray-900">
                All Posts
            </h1>

            <p class="mt-1 text-gray-600">
                ITI Blog
            </p>

        </div>


        <a
            href="{{ route('posts.create') }}"
            class="rounded-lg bg-indigo-600 px-5 py-3 text-sm font-medium text-white hover:bg-indigo-700"
        >
            + Create Post
        </a>

    </div>


    <!-- Success Message -->

    @if (session('success'))

        <div class="mt-6 rounded-lg bg-green-100 p-4 text-green-800">

            {{ session('success') }}

        </div>

    @endif


    <!-- Posts -->

    <div class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">


        @forelse ($posts as $post)


            <article class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200">


                <!-- Image -->

                @if ($post->image)

                    <img
                        src="{{ asset('storage/' . $post->image) }}"
                        alt="{{ $post->title }}"
                        class="h-52 w-full object-cover"
                    >

                @endif


                <div class="p-6">


                    <!-- User -->

                    @if ($post->user)

                        <p class="text-sm font-medium text-indigo-600">

                            By {{ $post->user->name }}

                        </p>

                    @endif


                    <!-- Title -->

                    <h2 class="mt-2 text-xl font-semibold text-gray-900">

                        {{ $post->title }}

                    </h2>


                    <!-- Description -->

                    <p class="mt-3 text-gray-600">

                        {{ $post->description }}

                    </p>


                    <!-- Buttons -->

                    <div class="mt-6 flex gap-2">


                        <a
                            href="{{ route('posts.show', $post->id) }}"
                            class="rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200"
                        >
                            View
                        </a>


                        @if ($post->user_id == auth()->id())

                            <a
                                href="{{ route('posts.edit', $post->id) }}"
                                class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
                            >
                                Edit
                            </a>


                            <form
                                action="{{ route('posts.destroy', $post->id) }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this post?');"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700"
                                >
                                    Delete
                                </button>

                            </form>

                        @endif


                    </div>


                </div>


            </article>


        @empty


            <div class="col-span-full rounded-xl bg-white p-10 text-center shadow-sm">

                <h2 class="text-xl font-semibold text-gray-900">
                    No Posts Yet
                </h2>

                <p class="mt-2 text-gray-600">
                    Create your first post.
                </p>

            </div>


        @endforelse


    </div>


    <!-- Pagination -->

    <div class="mt-8">

        {{ $posts->links() }}

    </div>


</div>


</body>
</html>